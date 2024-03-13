<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\DB;

class ManageLikesController extends Controller
{
    public function manageLikes(Request $request)
    {
        //set varables
        $userId = Auth::id();
        $user = Auth::user();

        $id = $request->movieId;
        $apiKey = env('API_KEY');
        if ($request->page && $request->keyword) {
            $page = $request->page;
            $keyword = $request->keyword;
        }

        // check if movie_i already exists in database
        if (DB::table('likes')->where([
            ['movie_id', '=', $id],
            ['user_id', '=', $userId],
        ])->exists()) {
            // if it exists, remove movie from database and redirect user to desktop
            DB::table('likes')->where([
                ['movie_id', '=', $id],
                ['user_id', '=', $userId],
            ])->delete();
            return redirect()->back();
        }
        // if id does not exist, add id to database, then return user
        $response = Http::get('https://api.themoviedb.org/3/movie/' . $id . '?language=en-US&api_key=' . $apiKey);

        $list = $response->object();

        if (isset($list->poster_path)) {
            $poster = $list->poster_path;
        } else {
            $poster = '';
        }
        $like = new Like([
            'movie_id' => $list->id,
            'movie_title' => $list->title,
            'movie_poster' => $poster,
            'movie_rating' => $list->vote_average,
        ]);

        $id = $user->id;
        $like->user_id = $userId;
        $userMethod = User::find($id);
        $userMethod->likes()->save($like);
        unset($apikey);

        // if previous page was Discover, return user with the same page and keyword
        if (isset($page) && isset($keyword)) {
            return redirect()->action(
                [GetMoviesController::class, 'returnToPage'],
                ['page' => $page, 'keyword' => $keyword]
            );
        } else {
            // else redirect to toplist
            return redirect('/getToplist');
        }
    }
}
