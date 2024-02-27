<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $ApiKey = env('APIKEY');
        $response = Http::get('https://api.themoviedb.org/3/movie/550?api_key=' . $ApiKey);
        unset($ApiKey);
        $list = $response->body();
        return view('dashboard', [
            'user' => Auth::user(),
            'movieList' => $list,
        ]);
    }
}
