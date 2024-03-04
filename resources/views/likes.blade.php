<div class="grid">
    @isset($movieLikes)
    @foreach( $user->likes as $movie)
    <div class="container">
        <img src="http://image.tmdb.org/t/p/w500{{$movie->movie_poster}}" alt="">
        <h3>{{$movie->movie_title}}</h3>
        <p>{{$movie->movie_rating}}</p>
    </div>
    @endforeach
    @endisset
</div>