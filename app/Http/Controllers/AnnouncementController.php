<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:announcement-list', ['index']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Announcement::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $actions = [
                        [
                            'id' => 'state-btn',
                            'action' => 'javascript:void(0)',
                            'label' => 'Ubah Status'
                        ],
                        [
                            'id' => 'edit-btn',
                            'action' => 'javascript:void(0)',
                            'label' => 'Edit'
                        ],
                        [
                            'id' => 'delete-btn',
                            'action' => 'javascript:void(0)',
                            'label' => 'Hapus',
                        ]
                    ];

                    return view('components.dashboard.action-buttons', [
                        'id' => $data->id,
                        'datas' => $actions
                    ])->render();
                })
                ->editColumn('status', function ($data) {
                    $status = $data->status;
                    return view('components.table-component.status', compact('status'))->render();
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss');
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        }

        return view('dashboard.announcement.index');
    }
}
