<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\AuthStoreRequest;

use App\Models\User;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->post();

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return ["user" => $user, "tokenData" => $token, "token" => $token->token];
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
