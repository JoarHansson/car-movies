<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.red.min.css" />
<link rel="stylesheet" href="/resources/css/app.css">

<div class="container display-block" id="login-container">
    <h1>Login</h1>

    <form action="/login" method="post">
        @csrf
        <label for="email">Email</label>
        <input name="email" id="email" type="email" />
        <label for="password">Password</label>
        <input name="password" id="password" type="password" />
        <button type="submit">Login</button>
    </form>

    @include('errors')

    @if(session()->has('message'))
    <div>
        {{ session()->get('message') }}
    </div>
    @endif

    <h5><a id="link-to-create-account">Or create a new account...</a></h5>

</div>

<div class="container display-none" id="create-account-container">
    <h1>Create account</h1>

    <form action="/createAccount" method="post">
        @csrf
        <label for="name">Name</label>
        <input name="name" id="name" type="text" />
        <label for="email">Email</label>
        <input name="email" id="email" type="email" />
        <label for="password">Password</label>
        <input name="password" id="password" type="password" />
        <button type="submit">Create account</button>
    </form>

    @include('errors')

    @if(session()->has('message'))
    <div>
        {{ session()->get('message') }}
    </div>
    @endif

    <h5><a id="link-to-login">Or login to your account...</a></h5>

</div>

@vite(['resources/css/app.css', 'resources/js/app.js'])