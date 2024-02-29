<!-- Generate a card for all movies -->

<div class="grid">@isset($movieList)
    @foreach( $movieList->results as $movie)
    <div class="container">
        <img src="http://image.tmdb.org/t/p/w500{{$movie->poster_path}}" alt="">
        <h3>{{$movie->title}}</h3>
        <p>{{$movie->vote_average}}</p>

    </div>
    @endforeach
    @endisset
</div>