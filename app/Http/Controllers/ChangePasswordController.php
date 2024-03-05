<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Components\FlashMessages;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\password;

class ChangePasswordController extends Controller
{

    public function __invoke(Request $request)
    {

        $user = Auth::user();

        // if password doesn't match what we have in the database:
        if (!Hash::check($request->currentPassword, $user->password)) {

            return Redirect::back()->withErrors('The current password you entered was incorrect.');
        }


        DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => Hash::make($request->newPassword)]);


        return redirect('/accountManager')->with('message', 'Password was changed successfully.');
    }
}
