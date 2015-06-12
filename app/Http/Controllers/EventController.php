<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;

class EventController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $eventsTmp = Event::all();
        foreach ($eventsTmp as $eventId => $eventValue) {

            $events[$eventId]             = $eventValue;
            $events[$eventId]['color']    = $eventValue->color;
            $events[$eventId]['status']   = $eventValue->status;
            $events[$eventId]['category'] = $eventValue->category;
        }
        return response()->json(['data' => $events], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateEventRequest $request) {

        $values = $request->only([
            'title',
            'description',
            'location',
            'color_id',
            'start_at',
            'end_at',
            'status_id',
            'repeatable',
            'interval',
            'category_id',
        ]);

        Event::create($values);
        return response()->json(['message' => 'The event was created', 'code' => 201], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(["error" => 'This event missing', 'code' => 404], 404);
        }

        $event['color']    = $event->color;
        $event['status']   = $event->status;
        $event['category'] = $event->category;

        return response()->json(["data" => $event, 'code' => 200], 200);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(CreateEventRequest $request, $id) {

        $event = Event::find($id);

        if (!$event) {
            return response()->json(["message" => 'This event missing', 'code' => 404], 404);
        }

        $event->title       = $request->get('title');
        $event->description = $request->get('description');
        $event->location    = $request->get('location');
        $event->color_id    = $request->get('color_id');
        $event->start_at    = $request->get('start_at');
        $event->end_at      = $request->get('end_at');
        $event->status_id   = $request->get('status_id');
        $event->repeatable  = $request->get('repeatable');
        $event->interval    = $request->get('interval');
        $event->category_id = $request->get('category_id');

        $event->save();
        return response()->json(['message' => 'The event was update', 'code' => 201], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(["error" => 'This event missing', 'code' => 404], 404);
        }
        if ($event->delete($id)) {
            return response()->json(["message" => 'This event was deleted', 'code' => 200], 200);
        } else {
            return response()->json(["error" => 'There problem with deleted event', 'code' => 500], 500);
        }}
}
