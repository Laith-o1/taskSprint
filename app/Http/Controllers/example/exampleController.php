<?php

namespace App\Http\Controllers\example;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class exampleController extends Controller
{
    public function mock(){

 return response()->json([
    'message' => 'success',
 ],200);
    
}
}
