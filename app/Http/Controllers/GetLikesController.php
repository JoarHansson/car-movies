<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GetLikesController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        return view('dashboard', [
            'user' => Auth::user(),
            'movieLikes' => ''
        ]);
    }
}
