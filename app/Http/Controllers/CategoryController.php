<?php

namespace App\Http\Controllers;
use App\Category;
use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Task;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $categories = Category::all();
        return response()->json(['data' => $categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request) {
        $values = $request->only([
            'name',
        ]);

        Category::create($values);
        return response()->json(['message' => 'The category was created', 'code' => 201], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(["error" => 'This category missing', 'code' => 404], 404);
        }
        return response()->json(["data" => $category, 'code' => 200], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(CreateCategoryRequest $request, $id) {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(["error" => 'This category error missing', 'code' => 404], 404);
        }

        $category->name = $request->get('name');
        $category->save();
        return response()->json(['message' => 'The category was update', 'code' => 201], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(["error" => 'This category missing', 'code' => 404], 404);
        }

        $sizeEvents = $category->event;
        if (sizeof($sizeEvents) > 0) {
            return
            response()
                ->json(
                    [
                        "error" => 'This category have associeted events. Delete Events first!',
                        'code'  => 409,
                    ],
                    409
                );
        }

        $sizeTasks = $category->task;
        if (sizeof($sizeTasks) > 0) {
            response()
                ->json(
                    [
                        "error" => 'This category have associeted tasks. Delete Tasks first!',
                        'code'  => 409,
                    ],
                    409
                );
        }

        if ($category->delete($id)) {
            return response()->json(["message" => 'This category was deleted', 'code' => 200], 200);
        } else {
            return response()->json(["error" => 'There problem with deleted category', 'code' => 500], 500);
        }

    }
}
