<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountManagerController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('accountManager', ['user' => Auth::user()]);
    }
}
