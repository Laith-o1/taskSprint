<?php

namespace App\Http\Controllers\employee\task;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrudController extends Controller
{
    // get the Employee tasks useing the auth guard employee and the employee id
    public function index()
    {
        $user = auth()->guard('employee-api')->user();
        // get the tasks where the employee id is the same as the authenticated employee id
        $tasks = Task::whereHas('employee', function($query) use ($user) {
            $query->where('employee_id', $user->id);
        })->get();
        // filter the $tasks by status
        $tasks = $tasks->filter(function($task) {
            return $task->status != 'completed';
        });
        // attach the priority to the task
        foreach($tasks as $task) {
            $task->priority = $task->priority()->get();
        }
        // return json response with tasks and its priority
        return response()->json([
            'message' => 'Tasks found successfully',
            'tasks' => $tasks,
        ], 200);
    }
    // update task status
    public function update(Request $request, $id)
    {
        // check if the user is assigned to the task
        $user = auth()->guard('employee-api')->user();
        $task = Task::find($id);
        if(!$task->employee()->where('employee_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'You are not assigned to this task',
            ], 401);
        }
        $this->validate($request, [
            'status' => 'required|in:pending,in progress,completed',
        ]);
        $task = Task::find($id);
        $task->update([
            'status' => $request->status,
        ]);
        // return json response
        return response()->json([
            'message' => 'Task updated successfully',
            // 'task' => $task,
            'response' => $request->all(),
            'id' => $id,
        ], 200);
    }
}
