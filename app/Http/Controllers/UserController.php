<?php

namespace App\Http\Controllers;

use App\Models\image;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json([
            'message' => count($users).' users found!',
            'data' => $users,
            'status'  => true
        ]);
    }
    public function show($id){
    $user =    User::find($id);

    if($user != null){
        return response()->json(['message'=>'success','data'=>$user,'status'=>true],200);
    }

    else{
        return response()->json(['message'=>'not found!','data'=>'nothing jul' ,'status'=>true],200);
    }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
            'message' => 'Please fix the errors',
            'errors' => $validator->errors(),
            'status'  => false
        ],200);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json([
            'message' => 'Added succefully',
            'data' => $user,
            'status'  => true
        ,200]);
    }

    public function update(Request $request,    $id){
        $user = User::find($id);
        if($user ==null){
            return response()->json([
                'message' =>'user not found',
                'status' =>false
            ],200);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if($validator->fails()){
            return response()->json([
            'message' => 'Please fix the errors',
            'errors' => $validator->errors(),
            'status'  => false
        ],200);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' =>'user updated successfuly',
            'data' => $user,
            'status' =>false
        ],200);

    }
    public function destroy($id){
        $user = User::find($id);
        if($user ==null){
            return response()->json([
                'message' =>'user not found',
                'status' =>false
            ],200);
        }

        $user->delete();
        
        return response()->json([
            'message' =>'user deleted successfuly',
           
            'status' =>true
        ],200);
    }

    public function upload(Request $request){
        $validator = Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg,jpeg,gif'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'fix the issue masla',
                'errors' =>$validator->errors()
            ]);
        }
        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time(). '.'.$ext;
        $img->move(public_path().'/uploads/', $imageName);

        $image = new image;
        $image->image = $imageName;
        $image->save();
        return response()->json([
            'status' => true,
            'message' => 'image uploaded success',
            'path'=> asset('uploads/'.$imageName),
            'data' =>   $image
        ]);
    }


}