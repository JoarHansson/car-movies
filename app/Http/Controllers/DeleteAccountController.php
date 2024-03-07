<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class DeleteAccountController extends Controller
{
    public function __invoke(Request $request)
    {

        $user = Auth::user();

        // if password doesn't match what we have in the database:
        if (!Hash::check($request->currentPassword, $user->password)) {

            return redirect()->back()->withErrors('The current password you entered was incorrect.');
        }

        DB::table('users')->where('id',  $user->id)->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Account was successfully deleted.');
    }
}
