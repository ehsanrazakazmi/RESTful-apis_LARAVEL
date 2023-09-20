<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(){
        
        $array = [
            [
                'name'=>'john',
                'email'=> 'john@gmail.com',
            ],
            [
                'name'=>'mark doe',
                'email'=> 'mark@gmail.com',

            ]
        ];

        return response()->json([
            'message' => '2 Users found',
            'data' => $array,
            'status' => true
        ],200);
    }
}
