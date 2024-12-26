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

			$query = Dayoff::with('pegawaiRelasi:kode_pegawai,full_name');

			if (!Auth::user()->can('dayoff-confirm')) {
				$query->where('kode_pegawai', Auth::user()->kode_pegawai);
			}

			// Fetch the filtered data with pagination for DataTables
			return DataTables::of($query)
				->addIndexColumn()
				->editColumn('kode_pegawai', function ($data) {
					return view('components.dashboard.name-w-code', [
						'name' => $data->pegawaiRelasi->full_name,
						'code' => $data->kode_pegawai
					]);
				})
				->editColumn('status', function ($data) {
					return view('components.dashboard.title-w-status', [
						'title' => $data->dayoff_for,
						'status' => $data->status
					])->render();
				})
				->editColumn('created_at', function ($data) {
					return view('components.dashboard.created-updated', [
						'created' => 'From: ' . Carbon::parse($data->tgl_dari)->locale('id')->isoFormat('D MMM YYYY'),
						'updated' => 'To: ' . Carbon::parse($data->tgl_hingga)->locale('id')->isoFormat('D MMM YYYY')
					])->render();
				})
				->editColumn('tgl_dari', function ($data) {
					return view('components.dashboard.name-w-code', [
						'code' => 'Total hari',
						'name' => round(Carbon::parse($data->tgl_dari)->diffInDays(Carbon::parse($data->tgl_hingga)) + 1) . ' hari',
					])->render();
				})
				->addColumn('actions', function ($data) {
					return view('components.dashboard.action-buttons', [
						'id' => $data->id,
						'edit' => ['show' => Auth::user()->can('dayoff-edit'), 'url' => route('dayoff.edit', $data->id)],
						'show' => ['show' => Auth::user()->can('dayoff-list'), 'url' => route('dayoff.show', $data->id)],
						'delete' => ['show' => Auth::user()->can('dayoff-delete')]
					])->render();
				})
				->filter(function ($query) use ($request) {
					if ($request->filled("dayoff_for")) {
						$query->where('dayoff_for', "=", $request->dayoff_for);
					}

					if ($request->filled("kode_pegawai")) {
						$query->where('kode_pegawai', "LIKE", "%{$request->kode_pegawai}%");
					}

					if ($request->filled("status")) {
						$query->where('status', "=", $request->status);
					}

					if ($request->filled("startDate") && $request->filled("endDate")) {
						$query->whereBetween('created_at', [$request->startDate, $request->endDate]);
					}
				})
				->orderColumn('created_at', '-created_at $1')
				->rawColumns(['status', 'kode_pegawai', 'created_at', 'tgl_dari', 'actions'])
				->make(true);
		}

		return view('dashboard.dayoff.index');
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
		$data = Dayoff::with('pegawaiRelasi')->findOrFail($id);
		return view('dashboard.dayoff.detail', compact('data'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id)
	{
		$data = Dayoff::with('pegawaiRelasi')->findOrFail($id);

		return view('dashboard.dayoff.edit', compact('data'));
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
