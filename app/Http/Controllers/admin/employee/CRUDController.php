<?php

namespace App\Http\Controllers\admin\employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:employees',
            'phone' => 'required|unique:employees',
            'password' => 'required|min:6|confirmed',
        ]);
        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,            
            'password' => bcrypt($request->password),
        ]);
        return response([
            'employee' => $employee,
            'message' => 'Employee created successfully',
        ], 200); 
    }
    
}
