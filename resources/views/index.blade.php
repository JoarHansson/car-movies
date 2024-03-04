{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" /> --}}
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.red.min.css"
/>

<style>
    .container {
        margin-top: 3rem;
    }

    </style>

<div class="container">

    <form action="/login" method="post">
        @csrf
        <div>
            <label for="email">Email</label><input name="email" id="email" type="email" />
        </div>
        <div>
            <label for="password">Password</label><input name="password" id="password" type="password" />
        </div>
        <button type="submit">Login</button>
    </form>

    @include('errors')

</div>
