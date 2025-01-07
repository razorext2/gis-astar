<?php

namespace App\Http\Controllers\Api;

use App\Models\Dayoff;
use App\Http\Resources\DayoffResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Validator;

class ApiDayoffController extends Controller
{
    public function store(Request $request)
    {
        // Mendefinisikan validator
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|integer|max_digits:32',
            'dayoff_for' => 'required|string|min:2|max:10',
            'tgl_dari' => 'required|date|min:5|max:32',
            'tgl_hingga' => 'required|date|min:5|max:32',
            'keterangan' => 'required|string|min:5',
        ]);

        // Validasi data
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // Mengirim status 422 untuk validasi gagal
        }

        // Menambah data jika validasi berhasil
        $data = $validator->validated();
        $query = Dayoff::create($data);

        // kembalikan response JSON
        return new DayoffResource(true, 'Data berhasil ditambah!', $query);
    }

    public function update(Request $request, $id)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'dayoff_for' => 'required|string',
            'tgl_dari' => 'required|date',
            'tgl_hingga' => 'required|date',
            'keterangan' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $query = Dayoff::find($id);
        $query->update([
            'dayoff_for' => $request->dayoff_for,
            'tgl_dari' => $request->tgl_dari,
            'tgl_hingga' => $request->tgl_hingga,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->isJson()) {
            return new DayoffResource(true, 'Data berhasil diubah!', $query);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah!',
            'data' => $query
        ]);
    }

    public function approve(Request $request, $id)
    {
        $query = Dayoff::find($id);
        $query->update([
            'status' => 1,
            'validate_by' => $request->validate_by,
        ]);

        return new DayoffResource(true, 'Data berhasil dikonfirmasi', null);
    }

    public function deny(Request $request, $id)
    {
        $query = Dayoff::find($id);
        $query->update([
            'status' => 2,
            'notes' => $request->notes,
            'validate_by' => $request->validate_by,
        ]);

        return new DayoffResource(true, 'Data berhasil dikonfirmasi', null);
    }

    public function destroy(string $id)
    {
        $query = Dayoff::find($id);
        $query->delete();

        return new DayoffResource(true, 'Data berhasil dihapus!', null);
    }
}
