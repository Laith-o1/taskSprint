<?php

namespace App\Http\Controllers\employee\task;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    // find task by priority_id using the pivot table priority_task
    public function findByPriorityId($priority_id)
    {
        $tasks = Task::whereHas('priority', function($query) use ($priority_id) {
            $query->where('priority_id', $priority_id);
        })->get();
        // filter the $tasks by the authenticated employee id
        $tasks = $tasks->filter(function($task) {
            return $task->employee()->where('employee_id', auth()->guard('employee-api')->user()->id)->get();
        });
        // attach the employee and priority to the task
        foreach($tasks as $task) {
            $task->priority = $task->priority()->get();
        }
          // return json response with tasks and its priority
        return response()->json([
            'message' => 'Tasks found successfully',
            'tasks' => $tasks,
        ], 200);
    }
    // find task by status
    public function findByStatus($status)
    {
        $tasks = Task::where('status', $status)->get();
        // filter the $tasks by the authenticated employee id
        $tasks = $tasks->filter(function($task) {
            return $task->employee()->where('employee_id', auth()->guard('employee-api')->user()->id)->get();
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

}
