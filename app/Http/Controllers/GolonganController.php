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
        $this->middleware('permission:golongan-list', ['only' => 'index']);
        $this->middleware('permission:golongan-create', ['only' => 'create']);
        $this->middleware('permission:golongan-edit', ['only' => 'edit']);
        $this->middleware('permission:golongan-delete', ['only' => 'destroy']);
    }

    public function index(Request $request)
    {
        return view('dashboard.golongan.index');
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
}
