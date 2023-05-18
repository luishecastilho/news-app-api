<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\AuthStoreRequest;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->post();

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('registerToken')->accessToken;

        return ["user" => $user, "token" => $token];
    }

    public function login(Request $request)
    {
        $data = $request->all();

        Auth::attempt($data);

        $user = Auth::user();
        if($user)
        {
            $token = $user->createToken('loginToken')->accessToken;
            return response()->json(['status' => 200, 'token' => $token]);
        }
        return false;
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
