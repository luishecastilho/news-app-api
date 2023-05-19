<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    AuthRegisterRequest,
    AuthLoginRequest
};

use App\Models\User;
use App\Models\UserPreference;
use Auth;

class AuthController extends Controller
{
    public function store(AuthRegisterRequest $request)
    {
        try {
            $data = $request->post();

            $data['password'] = bcrypt($request->password);

            $user = User::create($data);

            $token = $user->createToken('registerToken')->accessToken;

            UserPreference::create(["user_id" => $user->id]);

            return response()->json(["data" => ["user" => $user, "token" => $token], "message" => "User created."], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function login(AuthLoginRequest $request)
    {
        try {
            $data = $request->all();

            Auth::attempt($data);

            $user = Auth::user();
            if($user)
            {
                $token = $user->createToken("loginToken")->accessToken;

                return response()->json(["data" => ["token" => $token],"message" => "Successfully logged in."], 200);
            }
            return response()->json(["data"=> [], "message" => "Error on trying to login. Try again."], 400);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->token()->revoke();

            return response()->json(["data"=> [], "message" => "Successfully logged out."], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
}
