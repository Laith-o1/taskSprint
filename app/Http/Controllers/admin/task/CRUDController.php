<?php

namespace App\Http\Controllers\admin\task;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CRUDController extends Controller
{
    // get all tasks with employee and priority where status is not completed
    public function index()
    {
        $tasks = Task::where('status', '!=', 'completed')->get();
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
    // create task
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'employee_id' => 'required',
            'priority_id' => 'required',
            'due_date' => 'required|date',
        ]);
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description, 
            'due_date' => $request->due_date,           
        ]);
        // attach employee to task
        $task->employee()->attach($request->employee_id);
        // attach priority to task
        $task->priority()->attach($request->priority_id);
        // return json response
        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }

    // update task
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'employee_id' => 'required|exiests:employees,id',
            'priority_id' => 'required|exiests:priorities,id',
            'due_date' => 'required|date',
        ]);
        $task = Task::find($id);
        $task->update($request->all());
        // attach employee to task
        $task->employee()->sync($request->employee_id);
        // attach priority to task
        $task->priority()->sync($request->priority_id);
        // return json response
        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task,
        ], 200);
    }
    // delete task
    public function delete($id)
    {
        $task = Task::find($id);
        $task->delete();
        // return json response
        return response()->json([
            'message' => 'Task deleted successfully',
        ], 200);
    }

}
