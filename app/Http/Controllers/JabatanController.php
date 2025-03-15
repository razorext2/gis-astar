<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Placement;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:jabatan-list', ['index']);
        $this->middleware('permission:jabatan-create', ['create']);
        $this->middleware('permission:jabatan-edit', ['edit']);
        $this->middleware('permission:jabatan-delete', ['destroy']);
    }

    public function index(Request $request)
    {
        return view('dashboard.jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $division = Division::all();
        $placement = Placement::all();
        return view('dashboard.jabatan.add', compact('division', 'placement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Jabatan::create([
            'nama_jabatan' => $request->input('nama_jabatan'),
            'divisi' => $request->input('divisi'),
            'penempatan' => $request->input('penempatan')
        ]);

        return redirect()->route('jabatan.index')->with('status', 'Berhasil menambah data Jabatan');
        ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        $division = Division::all();
        $placement = Placement::all();
        return view('dashboard.jabatan.edit', compact('jabatan', 'division', 'placement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $jabatan->update([
            'nama_jabatan' => $request->input('nama_jabatan'),
            'divisi' => $request->input('divisi'),
            'penempatan' => $request->input('penempatan')
        ]);

        return redirect()->route('jabatan.index')->with('status', 'Berhasil mengubah data Jabatan');
        ;
    }
}
