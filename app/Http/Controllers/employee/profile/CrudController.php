<?php

namespace App\Http\Controllers\employee\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    // update employee profile
    public function update(Request $request)
    {
        $this->validate($request, [
            // 'name' => '',
            'email' => "email|unique:employees,email,".auth()->guard('employee-api')->user()->id,
            'phone' => "unique:employees,phone,".auth()->guard('employee-api')->user()->id,
            'password' => 'min:6',
            // 'address' => '',
        ]);
        $employee = auth()->guard('employee-api')->user();
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
    // update employee profile avatar
    public function updateAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $employee = auth()->guard('employee-api')->user();
        // check if the employee has an avatar
        if($employee->avatar) {
            // delete the old avatar
            unlink(public_path('uploads/employees/avatars/'.$employee->avatar));
        }
        // get the avatar from the request
        $avatar = $request->file('avatar');
        // create a unique name for the avatar
        $avatarName = time() . '.' . $avatar->extension();
        // move the avatar to the avatars folder
        $avatar->move(public_path('uploads/employees/avatars'), $avatarName);
        // update the employee avatar
        $employee->update([
            'avatar' => $avatarName,
        ]);
        // return json response
        return response()->json([
            'message' => 'Employee avatar updated successfully',
            'employee' => $employee,
        ], 200);
    }
}
