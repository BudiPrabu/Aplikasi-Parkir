<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <style>
        .container-center {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80vh;
            padding-top: 50px;
        }

        .card-form {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); 
        }

        .card-title {
            text-align: center;
            margin-bottom: 25px;
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1; 
            border-radius: 8px;
            box-sizing: border-box;
            outline: none;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            border-color: #4f46e5;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #4f46e5; 
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: #4338ca;
        }

        .link-cancel {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .link-cancel:hover {
            color: #334155;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('page_name', 'Tambah User')

    @section('content')
    <div class="container-center">
        <div class="card-form">
            <h2 class="card-title">ADD USER</h2>

            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" 
                        placeholder="Masukkan nama lengkap" required autofocus>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" 
                        placeholder="Masukkan username" required>
                    @error('username') 
                        <small style="color: #ef4444; margin-top: 5px; display: block;">{{ $message }}</small> 
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" 
                        placeholder="Masukkan password" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" style="cursor: pointer;" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary">
                    Simpan Data
                </button>
            </form>

            <a href="{{ route('user.index') }}" class="link-cancel">
                &larr; Batal dan Kembali
            </a>
        </div>
    </div>
    @endsection
</body>
</html>