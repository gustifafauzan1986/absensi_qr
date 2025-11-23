<!DOCTYPE html>
<html>
<head>
    <title>Tambah Permission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Tambah Permission Baru</div>
            <div class="card-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="fw-bold">Nama Permission</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: delete_siswa" required>
                        <small class="text-muted">Gunakan huruf kecil dan underscore ( _ ) sebagai pemisah.</small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>