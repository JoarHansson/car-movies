<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
<link rel="stylesheet" href="app.css">
<div class="container">

    <!-- some basic Styling using Pico -->
    <style>
        h1 {
            margin-top: 3rem;
        }

        button {
            margin-top: 2rem;
        }

        /* grid system for the movies.*/
        .grid {
            grid-template-columns: repeat(auto-fit, minmax(30%, 1fr));
            grid-column-gap: 2rem;
            margin-left: 2rem;
            margin-right: 2rem;
        }
    </style>
    <h1>Hello {{ $user->name }}</h1>
    <a href="/logout">logout</a>
    @include('errors')
    <div class="grid">
        <form action="/getMovies">
            <button type="submit">Discover</button>
        </form>
        <!-- placeholder, this does not generate likes, yet -->
        <form action="/getLikes">
            <button type="submit">My Likes</button>
        </form>
    </div>
    <!-- if discover/generate Movie is clicked, include movie recommendations in view -->
    @isset($movieList)
    @include('movies')
    @endisset

    <!-- if likes is clicked, include likes in view -->
    @isset ($movieLikes)
    @include('likes')
    @endisset
</div>