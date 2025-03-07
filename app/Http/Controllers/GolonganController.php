<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class GolonganController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:golongan-list', ['index']);
        $this->middleware('permission:golongan-create', ['create']);
        $this->middleware('permission:golongan-edit', ['edit']);
        $this->middleware('permission:golongan-delete', ['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Start building the query
            $query = Golongan::query()
                ->with('jadwalRelasi')
                ->orderBy('nama_golongan', 'asc');

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $editUrl = route('golongan.edit', $data->id);

                    // Inisialisasi variabel untuk tombol aksi
                    $actionButtons = '
                    <div class="inline-flex" role="group">';

                    // Cek izin edit
                    if (auth()->user()->can('golongan-edit')) {
                        $actionButtons .= '
                        <a href="' . $editUrl . '"class="mx-1 text-md font-medium rounded-lg focus:z-10">
                            &#9999; <span class="hover:underline" style="color: #057A55"> Edit </span>
                        </a>';
                    }

                    if (auth()->user()->can('golongan-delete')) {
                        // Tambahkan tombol delete
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
                ->addColumn('jadwal_relasi', function ($data) {
                    if ($data->jadwalRelasi->isEmpty()) {
                        return 'N/A';
                    }

                    // Construct the HTML for the schedule
                    $schedule = '';
                    foreach ($data->jadwalRelasi as $j) {
                        $schedule .= '
                        <div class="flex">
                            <div class="flex-none w-12">
                                ' . $j->hari . '
                            </div>
                            <div class="flex-1">
                                ( ' . $j->jam_masuk . ' - ' . $j->jam_keluar . ' )
                            </div>
                        </div>';
                    }
                    return $schedule;
                })
                ->editColumn('created_updated_at', function ($data) {
                    return $data->created_at . ' / ' . $data->updated_at;
                })
                ->addIndexColumn() // This is the DT_RowIndex
                ->rawColumns(['jadwal_relasi', 'action'])
                ->make(true);
        } else {
            return view('dashboard.golongan.index');
        }
    }

    public function create()
    {
        return view('dashboard.golongan.add');
    }

    public function store(Request $request)
    {
        $golongan = Golongan::create([
            'nama_golongan' => $request->input('nama_golongan'),
            'alias' => $request->input('alias'),
        ]);

        $id_golongan = $golongan->id;
        $jadwal = [];
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        foreach ($days as $day) {
            $jadwal[$day] = [
                'jam_masuk' => $request->input("jam_masuk_$day"),
                'jam_keluar' => $request->input("jam_keluar_$day"),
            ];
        }

        foreach ($jadwal as $day => $times) {
            Jadwal::create([
                'id_golongan' => $id_golongan,
                'hari' => ucfirst($day),
                'jam_masuk' => $times['jam_masuk'],
                'jam_keluar' => $times['jam_keluar'],
            ]);
        }


        return redirect()->route('golongan.index')->with('status', 'Berhasil menambah data golongan.');
    }

    public function edit($id)
    {
        $golongan = Golongan::with('jadwalRelasi')->findOrFail($id);
        return view('dashboard.golongan.edit', compact('golongan'));
    }


    public function update(Request $request, Golongan $golongan)
    {
        $golongan->update([
            'nama_golongan' => $request->input('nama_golongan'),
            'alias' => $request->input('alias'),
        ]);


        $id_golongan = $golongan->id;

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        foreach ($days as $day) {
            $jamMasuk = $request->input("jam_masuk_" . strtolower($day));
            $jamKeluar = $request->input("jam_keluar_" . strtolower($day));

            Jadwal::updateOrCreate(
                [
                    'id_golongan' => $id_golongan,
                    'hari' => ucfirst($day),
                ],
                [
                    'jam_masuk' => $jamMasuk,
                    'jam_keluar' => $jamKeluar,
                ]
            );
        }

        return redirect()->route('golongan.index')->with('status', 'Berhasil mengubah data golongan');
    }

    public function destroy($id)
    {
        $golongan = Golongan::findOrFail($id);
        $golongan->delete();

        return redirect()->route('golongan.index')->with('status', 'Berhasil menghapus data golongan');
    }
}
