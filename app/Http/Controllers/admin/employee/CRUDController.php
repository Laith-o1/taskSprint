<?php

namespace App\Http\Controllers\admin\employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
    // get all employees
    public function index()
    {
        $employees = Employee::all();
        // return json response with employees
        return response()->json([
            'message' => 'Employees found successfully',
            'employees' => $employees,
        ], 200);
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:employees',
            'phone' => 'required|unique:employees',
            'password' => 'required|min:6',
            'address' => 'required',
        ]);
        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, 
            'address' => $request->address,           
            'password' => bcrypt($request->password),
        ]);
        // return json response
        return response()->json([
            'message' => 'Employee created successfully',
            'employee' => $employee,
        ], 201);
    }
    // update employee
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => "email|unique:employees,email,$id",
            'phone' => "unique:employees,phone,$id",
        ]);
        $employee = Employee::find($id);
        $employee->update([
            // use tryinary operator to check if the request has a value
            'name' => $request->name ? $request->name : $employee->name,
            'email' => $request->email ? $request->email : $employee->email,
            'phone' => $request->phone ? $request->phone : $employee->phone,
            'address' => $request->address ? $request->address : $employee->address,           
            'password' => $request->password ? bcrypt($request->password) : $employee->password,
        ]);
        // return json response
        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee,
        ], 200);
    }
    // delete employee
    public function delete($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        // return json response
        return response()->json([
            'message' => 'Employee deleted successfully',
        ], 200);
    }

    
}
