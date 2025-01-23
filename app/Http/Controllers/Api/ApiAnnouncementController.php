<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\BroadcastNewAnnouncementJob;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiAnnouncementController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $announcement = Announcement::create($request->all());

        if (!$announcement) {
            return new ApiResource(false, 'Pengumuman gagal ditambahkan', null);
        }

        BroadcastNewAnnouncementJob::dispatch($announcement)
            ->delay(now()
                ->addSeconds(5));

        Announcement::where('id', '!=', $announcement->id)
            ->update([
                'status' => 0,
            ]);

        $count = Announcement::count();

        if ($count > 20) {
            Announcement::orderBy('created_at', 'asc')
                ->limit(10)
                ->delete();
        }

        return new ApiResource(true, 'Pengumuman berhasil ditambahkan', $announcement);
    }

    public function changeState(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'state' => 'integer|max_digits:1',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Gagal mengubah status pengumuman', $validator->errors());
        }

        $query = Announcement::findOrFail($id);

        if ($query->status == $request->state) {
            return new ApiResource(false, 'Status pengumuman saat ini sama dengan status yang diubah', null);
        }

        $query->update([
            'status' => $request->state,
        ]);

        if ($query->status == 1) {
            BroadcastNewAnnouncementJob::dispatch($query)
                ->delay(now()
                    ->addSeconds(5));
        }

        return new ApiResource(true, 'Status pengumuman berhasil diubah', $query);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        $query = Announcement::findOrFail($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        $query->delete();

        return new ApiResource(true, 'Data berhasil dihapus', null);
    }
}
