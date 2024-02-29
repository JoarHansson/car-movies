<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
<style>
    :root {
        --pico-border-radius: 1rem;
    }

    button {
        --pico-font-weight: 700;
    }

    form,
    button {
        max-width: 80%;
        margin-left: 10%;

    }

    form {
        margin-top: 5rem;
    }
</style>

<form action="/login" method="post">@csrf <div><label for="email">Email</label><input name="email" id="email" type="email" /></div>
    <div><label for="password">Password</label><input name="password" id="password" type="password" /></div><button type="submit">Login</button>
</form>@include('errors')