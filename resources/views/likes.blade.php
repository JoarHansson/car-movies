<div class="grid">
    @isset($movieLikes)
    @foreach( $user->likes as $movie)
    <div class="container">
        <img src="http://image.tmdb.org/t/p/w500{{$movie->movie_poster}}" alt="">
        <h3>{{$movie->movie_title}}</h3>
        <p>{{$movie->movie_rating}}</p>
        <h3>{{$movie->movie_title}}</h3>
        <form action="/manageLike">
            <input type="hidden" value="{{$movie->movie_id}}">
            <button type="submit" name="movieId" value="{{$movie->movie_id}}"> Like </button>  
        </button>
        </form>
    </div>
    @endforeach
    @endisset
</div>