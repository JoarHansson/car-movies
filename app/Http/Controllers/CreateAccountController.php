<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CreateAccountController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors('There is already an account with this email address.');
        }

        User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password'])
        ]);

        if (Auth::attempt($credentials)) {

            return redirect('/dashboard')->with('message', 'Account created successfully.');
        }
    }
}
