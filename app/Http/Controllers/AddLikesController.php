<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\DB;

class AddLikesController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();
        $id = $request->input('movieId');
        $apiKey = env('API_KEY');

         if (DB::table('likes')->where([
                ['movie_id', '=', $id],
                ['user_id', '=', $userId],
            ])->exists())
            {
                return redirect()->back();
            } else {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $id . '?language=en-US&api_key=' . $apiKey);
            $list = $response->object();
            $like = new Like([
                'movie_id' => $list->id,
                'movie_title' => $list->title,
                'movie_poster' => $list->poster_path,
                'movie_rating' => $list->vote_average,
            ]);

            $id = $user->id;
            $like->user_id = $userId;
            $userMethod = User::find($id);
            $userMethod->likes()->save($like);
            unset($apikey);
            return redirect()->back();
        }
    }
}
