<p>Hello {{ $user->name }}</p>
<a href="/logout">logout</a>
@include('errors')
<form action="/getMovies">
    <button type="submit">Get movies</button>
</form>
@include('tempMovieCard')