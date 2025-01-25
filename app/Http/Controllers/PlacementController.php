<?php

namespace App\Http\Controllers;

use App\Models\Placement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PlacementController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:placement-list', ['only' => ['index']]);
        $this->middleware('permission:placement-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:placement-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:placement-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Parse the minDate and maxDate from the request after cleaning
            $minDate = $request->input('minDate');
            $maxDate = $request->input('maxDate');

            // Start building the query
            $query = Placement::get();

            // Apply date filtering if minDate and maxDate are provided
            if ($minDate) {
                $query = $query->where('created_at', '>=', Carbon::parse($minDate)->startOfDay());
            }
            if ($maxDate) {
                $query = $query->where('created_at', '<=', Carbon::parse($maxDate)->endOfDay());
            }

            // Fetch the filtered data with pagination for DataTables
            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $editUrl = route('placement.edit', $data->id);

                    // Inisialisasi variabel untuk tombol aksi
                    $actionButtons = '
                <div class="inline-flex" role="group">';

                    // Cek izin edit
                    if (auth()->user()->can('placement-edit')) {
                        $actionButtons .= '
                        <a href="' . $editUrl . '"class="mx-1 text-md font-medium rounded-lg focus:z-10">
                            &#9999; <span class="hover:underline" style="color: #057A55"> Edit </span>
                        </a>';
                    }

                    if (auth()->user()->can('placement-delete')) {
                        // Tambahkan tombol delete
                        $actionButtons .= '
                        <button class="mx-1 group text-md font-medium rounded-lg focus:z-10 delete-btn"
                            data-id="' . $data->id . '" data-modal-target="deleteModal" data-modal-toggle="deleteModal">
                            &#x26D4; <span class="hover:underline" style="color: #E02424;"> Delete </span>
                        </button>';
                    }

                    '</div>';

                    return $actionButtons;
                })
                ->addIndexColumn() // This is the DT_RowIndex
                ->editColumn('restrict_app', function ($data) {
                    if ($data->restrict_app == 'y')
                        return 'Aplikasi dibatasi';
                    elseif ($data->restrict_app == 't')
                        return 'Aplikasi tidak dibatasi';
                    else
                        return 'N/A';
                })
                ->editColumn('longitude_latitude', function ($data) {
                    return '<p>Longitude: ' . $data->longitude . '</p><p>Latitude: ' . $data->latitude . '</p>';
                })
                ->editColumn('created_updated_at', function ($data) {
                    return $data->created_at . ' / ' . $data->updated_at;
                })
                ->editColumn('radius', function ($data) {
                    return $data->radius . ' M';
                })
                ->rawColumns(['action', 'longitude_latitude'])
                ->make(true);
        } else {
            return view('dashboard.placement.index');
        }
    }

    public function create()
    {
        return view('dashboard.placement.add');
    }

    public function store(Request $request)
    {
        //
        Placement::create([
            'kode_penempatan' => $request->input('kode_penempatan'),
            'penempatan' => $request->input('penempatan'),
            'alamat' => $request->input('alamat'),
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
            'radius' => $request->input('radius'),
            'restrict_app' => $request->input('restrict_app'),
        ]);

        return redirect()->route('placement.index')->with('status', 'Berhasil menambah data penempatan.');
    }

    public function edit(Placement $placement)
    {
        //
        return view('dashboard.placement.edit', compact('placement'));
    }

    public function update(Request $request, Placement $placement)
    {
        //
        $placement->update([
            'kode_penempatan' => $request->input('kode_penempatan'),
            'penempatan' => $request->input('penempatan'),
            'alamat' => $request->input('alamat'),
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
            'radius' => $request->input('radius'),
            'restrict_app' => $request->input('restrict_app'),
        ]);

        return redirect()->route('placement.index')->with('status', 'Berhasil mengubah data penempatan');
    }

    public function destroy(Placement $placement)
    {
        //
        $placement->delete();

        return redirect()->route('placement.index')->with('status', 'Berhasil menghapus data penempatan');
    }
}
