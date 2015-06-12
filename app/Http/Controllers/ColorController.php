<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateColorRequest;
use \App\Color;

class ColorController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $colors = Color::all();
        return response()->json(['data' => $colors], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateColorRequest $request) {
        $values = $request->only([
            'name',
            'hex_code',
        ]);

        // $values['hex_code'] = $this->__prepireHexValue($values['hex_code']);

        Color::create($values);
        return response()->json(['message' => 'The color was created', 'code' => 201], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id`
     * @return Response`
     */
    public function show($id) {
        $color = Color::find($id);
        if (!$color) {
            return response()->json(["error" => 'This color missing', 'code' => 404], 404);
        }
        return response()->json(["data" => $color, 'code' => 200], 200);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(CreateColorRequest $request, $id) {

        $color = Color::find($id);

        if (!$color) {
            return response()->json(["error" => 'This error missing', 'code' => 404], 404);
        }

        $color->name = $request->get('name');
        // $color->hex_code = $this->__prepireHexValue($request->get('hex_code'));

        $color->hex_code = $request->get('hex_code');

        $color->save();
        return response()->json(['message' => 'The color was update', 'code' => 201], 201);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $color = Color::find($id);
        if (!$color) {
            return response()->json(["error" => 'This color missing', 'code' => 404], 404);
        }

        $sizeEvents = $color->event;

        if (sizeof($sizeEvents) > 0) {
            return
            response()
                ->json(
                    [
                        "error" => 'This color have associeted events. Delete Events first!',
                        'code'  => 409,
                    ],
                    409
                );
        }

        $sizeTasks = $color->task;
        if (sizeof($sizeTasks) > 0) {
            response()
                ->json(
                    [
                        "error" => 'This color have associeted tasks. Delete Tasks first!',
                        'code'  => 409,
                    ],
                    409
                );
        }

        if ($color->delete($id)) {
            return response()->json(["message" => 'This color was deleted', 'code' => 200], 200);
        } else {
            return response()->json(["error" => 'There problem with deleted color', 'code' => 500], 500);
        }
        //
    }

    protected function __prepireHexValue($hexCode) {
        $newHexCode = '#' . $hexCode;
        return $newHexCode;
    }
}
