<?php

namespace App\Http\Controllers;

use App\Models\BigEvent;
use App\Models\BigEventParticipant;
use App\Models\BigEventParticipantVisitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BigEventController extends Controller
{
    public function index()
    {
        return view('dashboard.event.index');
    }

    public function create()
    {
        return view('dashboard.event.create');
    }

    public function edit($id)
    {
        $event = BigEvent::findOrFail($id);

        return view('dashboard.event.edit', compact('event'));
    }

    public function show($id)
    {
        $event = BigEvent::findOrFail($id);

        return view('dashboard.event.show', compact('event'));
    }

    public function participantDetails($event, $participant)
    {
        $participant = BigEventParticipant::findOrFail($participant);

        return view('dashboard.event.participant-detail', compact('participant'));
    }

    public function store(Request $request)
    {
        // validate data
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|min:5|max:100',
            'location' => 'required|min:5|max:100',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required|in:active,inactive,ongoing',
            'description' => 'required|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $query = BigEvent::create([
            'name' => $request->event_name,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        if ($query) {
            return redirect()->route('event.index')->with('status', 'Event berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Event gagal ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $event = BigEvent::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'event_name' => 'required|min:5|max:100',
            'location' => 'required|min:5|max:100',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required|in:active,inactive,ongoing',
            'description' => 'required|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $query = $event->update([
            'name' => $request->event_name,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        if ($query) {
            return redirect()->route('event.index')->with('status', 'Event berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Event gagal diupdate');
    }

    public function storeParticipantVisitor(Request $request, $event_id, $participant_id)
    {
        $ip = $request->ip();
        $ua = Str::limit((string) $request->userAgent(), 255, '');
        $buck = now()->setMicroseconds(0);



        $data = BigEventParticipant::where('id', $participant_id)
            ->where('big_event_id', $event_id)
            ->firstOrFail();

        $key = 'visit:' . $participant_id . ':' . $ip . ':' . md5($ua ?? '');

        RateLimiter::attempt(
            $key,
            1, // max 1 kali
            function () use ($request, $participant_id, $ip, $ua, $buck) {
                $request_all = $request->headers->all();
                $real_info = json_encode($request_all);

                BigEventParticipantVisitor::insertOrIgnore([
                    'participant_id' => $participant_id,
                    'ip' => $ip,
                    'ua' => $ua,
                    'second_bucket' => $buck,
                    'real_info' => $real_info,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            },
            2 // detik dedupe window
        );

        return redirect()->away($data->redirect_to);
    }

}
