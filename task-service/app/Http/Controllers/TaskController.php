<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = TaskController::getUserId($request);

        $tasks = Task::where('user_id', $userId)->get();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = TaskController::getUserId($request);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'status' => 'string|in:pending,completed',
            'due_date' => 'date|nullable',
            'user_id' => 'required|integer',
        ]);
        if ($validated['user_id'] != $userId) {
            return response()->json(['error' => 'User id mismatch'], 400);
        }

        $task = Task::create(array_merge($validated, ['user_id' => $userId]));
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        
        $userId = TaskController::getUserId($request);
        if ($task->user_id != $userId) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $userId = TaskController::getUserId($request);
        if ($task->user_id != $userId) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string|nullable',
            'status' => 'string|in:pending, completed, in_progress',
            'due_date' => 'date|nullable',
            'user_id' => 'integer',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $userId = TaskController::getUserId($request);
        if ($task->user_id != $userId) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    private static function getUserId(Request $request)
    {
        $decodedUser = $request->attributes->get('user');
        $userId = $decodedUser->id;
        return $userId;
    }
}
