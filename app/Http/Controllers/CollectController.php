<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class CollectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:collect-list', ['only' => 'index']);
        $this->middleware('permission:collect-create', ['only' => 'create']);
        $this->middleware('permission:collect-edit', ['only' => 'edit']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Collector::with('pegawaiRelasi:kode_pegawai,full_name');

            if (!Auth::user()->can('collect-approve')) {
                $query->where('kode_pegawai', Auth::user()->kode_pegawai);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('kode_pegawai', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'name' => $data->pegawaiRelasi->full_name,
                        'code' => $data->kode_pegawai
                    ]);
                })
                ->editColumn('created_at', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => $data->created_at->locale('id')->isoFormat('D MMMM YYYY'),
                        'time' => $data->created_at->locale('id')->isoFormat('HH:mm:ss')
                    ])->render();
                })
                ->editColumn('title', function ($data) {
                    return view('components.dashboard.title-w-status', [
                        'title' => $data->short_title,
                        'status' => $data->status
                    ])->render();
                })
                ->addColumn('actions', function ($data) {
                    return view('components.dashboard.action-buttons', [
                        'id' => $data->id,
                        'edit' => ['show' => Auth::user()->can('collect-edit'), 'url' => route('collect.edit', $data->id)],
                        'show' => ['show' => Auth::user()->can('collect-list'), 'url' => route('collect.show', $data->id)],
                        'delete' => ['show' => Auth::user()->can('collect-delete')]
                    ])->render();
                })
                ->editColumn('latitude', function ($data) {
                    return view('components.dashboard.location-w-coordinate', [
                        'lat' => $data->latitude,
                        'long' => $data->longitude,
                        'location' => $data->location
                    ])->render();
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled("title")) {
                        $query->where('title', "LIKE", "%{$request->title}%");
                    }

                    if ($request->filled("kode_pegawai")) {
                        $query->where('kode_pegawai', "LIKE", "%{$request->kode_pegawai}%");
                    }

                    if ($request->filled("status")) {
                        $query->where('status', "LIKE", "%{$request->status}%");
                    }

                    if ($request->filled("startDate") && $request->filled("endDate")) {
                        $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
                    }
                })
                ->rawColumns(['kode_pegawai', 'title', 'actions', 'latitude', 'created_at'])
                ->toJson();
        }

        return view('dashboard.collect.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.collect.add');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Cache::remember('collector_data_' . $id, 1800, function () use ($id) {
            return Collector::findOrFail($id);
        });

        return view('dashboard.collect.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Cache::remember('collector_data_' . $id, 1800, function () use ($id) {
            return Collector::findOrFail($id);
        });

        return view('dashboard.collect.edit', compact('data'));
    }
}
