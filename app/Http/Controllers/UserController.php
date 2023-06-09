<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    UserUpdateRequest,
    UserSavePreferencesRequest
};
use App\Models\User;
use App\Models\UserPreference;
use Auth;

class UserController extends Controller
{
    public function index()
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

    public function update(UserUpdateRequest $request)
    {
        try{
            $user = User::find(Auth::id());

            if(!$user) {
                return response()->json(["data" => [], "message" => "Error on trying to update the user data. Try again."], 400);
            }

            $data = $request->post();

            $user->name = $data["name"];

            if($data["email"] !== $user->email) {
                $user->email = $data["email"];
            }

            if(isset($request->password) && $request->password != ""){
                $data['password'] = bcrypt($request->password);
                $user->password = $data["password"];
            }

            $user->save();

            return $user;
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function getPreferencesString()
    {
        try {
            $user = Auth::user();
            $userPreference = UserPreference::where('user_id', $user->id)->first();
            if($user) {
                $string = "";
                if($userPreference){
                    if($userPreference["sources"]!==null || $userPreference["sources"] !== ""){
                        $string .= $userPreference["sources"].",";
                    }
                    if($userPreference["categories"]!==null || $userPreference["categories"] !== ""){
                        $string .= $userPreference["categories"].",";
                    }
                    if($userPreference["authors"]!==null || $userPreference["authors"] !== ""){
                        $string .= $userPreference["authors"].",";
                    }
                }
                return response()->json(["data" => ["data" => trim($string, ",")], "message" => "User preferences."], 200);
            }
            return response()->json(["data" => [], "message" => "Error on trying to get user preferences. Try again."], 400);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function getPreferences()
    {
        try{
            $user = User::find(Auth::id());

            if(!$user) {
                return response()->json(["data" => [], "message" => "Error User not found. Try again."], 400);
            }

            $userPreference = UserPreference::where('user_id', $user->id)->first();

            if($userPreference){
                return response()->json(["data" => ["sources" => $userPreference["sources"], "categories" => $userPreference["categories"], "authors" => $userPreference["authors"]], "message" => "User preferences."], 200);
            }else{
                return response()->json(["data" => ["sources" => [], "categories" => [], "authors" => []], "message" => "User preferences."], 200);
            }
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function savePreferences(UserSavePreferencesRequest $request)
    {
        try{
            $user = User::find(Auth::id());

            if(!$user) {
                return response()->json(["data" => [], "message" => "Error User not found. Try again."], 400);
            }

            $userPreference_id = UserPreference::where('user_id', $user->id)->first();

            if($userPreference_id){
                $userPreference = UserPreference::find($userPreference_id["id"]);
                $userPreference->fill($request->post());
                $userPreference->save();

                return $userPreference;
            }else{
                $userPreference = UserPreference::create([
                    "sources" => $request?->sources,
                    "categories" => $request?->categories,
                    "authors" => $request?->authors,
                    "user_id" => $user->id
                ]);

                return $userPreference;
            }
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
}
