<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Informasi Laboratorium PG Kebon Agung</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/admin_template/img/ka.jpg">
    <!-- SB Admin 2 -->
    <link href="/sbadmin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="/sbadmin2/css/sb-admin-2.min.css" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet"> --}}

    <style>
        .btn-show-pass {
            padding: .375rem .60rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-icon {
            background: transparent;
            border: none;
            padding: 0;
            line-height: 0;
            cursor: pointer;
        }
        .captcha-refresh {
            border: none;
            background: transparent;
            cursor: pointer;
            padding-left: .5rem;
        }
    </style>
</head>

<body class="bg-gradient-danger">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-8">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-4">

                        <!-- Logo / Title -->
                        <div class="text-center mb-4">
                            <img src="/admin_template/img/ka.jpg" alt="Logo PG Kebon Agung"
         class="mb-3" style="max-height: 80px;">
                            <h1 class="h4 text-gray-900 mb-1"><strong>Sistem Informasi Laboratorium</strong></h1>
                            {{-- <p class="text-muted">Sistem Informasi Laboratorium PG Kebon Agung</p> --}}
                        </div>

                        <form action="{{ route('login_process') }}" method="POST" novalidate>
                            @csrf

                            <!-- Username -->
                            <div class="form-group mb-3">
                                <input type="text" name="username"
                                    class="form-control form-control-user"
                                    placeholder="Masukkan Username"
                                    value="{{ old('username') }}" required autofocus>
                                @error('username')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <input id="passwordInput" type="password" name="password"
                                        class="form-control form-control-user"
                                        placeholder="Masukkan Password" required>
                                    <button type="button" id="togglePassword"
                                        class="btn btn-outline-secondary btn-show-pass btn-icon"
                                        aria-label="Tampilkan password" title="Tampilkan password">
                                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
                                            width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.6"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg"
                                            width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.6"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="display:none">
                                            <path
                                                d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a21.82 21.82 0 014.17-4.88">
                                            </path>
                                            <path d="M1 1l22 22"></path>
                                            <path d="M9.88 9.88a3 3 0 104.24 4.24"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Captcha -->
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div id="captchaQuestion" class="fw-bold text-dark">
                                        {{ $captchaQuestion ?? '—' }}
                                    </div>
                                    <button type="button" id="refreshCaptcha"
                                        class="captcha-refresh ms-2" title="Ganti soal">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <input id="captchaInput" name="captcha"
                                    class="form-control form-control-user"
                                    type="text" placeholder="Masukkan jawaban"
                                    autocomplete="off" required>
                                @error('captcha')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit"
                                class="btn btn-danger btn-user btn-block">
                                Login
                            </button>
                        </form>

                        <div class="mt-4 text-center small text-muted">
                            Gunakan akun yang sudah terdaftar.<br>Jika lupa password hubungi
                            <a href="https://wa.me/6285733465399" target="_blank">admin</a>.
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- SB Admin 2 dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/sbadmin2/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/sbadmin2/js/sb-admin-2.min.js"></script>

    <script>
        // toggle password show/hide
        const pwInput = document.getElementById('passwordInput');
        const toggle = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        toggle.addEventListener('click', function () {
            if (pwInput.type === 'password') {
                pwInput.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'inline';
            } else {
                pwInput.type = 'password';
                eyeOpen.style.display = 'inline';
                eyeClosed.style.display = 'none';
            }
            pwInput.focus();
        });

        // captcha refresh
        async function loadCaptcha() {
            try {
                const resp = await fetch("{{ route('login.captcha.refresh') }}");
                const data = await resp.json();
                document.getElementById('captchaQuestion').textContent = data.question;
            } catch (err) {
                alert('Gagal memuat soal baru, silakan reload halaman.');
            }
        }
        document.addEventListener('DOMContentLoaded', loadCaptcha);
        document.getElementById('refreshCaptcha').addEventListener('click', loadCaptcha);
    </script>
</body>
</html>
