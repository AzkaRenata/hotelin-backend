<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'),200);
    }

    public function index()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'),200);
    }


    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out'],200);
    }


    public function registerCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'user_level' => 'required|integer|max:2|min:1',
            'user_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_level = 2;
        $user->gender = $request->gender;
        $user->telp = $request->telp;
        $user->address = $request->address;

        if(!empty($request->file('user_picture'))) {
            $file = $request->file('user_picture');
            $upload_dest = 'user_picture';
            $extension = $file->extension();
            $path = $file->storeAs(
                $upload_dest, $request->username.'.'.$extension
            );
            $user->user_picture = $path;

        } 
        
        $user->save();
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'string|in:male,female|max:255',
            'telp' => 'string|max:15',
            'address' => 'string|max:255',
            //'user_level' => 'required|integer|max:2|min:1',
            'user_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_level = 1;
        $user->gender = $request->gender;
        $user->telp = $request->telp;
        $user->address = $request->address;

        if(!empty($request->file('user_picture'))) {
            $file = $request->file('user_picture');
            $upload_dest = 'user_picture';
            $extension = $file->extension();
            $path = $file->storeAs(
                $upload_dest, $request->username.'.'.$extension
            );
            $user->user_picture = $path;

        } 
        
        $user->save();
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),200);
    }

    public function update(Request $request){
        $user = Auth::user();
        $id = $user->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,id,$id',
            'email' => 'required|string|email|max:255|unique:users,id,$id',
            'user_level' => 'required|integer|min:1|max:2',
            'user_picture' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_level = $request->user_level;
        $user->gender = $request->gender;
        $user->telp = $request->telp;
        $user->address = $request->address;

        if(!empty($request->file('user_picture'))){
            unlink('storage/'.$user->user_picture);
            $file = $request->file('user_picture');
            $upload_dest = 'user_picture';
            $extension = $file->extension();
            $path = $file->storeAs(
                $upload_dest, $user->username.'.'.$extension
            );
            $user->user_picture = $path;
        }

        $user->save();

        return response()->json(compact('user'));
    }

    public function updatePicture(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'user_picture' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        unlink('storage/'.$user->user_picture);
        $file = $request->file('user_picture');
        $upload_dest = 'user_picture';
        $extension = $file->extension();
        $path = $file->storeAs(
            $upload_dest, $user->username.'.'.$extension
        );
        $user->user_picture = $path;
        $user->save();

        return response()->json(compact('user'));
    }

    public function updatePassword(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        auth()->logout();

        return response()->json(['message' => 'Password Update Successfully'],200);

    }

    public function delete(){

        $user = Auth::user();
    
        unlink('storage/'.$user->user_picture);
        $user->delete();

        return response()->json(['message' => 'Delete Successfully'],200);
    }
    
}
