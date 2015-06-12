<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStatusRequest;
use App\Status;

class StatusController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $status = Status::all();
        return response()->json(['data' => $status], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateStatusRequest $request) {
        $values = $request->only([
            'name',
        ]);
        Status::create($values);
        return response()->json(['message' => 'The status was created', 'code' => 201], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $status = Status::find($id);
        if (!$status) {
            return response()->json(["error" => 'This status missing', 'code' => 404], 404);
        }
        return response()->json(["data" => $status, 'code' => 200], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(CreateStatusRequest $request, $id) {
        $status = Status::find($id);
        if (!$status) {
            return response()->json(["error" => 'This status missing', 'code' => 404], 404);
        }

        $status->name = $request->get('name');
        $status->save();
        return response()->json(['message' => 'The status was update', 'code' => 201], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $status = Status::find($id);
        if (!$status) {
            return response()->json(["error" => 'This status missing', 'code' => 404], 404);
        }

        $sizeEvents = $status->event;
        if (sizeof($sizeEvents) > 0) {
            return
            response()
                ->json(
                    [
                        "error" => 'This status have associeted events. Delete Events first!',
                        'code'  => 409,
                    ],
                    409
                );
        }

        if ($status->delete($id)) {
            return response()->json(["message" => 'This status was deleted', 'code' => 200], 200);
        } else {
            return response()->json(["error" => 'There problem with deleted status', 'code' => 500], 500);
        }
    }
}
