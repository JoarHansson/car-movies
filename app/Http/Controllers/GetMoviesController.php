<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GetMoviesController extends Controller
{
    public function __invoke(Request $request)
    {
        $apiKey = env('API_KEY');
        $response = Http::get('https://api.themoviedb.org/3/search/movie?query=car&include_adult=false&language=en-US&page=1&api_key=' . $apiKey);
        unset($apiKey);

        $list = $response->object();

        return view('dashboard', [
            'user' => Auth::user(),
            'movieList' => $list,
        ]);
    }
}
