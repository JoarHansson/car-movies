<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GetLikesController extends Controller
{
    public function __invoke()
    {
        //test the id-function for likes that we load from the database later
        /*         $movieId = [500, 200, 550];
        $apiKey = env('API_KEY');
        foreach ($movieId as $id) {
            $response = Http::get('https://api.themoviedb.org/3/movie/' . $id . '?language=en-US&api_key=' . $apiKey);
            $list[] = $response->object();
        }
        unset($apiKey); */
        $user = Auth::user();
        return view('dashboard', [
            'user' => Auth::user(),
            'movieLikes' => ''
        ]);
    }
}
