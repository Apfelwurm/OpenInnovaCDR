<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneCallEvent;

class PhoneCallEventsController extends Controller
{
    public function index()
    {
        return PhoneCallEvent::all();
    }

    public function show(PhoneCallEvent $phoneCallEvent)
    {
        return $phoneCallEvent;
    }

    public function store(Request $request)
    {
        $phoneCallEvent = PhoneCallEvent::create($request->all());

        return response()->json($phoneCallEvent, 201);
    }

    public function update(Request $request, PhoneCallEvent $phoneCallEvent)
    {
        $phoneCallEvent->update($request->all());

        return response()->json($phoneCallEvent, 200);
    }

    public function delete(PhoneCallEvent $phoneCallEvent)
    {
        $phoneCallEvent->delete();

        return response()->json(null, 204);
    }
}
