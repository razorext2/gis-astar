<?php

namespace App\Http\Controllers\Api;

use App\Models\Collector;
use App\Models\PhotoCollect;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

// class ApiCollectorController extends Controller
class ApiCollectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Collector::with('pegawaiRelasi:kode_pegawai,full_name')
            ->orderBy('status', 'asc')
            ->latest();

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name_code', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'name' => $data->pegawaiRelasi->full_name,
                        'code' => $data->kode_pegawai
                    ]);
                })
                ->addColumn('created_updated_at', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => $data->created_at->locale('id')->isoFormat('D MMMM YYYY'),
                        'time' => $data->created_at->locale('id')->isoFormat('HH:mm:ss')
                    ])->render();
                    // return $data->created_at->locale('id')->isoFormat('D MMM YYYY HH:mm:ss');
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
                        'edit' => ['show' => true, 'url' => route('collect.edit', $data->id)],
                        'show' => ['show' => true, 'url' => route('collect.show', $data->id)],
                        'delete' => ['show' => true]
                    ])->render();
                })
                ->editColumn('location', function ($data) {
                    return view('components.dashboard.location-w-coordinate', [
                        'lat' => $data->latitude,
                        'long' => $data->longitude,
                        'location' => $data->location
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
                ->rawColumns(['name_code', 'title_status', 'actions', 'location', 'created_updated_at'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        // Mendefinisikan validator
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|integer|max_digits:12',
            'title' => 'required|string|max:128|min:5',
            'keterangan' => 'required|string|min:5',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'location' => 'required|string|min:1',
            'images' => 'required|array', // Menambahkan validasi untuk array gambar
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi tiap gambar
        ]);

        // Validasi data
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // Mengirim status 422 untuk validasi gagal
        }

        // Menambah data ke tabel Collector jika validasi berhasil
        $data = $validator->validated();
        $collector = Collector::create($data);

        // Memastikan folder 'public/collector' ada, buat jika belum ada

        $folderPath = "public/collectors"; // Consistent path

        // Always use public disk
        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);

            // Optional: Set permissions if needed
            chmod(storage_path('app/public/' . $folderPath), 0755);
        }

        // Menyimpan gambar dan menambahkan ke tabel tb_photo_collect
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Membuat nama gambar random
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                // Menyimpan gambar ke folder 'public/collector'
                $imagePath = $folderPath . "/" . $imageName;
                Storage::put($imagePath, file_get_contents($image));

                // Mendapatkan URL gambar
                $imageUrl = Storage::url('collectors/' . $imageName); // Change path to storage/app/public

                // Menyimpan informasi gambar ke tabel tb_photo_collect
                PhotoCollect::create([
                    'id_collect' => $collector->id,
                    'photourl' => $imageUrl,
                ]);
            }
        }

        // Jika request JSON, kembalikan response JSON
        if ($request->isJson()) {
            return new CollectResource(true, 'Data berhasil ditambah!', $collector);
        }

        // Response default jika bukan request JSON
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambah!',
            'data' => $collector
        ]);
    }

    public function update(Request $request, $id)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:128|min:5',
            'keterangan' => 'required|string|min:5',
            'location' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $query = Collector::find($id);
        $query->update([
            'title' => $request->title,
            'keterangan' => $request->keterangan,
            'location' => $request->location,
        ]);

        // Jika request JSON, kembalikan response JSON
        if ($request->isJson()) {
            return new CollectResource(true, 'Data berhasil ditambah!', $query);
        }

        // Response default jika bukan request JSON
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambah!',
            'data' => $query
        ]);
    }

    public function confirmCollect($id)
    {
        $query = Collector::find($id);
        $query->update([
            'status' => 1,
        ]);

        return new CollectResource(true, 'Data berhasil dikonfirmasi', null);
    }

    public function denyCollect(Request $request, $id)
    {
        $query = Collector::find($id);
        $query->update([
            'status' => 2,
            'notes' => $request->notes,
        ]);

        return new CollectResource(true, 'Data berhasil ditolak', null);
    }

    public function destroy($id)
    {
        $query = Collector::find($id);
        $query->delete();

        return new CollectResource(true, 'Data berhasil dihapus', null);
    }
}
