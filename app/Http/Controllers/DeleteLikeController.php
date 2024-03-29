<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class DeleteLikeController extends Controller
{
    // if like exists in database, delete it
    public function __invoke(Like $like, Request $request)
    {
        $user = Auth::user();

        DB::table('likes')
            ->where('user_id',  $user->id)
            ->where('movie_id',  $like->movie_id)
            ->delete();

        return redirect('getLikes');
    }
}
