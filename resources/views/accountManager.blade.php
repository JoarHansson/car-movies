<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.red.min.css" />
<link rel="stylesheet" href="/resources/css/app.css">

@include('header')

<div class="container">
    <h1>Account management</h1>

    @include('errors')

    @if(session()->has('message'))
    <div>
        {{ session()->get('message') }}
    </div>
    @endif
    <!-- form for changeing password -->
    <h3>Change password</h3>
    <form action="/changePassword" method="post">
        @method('PATCH')
        @csrf
        <div class="grid">
            <input name="currentPassword" id="currentPassword" type="password" placeholder="Your current password" />
            <input name="newPassword" id="newPassword" type="password" placeholder="Your new password" />
            <button type="submit">Change password</button>
        </div>
    </form>
    <!-- form for deleting the user account -->

    <h3>Delete your account</h3>
    <form action="/deleteAccount" method="post">
        @method('DELETE')
        @csrf
        <div class="grid">
            <input name="currentPassword" id="currentPassword" type="password" placeholder="Your current password" />
            <button type="submit">Delete account</button>
        </div>
    </form>

</div>

@vite(['resources/css/app.css', 'resources/js/app.js'])
