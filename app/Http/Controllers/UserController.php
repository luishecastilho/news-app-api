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
        return Auth::user();
    }

    public function update(UserUpdateRequest $request): User
    {
        try{
            $user = User::find(Auth::id());

            $data = $request->post();

            if(isset($request->password)){
                $data['password'] = bcrypt($request->password);
            }

            $user->fill($data);

            $user->save();

            return $user;
        }catch(\Exception $e){
            return $e;
        };
    }

    public function savePreferences(UserSavePreferencesRequest $request)
    {
        // user preferences
        return true;
    }
}
