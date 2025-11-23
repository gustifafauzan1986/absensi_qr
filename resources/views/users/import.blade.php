<!DOCTYPE html>
<html>
<head>
    <title>Import User & Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4>Import Data Guru / Admin</h4>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="alert alert-warning">
                        <strong>Format Excel Wajib (Header Kecil Semua):</strong> <br>
                        <code>nama</code> | <code>email</code> | <code>password</code> | <code>role</code>
                        <br><br>
                        <small>* Role harus diisi: <b>guru</b> atau <b>admin</b></small>
                    </div>

                    <form action="{{ route('users.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Pilih File Excel</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Import User</button>
                        </div>
                    </form>

                </div>
            </div>
            
            <div class="mt-4">
                <small class="text-muted">Contoh isi file Excel:</small>
                <table class="table table-bordered table-sm mt-2">
                    <thead class="table-light">
                        <tr>
                            <th>nama</th>
                            <th>email</th>
                            <th>password</th>
                            <th>role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Pak Budi</td>
                            <td>budi@sekolah.com</td>
                            <td>rahasia123</td>
                            <td>guru</td>
                        </tr>
                        <tr>
                            <td>Ibu Kepala</td>
                            <td>kepsek@sekolah.com</td>
                            <td>admin123</td>
                            <td>admin</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>