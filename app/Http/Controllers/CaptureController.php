<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;

class CaptureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:capture', ['index']);
    }

    public function index()
    {
        if (!is_null(Auth::user()->kode_pegawai)) {
            $data = Pegawai::leftJoin('tb_jabatan', 'tb_pegawai.jabatan', '=', 'tb_jabatan.id') // Join the tb_jabatan table first
                ->leftJoin('tb_placement', function ($join) {
                    $join->on('tb_jabatan.penempatan', '=', 'tb_placement.id'); // Now use the join between tb_jabatan and tb_placement
                })
                ->where('kode_pegawai', Auth::user()->kode_pegawai)
                ->firstOrFail();
            return view('dashboard.capture.index', compact('data'));
        } else {
            $data = Pegawai::leftJoin('tb_jabatan', 'tb_pegawai.jabatan', '=', 'tb_jabatan.id') // Join the tb_jabatan table first
                ->leftJoin('tb_placement', function ($join) {
                    $join->on('tb_jabatan.penempatan', '=', 'tb_placement.id'); // Now use the join between tb_jabatan and tb_placement
                })
                ->firstOrFail();
            return view('dashboard.capture.index', compact('data'));
        }
    }
}
