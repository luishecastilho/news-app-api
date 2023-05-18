<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function index(): User
    {
        return Auth::user();
    }

    public function update(Request $request): User
    {
        try{
            $user = User::find(Auth::id());

            $user->fill($request->post());

            $user->save();

            return $user;
        }catch(\Exception $e){
            return $e;
        };
    }

    public function savePreferences(Request $request)
    {
        // user preferences
        return true;
    }
}
