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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer|max_digits:32',
            'dayoff_for' => 'required|string|min:2|max:10',
            'tgl_dari' => 'required|date|min:5|max:32',
            'tgl_hingga' => 'required|date|min:5|max:32',
            'keterangan' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Menyelipkan status dengan nilai 0 (pending)
        $data['status'] = 0;

        // Simpan data
        $query = Dayoff::create($data);

        if ($request->isJson()) {
            return new DayoffResource(true, 'Data berhasil ditambah!', $query);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambah!',
            'data' => $query
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
