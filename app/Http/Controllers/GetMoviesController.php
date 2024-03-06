<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class GetMoviesController extends Controller
{
    public function __invoke(Request $request)
    {
        // get movies based on car racing as keyword
        $keywords= [
            '310324',
            '830-car-race',
            '233981',
            '10039-racing'
        ];
        $randomKeyword = rand(0,3);
        $randomInt = rand(1, 3);
        $apiKey = env('API_KEY');
        $response = Http::get('https://api.themoviedb.org/3/keyword/' . $keywords[$randomKeyword]. '/movies?include_adult=false&language=en-US&page=' . $randomInt . '&sort_by=popularity.desc&api_key=' . $apiKey);
        unset($apiKey);

        $list = $response->object();

        return view('dashboard', [
            'user' => Auth::user(),
            'movieList' => $list,
        ]);
    }
    public function getToplist() {
        $apiKey = env('API_KEY');
        $response = Http::get('https://api.themoviedb.org/3/keyword/233981/movies?include_adult=false&language=en-US&page=1&sort_by=popularity.desc&api_key=' . $apiKey);
        unset($apiKey);

        $list = $response->object();

        return view('dashboard', [
            'user' => Auth::user(),
            'topList' => $list,
        ]);
    }
}
