<div class="grid moviegrid">
    @isset($movieLikes)

    @if (count($user->likes) == 0)
    <p class="message-no-likes">You don't have any likes yet!</p>
    @endif

    @foreach( $user->likes as $like)

    <div class="container">

        @if(!$like->movie_poster)
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png"
            alt="no image available">

        @else
        <img src=" http://image.tmdb.org/t/p/w500{{$like->movie_poster}}" alt="">

        @endif
        <h3>{{$like->movie_title}}</h3>
        <p>{{$like->movie_rating}}</p>


        <form action="deleteLike/{{$like->id}}" method="post">
            @method('DELETE')
            @csrf
            <button type="submit" class="icon" name="movieId" value="{{$like->movie_id}}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-1 h-1">
                    <path
                        d="m9.653 16.915-.005-.003-.019-.01a20.759 20.759 0 0 1-1.162-.682 22.045 22.045 0 0 1-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 0 1 8-2.828A4.5 4.5 0 0 1 18 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 0 1-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 0 1-.69.001l-.002-.001Z" />
                </svg>
            </button>
        </form>

    </div>
    @endforeach
    @endisset
</div>
