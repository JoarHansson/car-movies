<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.red.min.css" />
<link rel="stylesheet" href="/resources/css/app.css">

<div class="container">
    <h1>Change password</h1>

    <form action="/changePassword" method="post">
        @csrf
        <label for="currentPassword">Your current password</label>
        <input name="currentPassword" id="currentPassword" type="password" />
        <label for="newPassword">New password</label>
        <input name="newPassword" id="newPassword" type="password" />
        <button type="submit">Change password</button>
    </form>

    @include('errors')

    @if(session()->has('message'))
    <div>
        {{ session()->get('message') }}
    </div>
    @endif

</div>

@vite(['resources/css/app.css', 'resources/js/app.js'])
