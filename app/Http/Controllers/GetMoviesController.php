<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GetMoviesController extends Controller
{
    public function __invoke(Request $request)
    {
        // get movies based on car racing as keyword
        $keywords= [
            '310324',
            '830-car-race',
            '233981',
            '286354',
        ];
        $randomInt = rand(1, 8);
        $apiKey = env('API_KEY');
        $response = Http::get('https://api.themoviedb.org/3/keyword/830-car-race/movies?include_adult=false&language=en-US&page=' . $randomInt . '&sort_by=popularity.desc&api_key=' . $apiKey);
        unset($apiKey);

        $list = $response->object();

        return view('dashboard', [
            'user' => Auth::user(),
            'movieList' => $list,
        ]);
    }
}
