<!DOCTYPE html>
<html>
<head>
    <title>Edit Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">Edit Role: {{ strtoupper($role->name) }}</div>
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="fw-bold">Nama Role</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name }}" {{ $role->name == 'admin' ? 'readonly' : '' }} required>
                        @if($role->name == 'admin')
                            <small class="text-danger">*Nama role admin tidak bisa diubah demi keamanan.</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold mb-2">Pilih Hak Akses:</label>
                        <div class="row">
                            @foreach($permissions as $perm)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->name }}" id="perm_{{ $perm->id }}" 
                                            {{ in_array($perm->name, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $perm->id }}">
                                            {{ $perm->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>