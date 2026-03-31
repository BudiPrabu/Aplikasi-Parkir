<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ParkirApp</title>
    <style>
        .text-biru {
            color : #2219a5;
        }
        :root {
            --primary: #4f46e5;
            --bg: #f3f4f6;
        }
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 35px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            margin: 0 0 0.5rem;
            color: #1f2937;
            text-align: center;
        }
        .login-card p {
            text-align: center;
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }
        .form-group {
            margin-bottom: 1.2rem;
        }
        label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
        }
        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.2s;
        }
        
        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        .btn-submit {
            width: 100%;
            padding: 0.90rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-submit:hover {
            opacity: 0.9;
        }
        .error-msg {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            text-align: center;
        }
        .footer-text {
            text-align: center;
            margin-top: 0.90rem;
            font-size: 0.8rem;
            color: #6a6c6f;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Sistem <span class="text-biru">Parkir</span></h2>
        <p>Silahkan masuk dengan akun Anda</p>

        @if(session()->has('loginError'))
            <div class="error-msg">{{ session('loginError') }}</div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukan Password" required>
            </div>

            <button type="submit" class="btn-submit">Masuk Sekarang</button>
            <div class="footer-text">
                Dibuat Oleh Peserta UKK.
            </div>
        </form> 
    </div>

</body>
</html>