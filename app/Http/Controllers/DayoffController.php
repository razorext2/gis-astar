<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Dayoff;
use App\Models\Pegawai;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DayoffController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	function __construct()
	{
		$this->middleware('permission:dayoff-list', ['only' => ['index']]);
		$this->middleware('permission:dayoff-create', ['only' => ['create', 'store']]);
		$this->middleware('permission:dayoff-edit', ['only' => ['edit', 'update']]);
		$this->middleware('permission:dayoff-delete', ['only' => ['destroy']]);
		$this->middleware('permission:dayoff-confirm', ['only' => ['confirm', 'ignore']]);
	}

	public function index(Request $request)
	{
		if ($request->ajax()) {
			// Start building the query
			if (!Auth::user()->kode_pegawai) {
				// Fetch all Dayoff records with pegawaiRelasi relationship for specific roles
				$query = Dayoff::with('pegawaiRelasi')
					->latest()
					->get();
			} else {
				// Fetch only Dayoff records for the currently logged-in user's pegawaiRelasi
				$query = Dayoff::with('pegawaiRelasi')
					->where('id_user', Auth::user()->kode_pegawai)
					->latest()
					->get();
			}

			// Fetch the filtered data with pagination for DataTables
			return DataTables::of($query)
				->addIndexColumn()
				->editColumn('id_nama_user', function ($data) {
					return '<p>' . $data->pegawaiRelasi->full_name . '</p><span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300"> ' . $data->id_user . ' </span>';
				})
				->editColumn('statuses', function ($data) {
					$status = $data->status;
					if ($status == 1) {
						return '<span class="px-4 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full ring-1 dark:ring-gray-700 dark:bg-green-900 ring-gray-300 dark:text-green-300"> Diterima </span>';
					} elseif ($status == 0) {
						return '<span class="px-4 py-1 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-full ring-1 dark:ring-gray-700 dark:bg-yellow-900 ring-gray-300 dark:text-yellow-300"> Diajukan </span>';
					} elseif ($status == 2) {
						return '<span class="px-4 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full ring-1 dark:ring-gray-700 dark:bg-red-900 ring-gray-300 dark:text-red-300"> Ditolak </span>';
					} else {
						return '<span class="px-4 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full ring-1 dark:ring-gray-700 dark:bg-red-900 ring-gray-300 dark:text-red-300"> Dibatalkan </span>';
					}
				})
				->editColumn('created_updated_at', function ($data) {
					return $data->created_at . ' / ' . $data->updated_at;
				})
				->rawColumns(['statuses', 'id_nama_user'])
				->make(true);
		} else {
			return view('dashboard.dayoff.index');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('dashboard.dayoff.add');
	}

	public function autocomplete(Request $request)
	{
		$search = $request->input('query'); // Mengambil input dari request

		// Cari nama pengguna berdasarkan input
		$users = Pegawai::select(['id', 'kode_pegawai', 'full_name'])
			->where('full_name', 'LIKE', "%{$search}%")
			->limit(10)
			->get();

		return response()->json($users); // Kembalikan hasil sebagai JSON
	}

	public function uploadImage(Request $request)
	{
		$request->validate([
			'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
		]);

		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$path = $image->store('uploads', 'public'); // Simpan file di folder 'public/uploads'

			return response()->json(['url' => Storage::url($path)]); // Kembalikan URL gambar yang diupload
		}

		return response()->json(['error' => 'Gagal mengupload gambar'], 500);
	}

	/**
	 * Display the specified resource.
	 */
	public function show($id)
	{
		$dayoff = Dayoff::with('pegawaiRelasi')->findOrFail($id);
		return view('dashboard.dayoff.detail', compact('dayoff'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id)
	{
		//
		$dayoff = Dayoff::with('pegawaiRelasi')->findOrFail($id);

		return view('dashboard.dayoff.edit', compact('dayoff'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Dayoff $dayoff)
	{
		//
		$dayoff->update([
			'id_user' => $request->input('kode_pegawai'),
			'dayoff_for' => $request->input('dayoff_for'),
			'url' => null,
			'tgl_dari' => $request->input('start_time'),
			'tgl_hingga' => $request->input('end_time'),
			'keterangan' => $request->input('keterangan'),
		]);

		return redirect()->route('dayoff.index')->with('status', 'Berhasil mengubah pengajuan');
	}

	public function confirm(Dayoff $dayoff)
	{
		$dayoff->update(['status' => 1]);

		return redirect()->route('dayoff.index')->with('status', 'Berhasil menyetujui pengajuan');
	}

	public function ignore(Dayoff $dayoff)
	{
		$dayoff->update(['status' => 3]);

		return redirect()->route('dayoff.index')->with('status', 'Berhasil menolak pengajuan');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
		//
		$dayoff = Dayoff::find($id);
		$dayoff->delete();

		return response()->json([
			'success' => true,
			'message' => 'Berhasil menghapus pengajuan!',
		]);
	}
}
