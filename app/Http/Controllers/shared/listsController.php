<?php

namespace App\Http\Controllers\shared;

use App\Models\Priority;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Database\Seeders\prioritySeeder;

class listsController extends Controller
{
    public function statues()
    {
        $lists = ['complited', 'pending', 'in progress'];
        return response()->json([
            'message' => 'Lists found successfully',
            'lists' => $lists,
        ], 200);
    }
    public function priorities()
    {
        $lists = Priority::all();
        return response()->json([
            'message' => 'Lists found successfully',
            'lists' => $lists,
        ], 200);
    }

}
