<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    //log in the user if they exist in the database, else return an error
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect('/getToplist');
        } else {
            return back()->withErrors('Something went wrong! Please try again.');
        }
    }
}
