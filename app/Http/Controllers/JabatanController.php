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
        if ($request->ajax()) {
            // Start building the query
            $query = Jabatan::query()
                ->with(['divisionRelasi', 'placementRelasi'])
                ->select([
                    'id',
                    'nama_jabatan',
                    'divisi',
                    'penempatan',
                    'created_at',
                    'updated_at'
                ])
                ->orderBy('nama_jabatan', 'asc');

            // Fetch the filtered data with pagination for DataTables
            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $editUrl = route('jabatan.edit', $data->id);

                    $actionButtons = '
            <div class="inline-flex" role="group">';

                    if (auth()->user()->can('jabatan-edit')) {
                        $actionButtons .=
                            '<a href="' . $editUrl . '"class="mx-1 text-md font-medium rounded-lg focus:z-10">
                            &#9999; <span class="hover:underline" style="color: #057A55"> Edit </span>
                        </a>';
                    }

                    if (auth()->user()->can('jabatan-delete')) {
                        $actionButtons .= '
                        <button
                            class="mx-1 group text-md font-medium rounded-lg focus:z-10 delete-btn"
                            data-id="' . $data->id . '" data-modal-target="deleteModal" data-modal-toggle="deleteModal">
                            &#x26D4; <span class="hover:underline" style="color: #E02424;"> Delete </span>
                        </button>';
                    }

                    '</div>';

                    return $actionButtons;
                })
                ->addIndexColumn() // This is the DT_RowIndex
                ->editColumn('nama_divisi', function ($row) {
                    return $row->divisionRelasi->nama_divisi ?? 'N/A';  // Handle null cases
                })
                ->editColumn('nama_penempatan', function ($row) {
                    return $row->placementRelasi->penempatan ?? 'N/A';  // Handle null cases
                })
                ->editColumn('created_updated_at', function ($row) {
                    return $row->created_at . ' / ' . $row->updated_at;
                })
                ->make(true);
        } else {
            return view('dashboard.jabatan.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $division = Division::all();
        $placement = Placement::all();
        return view('dashboard.jabatan.add', compact('division', 'placement'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
        $division = Division::all();
        $placement = Placement::all();
        return view('dashboard.jabatan.edit', compact('jabatan', 'division', 'placement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        //
        $jabatan->update([
            'nama_jabatan' => $request->input('nama_jabatan'),
            'divisi' => $request->input('divisi'),
            'penempatan' => $request->input('penempatan')
        ]);

        return redirect()->route('jabatan.index')->with('status', 'Berhasil mengubah data Jabatan');
        ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('status', 'Berhasil menghapus data Jabatan');
        ;
    }
}
