<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->successStatus = 200;
        $this->createdStatus = 201;
        $this->noContentStatus = 204;
        $this->badRequestStatus = 400;
        $this->unAuthorizedStatus = 401;
        $this->forbiddenStatus = 403;
        $this->notFoundStatus = 404;
        $this->notAcceptableStatus = 406;
        $this->unproccessableEntryStatus = 422;
    }
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
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
        $user->role = 'admin';
        if ($user->save()) {
            $response['message'] = "Successfully created ". $user->role;
            $response['data']['user'] = ['name'=>$user->name,'email'=>$user->email,'role' => 'user'];
            $response['data']['token'] = $user->createToken('job-app')->plainTextToken;
            return response()->json($response,$this->createdStatus);
        }
        $response['message'] = "User could not be registered.";
        return response()->json($response,$this->unprocessableEntryStatus);
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
