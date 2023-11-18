<?php

namespace App\Http\Controllers\admin\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    // update profile
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => "email|unique:admins,email,".auth()->guard('admin')->user()->id,
            'phone' => "unique:admins,phone,".auth()->guard('admin')->user()->id,
            'password' => 'min:6',
            // 'address' => '',
        ]);
        $admin = auth()->guard('admin')->user();
        $admin->update([
            // use tryinary operator to check if the request has a value
            'name' => $request->name ? $request->name : $admin->name,
            'email' => $request->email ? $request->email : $admin->email,
            'phone' => $request->phone ? $request->phone : $admin->phone,
            'address' => $request->address ? $request->address : $admin->address,           
            'password' => $request->password ? bcrypt($request->password) : $admin->password,
        ]);
        // return json response
        return response()->json([
            'message' => 'Admin updated successfully',
            'admin' => $admin,
        ], 200);
    }
    // update profile avatar
    public function updateAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $admin = auth()->guard('admin')->user();
        // check if the admin has an avatar
        if($admin->avatar) {
            // delete the old avatar
            unlink(public_path('uploads/admins/avatars/'.$admin->avatar));
        }
        // get the avatar from the request
        $avatar = $request->file('avatar');
        // create a unique name for the avatar
        $avatarName = time() . '.' . $avatar->extension();
        // move the avatar to the avatars folder
        $avatar->move(public_path('uploads/admins/avatars'), $avatarName);
        // update the admin avatar
        $admin->update([
            'avatar' => $avatarName,
        ]);
        // return json response
        return response()->json([
            'message' => 'Admin avatar updated successfully',
            'admin' => $admin,
        ], 200);
    }
}
