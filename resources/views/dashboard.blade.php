{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" /> --}}
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.red.min.css"
/>
<link
  rel="stylesheet"
  href=""
/>
<div class="container">

    <!-- some basic Styling using Pico -->
    <style>

    </style>
    <h1>Hello {{ $user->name }}</h1>
    <a href="/logout">logout</a>
    @include('errors')
    <div class="grid">
        <form action="/getMovies">
            <button type="submit" @isset($movieList) class="outline" @endisset >Discover</button>
        </form>
        <form action="/getToplist">
            <button type="submit" @isset($topList) class="outline" @endisset>Top List</button>
        </form>
        <!-- placeholder, this does not generate likes, yet -->
        <form action="/getLikes">
            <button type="submit" @isset($movieLikes) class="outline" @endisset>My Likes</button>
        </form>
    </div>
    @if (!isset($movieLikes) & !isset($movieList) || isset($toplist))
    @include('toplist')
    @endif
    <!-- if discover/generate Movie is clicked, include movie recommendations in view -->
    @isset($movieList)
    @include('movies')
    @endisset

    <!-- if likes is clicked, include likes in view -->
    @isset ($movieLikes)
    @include('likes')
    @endisset
</div>
@vite(['resources/css/app.css'])

