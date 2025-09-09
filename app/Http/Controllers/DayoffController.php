<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Dayoff;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class DayoffController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	function __construct()
	{
		$this->middleware('permission:dayoff-list', ['only' => 'index']);
		$this->middleware('permission:dayoff-create', ['only' => 'create']);
		$this->middleware('permission:dayoff-edit', ['only' => 'edit']);
		$this->middleware('permission:dayoff-delete', ['only' => 'destroy']);
	}

	public function index(Request $request)
	{
		$query = Dayoff::with('pegawaiRelasi:kode_pegawai,full_name');

		if (!Auth::user()->can('dayoff-confirm')) {
			$query->where('kode_pegawai', Auth::user()->kode_pegawai);
		}

		if ($request->ajax()) {
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
						'status' => $data->status == 2 ? '3' : $data->status,
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
						'datas' => [
							[
								'id' => 'show-btn',
								'permission' => Auth::user()->can('dayoff-list'),
								'action' => route('dayoff.show', $data->id),
								'label' => 'Detail',
							],
							[
								'id' => 'edit-btn',
								'permission' => Auth::user()->can('dayoff-edit'),
								'action' => route('dayoff.edit', $data->id),
								'label' => 'Edit',
							],
							[
								'id' => 'delete-btn',
								'permission' => Auth::user()->can('dayoff-delete'),
								'action' => 'javascript:void(0)',
								'label' => 'Hapus',
							]
						],
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
				->rawColumns(['status', 'kode_pegawai', 'created_at', 'tgl_dari', 'actions'])
				->toJson();
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

	/**
	 * Display the specified resource.
	 */
	public function show($id)
	{
		$data = Dayoff::with('pegawaiRelasi', 'user')->findOrFail($id);

		return view('dashboard.dayoff.detail', compact('data'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id)
	{
		$data = Cache::remember('dayoff_data_' . $id, 300, function () use ($id) {
			return Dayoff::with('pegawaiRelasi')->findOrFail($id);
		});

		return view('dashboard.dayoff.edit', compact('data'));
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
		$dayoff = Dayoff::find($id);
		$dayoff->delete();

		return response()->json([
			'success' => true,
			'message' => 'Berhasil menghapus pengajuan!',
		]);
	}
}
