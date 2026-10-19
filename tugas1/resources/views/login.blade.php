<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <p>Masuk untuk membuka dashboard</p>

    @if ($errors->has('login_error'))
        <p><strong>{{ $errors->first('login_error') }}</strong></p>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div>
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
        </div>
        <br>
        <div>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Masuk</button>
    </form>
</body>
</html>