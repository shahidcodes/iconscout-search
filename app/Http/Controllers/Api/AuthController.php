<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $payload = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($payload)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('general_api_token')->plainTextToken
        ]);
    }

    public function register(Request $request)
    {
        try {
            $attr = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6'
            ]);

            $user = User::create([
                'name' => $attr['name'],
                'password' => Hash::make($attr['password']),
                'email' => $attr['email']
            ]);

            return $this->success([
                'token' => $user->createToken('general_api_token')->plainTextToken
            ]);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), $request->all());
        }
    }
}
