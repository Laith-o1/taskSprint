<?php

namespace App\Http\Controllers\admin\task;

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
            // attach the employee and priority to the task
            foreach($tasks as $task) {
                $task->employee = $task->employee()->get();
                $task->priority = $task->priority()->get();
            }
              // return json response with tasks and its priority
            return response()->json([
                'message' => 'Tasks found successfully',
                'tasks' => $tasks,
            ], 200);
        }
        // find task by employee_id using the pivot table employee_task
        public function findByEmployeeId($employee_id)
        {
            $tasks = Task::whereHas('employee', function($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })->get();
            // attach the employee and priority to the task
            foreach($tasks as $task) {
                $task->employee = $task->employee()->get();
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
            // attach the employee and priority to the task
            foreach($tasks as $task) {
                $task->employee = $task->employee()->get();
                $task->priority = $task->priority()->get();
            }
              // return json response with tasks and its priority
            return response()->json([
                'message' => 'Tasks found successfully',
                'tasks' => $tasks,
            ], 200);
        }
}
