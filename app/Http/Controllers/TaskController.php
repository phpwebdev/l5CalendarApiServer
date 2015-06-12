<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\task;

class TaskController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $tasksTmp = task::all();
        foreach ($tasksTmp as $taskId => $taskValue) {

            $tasks[$taskId]             = $taskValue;
            $tasks[$taskId]['color']    = $taskValue->color;
            $tasks[$taskId]['category'] = $taskValue->category;
        }
        return response()->json(['data' => $tasks], 200); //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $task = task::find($id);
        if (!$task) {
            return response()->json(["message" => 'This task missing', 'code' => 404], 404);
        }

        $task['color']    = $task->color;
        $task['category'] = $task->category;

        return response()->json(["data" => $task, 'code' => 200], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
}
