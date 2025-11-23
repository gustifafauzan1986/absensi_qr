<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Permission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manajemen Permission (Hak Akses)</h3>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('permissions.create') }}" class="btn btn-primary">+ Tambah Permission</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Permission</th>
                        <th>Guard Name</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $perm)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $perm->name }}</td>
                        <td>{{ $perm->guard_name }}</td>
                        <td>
                            <a href="{{ route('permissions.edit', $perm->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('permissions.destroy', $perm->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>