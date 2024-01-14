<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:250",
            "phone" => "required|string|max:250|unique:users",
            "password" => "required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $user = new User;
        $user->name = $request->input("name");
        $user->phone = $request->input("phone");
        $user->password = Hash::make($request->input("password"));
        $user->invite_code = Str::random(6);
        $user->save();

        Auth::login($user);

        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'message' => 'Success',
        ])->withCookie($cookie);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only("phone", "password"))) {
            return response([
                "message" => "Invalid credentials!",
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'message' => 'Success',
        ])->withCookie($cookie);
    }
    public function user()
    {
        return Auth::user();
    }
    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response(['message' => 'Success'])->withCookie($cookie);
    }
}
