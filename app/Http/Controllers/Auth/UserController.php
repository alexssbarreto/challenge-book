<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLoggedIn;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validate->fails()) {
            return response($validate->messages(), 400);
        }

        $credentials = $validate->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $success['token'] =  $user->createToken('my-app')->plainTextToken;
            $success['user'] =  new UserResource($user);

            return response()->json($success);
        }

        throw ValidationException::withMessages([
            'email/password' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(null);
    }
}
