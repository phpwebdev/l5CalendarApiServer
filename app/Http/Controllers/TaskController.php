<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Task;

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
        return response()->json(['data' => $tasks, 'code' => 200], 200); //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateTaskRequest $request) {
        $values = $request->only([
            'title',
            'description',
            'location',
            'color_id',
            'start_at',
            'end_at',
            'repeatable',
            'interval',
            'category_id',
        ]);
        Task::create($values);
        return response()->json(['message' => 'The Task was created', 'code' => 201], 201);
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
            return response()->json(["error" => 'This task missing', 'code' => 404], 404);
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
    public function update(CreateTaskRequest $request, $id) {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(["error" => 'This task missing', 'code' => 404], 404);
        }

        $task->title       = $request->get('title');
        $task->description = $request->get('description');
        $task->location    = $request->get('location');
        $task->color_id    = $request->get('color_id');
        $task->start_at    = $request->get('start_at');
        $task->end_at      = $request->get('end_at');
        $task->repeatable  = $request->get('repeatable');
        $task->interval    = $request->get('interval');
        $task->category_id = $request->get('category_id');

        $task->save();
        return response()->json(['message' => 'The task was update', 'code' => 201], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(["error" => 'This task missing', 'code' => 404], 404);
        }
        if ($task->delete($id)) {
            return response()->json(["message" => 'This task was deleted', 'code' => 200], 200);
        } else {
            return response()->json(["error" => 'There problem with deleted task', 'code' => 500], 500);
        }
    }
}
