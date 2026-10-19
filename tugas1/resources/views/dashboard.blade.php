<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Dashboard</h2>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <hr>

    <h3>Selamat datang, {{ Auth::user()->nama_lengkap }}!</h3>
    <p>Halaman ini hanya bisa dibuka setelah login.</p>
    <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
    <p><strong>Role Anda:</strong> {{ Auth::user()->role }}</p>

    @can('manage-roles')
        <hr>
        <h3>Manajemen Role Pengguna (Admin)</h3>

        @if (session('status'))
            <p><strong>{{ session('status') }}</strong></p>
        @endif

        @if ($errors->has('role'))
            <p><strong>{{ $errors->first('role') }}</strong></p>
        @endif

        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role Saat Ini</th>
                    <th>Ubah Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Models\User::all() as $u)
                    <tr>
                        <td>{{ $u->nama_lengkap }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->role }}</td>
                        <td>
                            <form action="{{ route('admin.users.role.update', $u) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="role">
                                    <option value="customer" {{ $u->role === 'customer' ? 'selected' : '' }}>customer</option>
                                    <option value="staff" {{ $u->role === 'staff' ? 'selected' : '' }}>staff</option>
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>admin</option>
                                </select>
                                <button type="submit">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcan
</body>
</html>