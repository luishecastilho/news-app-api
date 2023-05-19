<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    UserUpdateRequest,
    UserSavePreferencesRequest
};
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function index(): User
    {
        try {
            $user = Auth::user();
            if($user) {
                return response()->json(["data" => ["user" => $user], "message" => "User data."], 200);
            }
            return response()->json(["data" => [], "message" => "Error on trying to get user data. Try again."], 400);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function update(UserUpdateRequest $request): User
    {
        try{
            $user = User::find(Auth::id());

            if(!$user) {
                return response()->json(["data" => [], "message" => "Error on trying to update the user data. Try again."], 400);
            }

            $data = $request->post();

            if(isset($request->password)){
                $data['password'] = bcrypt($request->password);
            }

            $user->fill($data);

            $user->save();

            return $user;
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function savePreferences(UserSavePreferencesRequest $request)
    {
        // user preferences
        return true;
    }
}
