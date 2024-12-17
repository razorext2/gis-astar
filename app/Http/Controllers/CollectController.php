<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CollectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:collect-list', ['only' => 'index']);
        $this->middleware('permission:collect-create', ['only' => 'create']);
        $this->middleware('permission:collect-edit', ['only' => 'edit']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->can('collect-approve')) {
                $query = Collector::latest();
            } else {
                $query = Collector::where('kode_pegawai', '=', Auth::user()->kode_pegawai)->latest();
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('name_code', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'name' => $data->pegawaiRelasi->full_name,
                        'code' => $data->kode_pegawai
                    ]);
                })
                ->addColumn('created_updated_at', function ($data) {
                    return $data->created_at->locale('id')->isoFormat('D MMM YYYY HH:mm:ss');
                })
                ->addColumn('title_status', function ($data) {
                    return view('components.dashboard.title-w-status', [
                        'title' => $data->short_title,
                        'status' => $data->status
                    ])->render();
                })
                ->addColumn('actions', function ($data) {
                    return view('components.dashboard.action-buttons', [
                        'id' => $data->id,
                        'edit' => ['show' => auth()->user()->can('collect-edit'), 'url' => route('collect.edit', $data->id)],
                        'show' => ['show' => auth()->user()->can('collect-list'), 'url' => route('collect.show', $data->id)],
                        'delete' => ['show' => auth()->user()->can('collect-delete')]
                    ])->render();
                })
                ->filter(function ($data) use ($request) {
                    if ($request->filled("title")) {
                        $data->where('title', "LIKE", "%$request->title%");
                    }

                    if ($request->filled("kode_pegawai")) {
                        $data->where('kode_pegawai', "LIKE", "%$request->kode_pegawai%");
                    }

                    if ($request->filled("status")) {
                        $data->where('status', "LIKE", "%$request->status%");
                    }

                    if ($request->filled("startDate")) {
                        $data->whereBetween('created_at', [$request->startDate, $request->endDate]);
                    }
                })
                ->rawColumns(['title_status', 'actions'])
                ->make(true);
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
        $data = Collector::find($id);
        return view('dashboard.collect.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Collector::find($id);
        return view('dashboard.collect.edit', compact('data'));
    }
}
