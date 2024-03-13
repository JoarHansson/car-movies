<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class GetMoviesController extends Controller
{
    public function generateMovies(Request $request)
    {

        // Get movies based on car racing as keyword
        $keywords = [
            '830-car-race', // car race
            '233981', // f1
            '10039-racing', // racing
            '1749', //taxi driver
        ];

        $randomKeyword = rand(0, 3); // generate random keyword
        $tag = $keywords[$randomKeyword];
        $randomInt = rand(1, 4); // get random page number
        $apiKey = env('API_KEY');

        $response = Http::get('https://api.themoviedb.org/3/keyword/' . $tag . '/movies?include_adult=false&language=en-US&page=' . $randomInt . '&sort_by=popularity.desc&api_key=' . $apiKey);
        unset($apiKey);

        $list = $response->object();

        $allLikes = DB::table('likes')->where([
            ['user_id', '=', Auth::id()],
        ])->get();

        $liked = collect($allLikes)->pluck('movie_id');

        return view('dashboard', [
            'user' => Auth::user(),
            'movieList' => $list,
            'page' => $randomInt,
            'keyword' => $tag,
            'liked' => $liked,
        ]);
    }

    // Get top movies with cars tag
    public function getToplist()
    {
        $apiKey = env('API_KEY');
        $response = Http::get('https://api.themoviedb.org/3/keyword/233981/movies?include_adult=false&language=en-US&page=1&sort_by=popularity.desc&api_key=' . $apiKey);
        unset($apiKey);

        $list = $response->object();


        $allLikes = DB::table('likes')->where([
            ['user_id', '=', Auth::id()],
        ])->get();

        $liked = collect($allLikes)->pluck('movie_id');

        return view('dashboard', [
            'user' => Auth::user(),
            'topList' => $list,
            'liked' => $liked,
        ]);
    }

    // Return to the previous page with the page and keyword intact
    public function returnToPage(Request $request)
    {

        $apiKey = env('API_KEY');
        if (isset($request->keyword) && isset($request->keyword)) {
            $keyword = $request->keyword;
            $page = $request->page;
        } else {
            $keyword = '';
            $page = '';
        }

        $response = Http::get('https://api.themoviedb.org/3/keyword/' . $keyword . '/movies?include_adult=false&language=en-US&page=' . $page . '&sort_by=popularity.desc&api_key=' . $apiKey);
        unset($apiKey);
        $list = $response->object();

        $allLikes = DB::table('likes')->where([
            ['user_id', '=', Auth::id()],
        ])->get();

        $liked = collect($allLikes)->pluck('movie_id');

        return view('dashboard', [
            'user' => Auth::user(),
            'movieList' => $list,
            'page' => $page,
            'keyword' => $keyword,
            'liked' => $liked,
        ]);
    }
}
