<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIMP-PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { height: 100vh; display: flex; font-family: 'Segoe UI', sans-serif; overflow: hidden; }
        .left-panel {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
        }
        .left-panel img.illustration { width: 160px; margin-bottom: 1.5rem; }
        .left-panel h2 { font-size: 22px; font-weight: 600; margin-bottom: 4px; color: #1a1a1a; }
        .left-panel p.subtitle { font-size: 13px; color: #888; margin-bottom: 1.5rem; text-align: center; }
        .input-wrapper {
            position: relative;
            width: 100%;
            max-width: 300px;
            margin-bottom: 12px;
        }
        .input-wrapper svg { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #aaa; }
        .input-wrapper input {
            width: 100%;
            padding: 10px 12px 10px 36px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f5f6fa;
            font-size: 13px;
            color: #333;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-wrapper input:focus {
            border-color: #4A6FA5;
            box-shadow: 0 0 0 3px rgba(74,111,165,0.15);
            background: #fff;
        }
        .btn-reset {
            width: 100%;
            max-width: 300px;
            padding: 11px;
            background: #4A6FA5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 6px;
            transition: background 0.2s;
        }
        .btn-reset:hover { background: #3a5a8a; }
        .alert-error {
            width: 100%;
            max-width: 300px;
            background: #fff0f0;
            border: 1px solid #f5c6cb;
            color: #842029;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            margin-bottom: 12px;
        }
        .right-panel {
            width: 50%;
            background: #b0b8c1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem 3.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 12px rgba(255,255,255,0.25), 0 0 0 24px rgba(255,255,255,0.10), 0 8px 32px rgba(0,0,0,0.15);
            max-width: 420px;
            width: 85%;
        }
        .logo-card img { max-width: 600px; width: 120%; }
        @media (max-width: 768px) { .right-panel { display: none; } }
    </style>
</head>

<body>

    <div class="left-panel">

        <img src="{{ asset('images/ilustrasi.png') }}" alt="Ilustrasi" class="illustration">

        <h2>Reset Password</h2>
        <p class="subtitle">Masukkan email dan password lama kamu<br>untuk mengatur password baru</p>

        @if($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('reset.post') }}"
              style="display:flex; flex-direction:column; align-items:center; width:100%;">
            @csrf

            {{-- Email --}}
            <div class="input-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
                <input type="email" name="email" placeholder="Email"
                       value="{{ old('email') }}" required>
            </div>

            {{-- Password Lama --}}
            <div class="input-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input type="password" name="old_password" placeholder="Password Lama" required>
            </div>

            {{-- Password Baru --}}
            <div class="input-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input type="password" name="new_password" placeholder="Password Baru" required>
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div class="input-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input type="password" name="new_password_confirmation" placeholder="Konfirmasi Password Baru" required>
            </div>

            <button type="submit" class="btn-reset">Reset Password</button>

            <a href="{{ route('login') }}"
               style="margin-top:12px; font-size:12px; color:#4A6FA5; text-decoration:none;">
                ← Kembali ke Login
            </a>
        </form>
    </div>

    <div class="right-panel">
        <div class="logo-card">
            <img src="{{ asset('images/logo_simppro.png') }}" alt="Logo SIMP-PRO">
        </div>
    </div>

</body>
</html>