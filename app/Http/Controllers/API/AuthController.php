<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->successStatus = 200;
        $this->createdStatus = 201;
        $this->notFoundStatus = 404;
        $this->unprocessableEntryStatus = 422;
    }
    public function login (Request $request)
    {
        $response = array();
        $response['message'] = null;
        $response['data'] = null;
        $request->validate([
            'email' => 'required|email|',
            'password' => 'required|',
        ]);
        $user = User::where('email',$request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            $response['message'] = "The credentials do not match with our records";
            return response()->json($response,$this->notFoundStatus);
        }
        $response['data']['user'] = ['name'=>$user->name,'email'=>$user->email,'role' => $user->role];
        $response['data']['token'] = $user->createToken('job-app')->plainTextToken;
        return response()->json($response,$this->createdStatus);
    }
    
    public function logout (Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $response['message'] = 'Successfully logged out';
        $response['data'] = null;
        return response()->json($response,$this->successStatus);   
    }
    
    public function register (Request $request)
    {
        $response = array();
        $response['message'] = null;
        $response['data'] = null;
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:'.with(new User)->getTable().',email',
            'password' => 'required|string|min:5',
        ]);
        
        $user = new User();
        $user->name = strtoupper(trim($request->name));
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->role = "user";
        if ($user->save()) {
            $response['message'] = "Successfully registered";
            $response['data']['user'] = ['name'=>$user->name,'email'=>$user->email,'role' => 'user'];
            $response['data']['token'] = $user->createToken('job-app')->plainTextToken;
            return response()->json($response,$this->createdStatus);
        }
        $response['message'] = "Registration could not be completed";
        return response()->json($response,$this->unprocessableEntryStatus);
    }
    
    
}
