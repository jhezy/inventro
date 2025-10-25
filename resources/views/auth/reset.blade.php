<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Reset Password &mdash; {{ config('app.name') }}</title>

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.css') }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url("../assets/img/unsplash/bg.jpg") center/cover no-repeat;
            position: relative;
        }

        .reset-wrapper {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            color: #fff;
        }

        .reset-wrapper h4 {
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }

        .reset-wrapper p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
        }

        .form-control {
            border-radius: 12px;
            border: none;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.25);
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            border-radius: 0 12px 12px 0;
        }

        .btn-reset {
            width: 100%;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            border: none;
            background: #28a745;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: #218838;
        }

        .footer-text {
            font-size: 13px;
            text-align: center;
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.8);
        }

        .alert ul {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="reset-wrapper">
        <h4>Reset Password</h4>
        <p>Masukkan email dan password baru Anda</p>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email..." value="masukkan email..." required>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password baru..." required>
                    <span class="input-group-text" id="toggle-password" style="cursor:pointer;">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password" class="form-control" placeholder="Password baru..." required>
                    <span class="input-group-text" id="toggle-password" style="cursor:pointer;">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-reset text-white">Reset Password</button>
        </form>

        <div class="footer-text mt-4">
            <a href="{{ route('login') }}" class="text-light text-decoration-underline">Kembali ke Login</a><br>
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>

    <!-- JS -->
    <script src="{{ url('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Toggle show/hide password
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>