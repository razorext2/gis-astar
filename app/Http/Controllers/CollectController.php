<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class CollectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:collect-list', ['only' => ['index', 'approved', 'submitted', 'rejected', 'revision']]);
        $this->middleware('permission:collect-edit', ['only' => 'edit']);
    }

    public function index(Request $request)
    {
        return view('dashboard.collect.subcontent.main');
    }

    public function approved()
    {
        return view('dashboard.collect.subcontent.approved');
    }

    public function submitted()
    {
        return view('dashboard.collect.subcontent.submitted');
    }

    public function rejected()
    {
        return view('dashboard.collect.subcontent.rejected');
    }

    public function revision()
    {
        return view('dashboard.collect.subcontent.revision');
    }

    public function showdata(Request $request)
    {
        // 1. Optimized Eager Loading (Select specific columns for lower memory footprint)
        $query = Collector::query()
            ->with([
                'pegawaiRelasi:kode_pegawai,full_name',
                'collectTaskRelasi:no_sr,customer_recipient,customer_name',
                'collectTaskPpnRelasi:tax_invoice,customer_recipient,customer_name',
                'collectIdyPpnRelasi:tax_invoice,customer_recipient,customer_name',
            ])
            ->whereNull('deleted_at');

        $user = auth()->user();

        // 2. Base Restriction
        if ($user->hasRole('Collector')) {
            $query->where('kode_pegawai', $user->kode_pegawai);
        }

        // 3. Consolidated Status Filtering
        $statusValue = match ($request->get('s')) {
            'approved' => 1,
            'submitted' => 2,
            'rejected' => 3,
            'revision' => 4,
            default => 0,
        };

        $query->where('status', $statusValue);

        // Additional restriction for new data (status 0)
        if ($statusValue == 0 && ! $user->can('collect-approve')) {
            $query->whereDate('assign_date', today());
        }

        $query->latest();

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_sr', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'code' => $data->short_title ?? 'N/A',
                        'name' => $data->no_sr ?? 'N/A',
                        'item3' => $data->pegawaiRelasi->full_name ?? 'N/A',
                    ]);
                })
                ->editColumn('title', function ($data) {
                    // Extract recipient name based on bill type
                    $recipient = match ($data->bill_type) {
                        'idcnonppn' => $data->collectTaskRelasi->customer_recipient ?? 'N/A',
                        'idcppn' => $data->collectTaskPpnRelasi->customer_recipient ?? 'N/A',
                        'idyppn' => $data->collectIdyPpnRelasi->customer_recipient ?? 'N/A',
                        default => 'N/A',
                    };

                    return view('components.dashboard.title-w-status', [
                        'title' => strtoupper($recipient).' ( '.strtoupper($data->bill_type ?? 'N/A').' )',
                        'status' => $data->status ?? 'N/A',
                        'item3' => $data->location ?? 'N/A',
                    ]);
                })
                ->editColumn('payment_type', function ($data) {
                    $paidStatuses = [
                        0 => 'Belum bayar',
                        1 => 'Cicilan',
                        2 => 'Lunas',
                        3 => 'Tanda terima',
                        4 => 'Ada Kendala',
                        5 => 'Antar bon lunas',
                    ];

                    $types = [
                        0 => 'Tidak ada',
                        1 => 'Cash',
                        2 => 'Transfer',
                        3 => 'Giro',
                    ];

                    $statusLabel = $paidStatuses[$data->have_paid] ?? 'N/A';
                    $typeLabel = $types[$data->payment_type] ?? 'N/A';

                    if (in_array($data->have_paid, [1, 2])) {
                        return view('components.table-component.payment-detail', [
                            'status' => $data->have_paid,
                            'data' => [
                                ['title' => 'Status', 'data' => $statusLabel],
                                ['title' => 'Metode', 'data' => $typeLabel],
                                ['title' => 'Bayar', 'data' => Number::currency($data->payment_amount ?? 0, 'IDR', 'id')],
                            ],
                        ]);
                    }

                    return $statusLabel;
                })
                ->editColumn('created_at', function ($data) {
                    $date = $data->assign_at ?? ($data->assign_date ?? '00:00:00');
                    $carbonDate = Carbon::parse($date)->locale('id');

                    return view('components.dashboard.custom-date', [
                        'date' => $carbonDate->isoFormat('D MMMM YYYY'),
                        'time' => $carbonDate->isoFormat('HH:mm:ss'),
                    ]);
                })
                ->addColumn('actions', function ($data) {
                    $actions = [
                        ['id' => 'show-btn', 'action' => route('collect.show', $data->id), 'label' => 'Detail'],
                    ];

                    if (auth()->user()->can('collect-edit') && $data->status != 1) {
                        $actions[] = ['id' => 'edit-btn', 'action' => route('collect.edit', $data->id), 'label' => 'Edit'];
                    }

                    if (auth()->user()->can('collect-delete') && $data->status == 0) {
                        $actions[] = ['id' => 'delete-btn', 'action' => 'javascript:void(0)', 'label' => 'Hapus'];
                    }

                    if (! auth()->user()->hasRole('Collector')) {
                        return view('components.dashboard.action-buttons', [
                            'id' => $data->id,
                            'datas' => $actions,
                            'reschedule' => auth()->user()->can('collect-approve') && $data->status == 0,
                            'changeCollector' => auth()->user()->can('collect-approve') && $data->status == 0,
                        ]);
                    }

                    // For Collectors
                    if ($data->status == 0) {
                        return view('components.dashboard.single-button', [
                            'id' => $data->id,
                            'data' => ['id' => 'editBtn'.$data->id, 'action' => route('collect.edit', $data->id), 'label' => 'Lengkapi'],
                        ]);
                    }

                    return view('components.dashboard.single-button', [
                        'id' => $data->id,
                        'data' => ['id' => 'detailBtn'.$data->id, 'action' => route('collect.show', $data->id), 'label' => 'Detail'],
                    ]);
                })
                ->filter(function ($query) use ($request) {
                    // Grouped title search to prevent security leaks
                    if ($request->filled('title')) {
                        $query->where(function ($q) use ($request) {
                            $term = "%{$request->title}%";
                            $q->whereHas('collectTaskRelasi', fn ($sq) => $sq->where('customer_name', 'LIKE', $term))
                                ->orWhereHas('collectTaskPpnRelasi', fn ($sq) => $sq->where('customer_name', 'LIKE', $term))
                                ->orWhereHas('collectIdyPpnRelasi', fn ($sq) => $sq->where('customer_name', 'LIKE', $term));
                        });
                    }

                    if ($request->filled('no_sr')) {
                        $query->where('no_sr', 'LIKE', "%{$request->no_sr}%");
                    }

                    if ($request->filled('bill_type')) {
                        $query->where('bill_type', $request->bill_type);
                    }

                    if ($request->filled('kode_pegawai')) {
                        $query->where('kode_pegawai', 'LIKE', "%{$request->kode_pegawai}%");
                    }

                    if ($request->filled('startDate') && $request->filled('endDate')) {
                        $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
                    }
                })
                ->rawColumns(['actions', 'no_sr', 'title', 'payment_type', 'created_at'])
                ->toJson();
        }
    }

    public function show($id)
    {
        $data = Collector::with('photoCollectRelasi', 'pegawaiRelasi')->findOrFail($id);

        if (auth()->user()->hasRole('Collector') && auth()->user()->kode_pegawai != $data->kode_pegawai) {
            return abort(403);
        }

        $user = User::select('id', 'name')->where('id', $data->validate_by)->first();

        return view('dashboard.collect.detail', compact('data', 'user'));
    }

    public function edit($id)
    {
        $data = Collector::with('photoCollectRelasi', 'pegawaiRelasi', 'collectTaskRelasi', 'collectTaskPpnRelasi')->findOrFail($id);

        if (auth()->user()->hasRole('Collector') && auth()->user()->kode_pegawai != $data->kode_pegawai) {
            return abort(403);
        }

        return view('dashboard.collect.edit', compact('data'));
    }
}
