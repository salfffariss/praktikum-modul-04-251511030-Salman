<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2>Dashboard</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
        <div class="content">
            <h3>Selamat datang, {{ Auth::user()->nama_lengkap }}!</h3>
            <p>Halaman ini hanya bisa dibuka setelah login.</p>
            <p><strong>Username:</strong> <span class="badge">{{ Auth::user()->username }}</span></p>
        </div>
    </div>
</body>
</html>