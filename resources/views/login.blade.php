<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Informasi Laboratorium PG Kebon Agung</title>

    <link href="/adminkit-main/static/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        .input-group .btn-show-pass {
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

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Silab</h1>
                            <p class="lead">Sistem Informasi Laboratorium PG Kebon Agung</p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <form action="{{ route('login_process') }}" method="POST" novalidate>
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input class="form-control form-control-lg" type="text" name="username"
                                                placeholder="Masukkan username" required autofocus
                                                value="{{ old('username') }}" />
                                            @error('username')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Password with eye icon -->
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group">
                                                <input id="passwordInput" class="form-control form-control-lg"
                                                    type="password" name="password" placeholder="Masukkan password"
                                                    required aria-describedby="togglePassword" />
                                                <button type="button" id="togglePassword"
                                                    class="btn btn-outline-secondary btn-show-pass btn-icon"
                                                    aria-label="Tampilkan password" title="Tampilkan password">
                                                    <!-- Eye SVG (open/closed toggled by JS class) -->
                                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                                        stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>

                                                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                                        stroke-linejoin="round" style="display:none" aria-hidden="true">
                                                        <path
                                                            d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a21.82 21.82 0 014.17-4.88">
                                                        </path>
                                                        <path d="M1 1l22 22"></path>
                                                        <path d="M9.88 9.88a3 3 0 104.24 4.24"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Offline math captcha (server-generated) -->
                                        <div class="mb-3">
                                            <label class="form-label">Captcha</label>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2 fw-bold fs-6" id="captchaQuestion">
                                                    {{-- server renders $captchaQuestion --}}
                                                    {{ $captchaQuestion ?? '—' }}
                                                </div>

                                                <!-- refresh button: calls route to refresh captcha via AJAX -->
                                                <button type="button" id="refreshCaptcha" class="captcha-refresh"
                                                    title="Ganti soal" aria-label="Ganti soal">
                                                    <!-- small refresh icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <polyline points="23 4 23 10 17 10"></polyline>
                                                        <polyline points="1 20 1 14 7 14"></polyline>
                                                        <path d="M3.51 9a9 9 0 0114.13-3.36L23 10"></path>
                                                        <path d="M20.49 15a9 9 0 01-14.13 3.36L1 14"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <input id="captchaInput" name="captcha" class="form-control mt-2"
                                                type="text" required placeholder="Masukkan jawaban"
                                                autocomplete="off" />
                                            @error('captcha')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Login</button>
                                        </div>
                                    </form>

                                    <div class="mt-3 text-muted small">
                                        Gunakan akun yang sudah terdaftar. Jika lupa password hubungi admin.
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Toggle show/hide password
        (function() {
            const pwInput = document.getElementById('passwordInput');
            const toggle = document.getElementById('togglePassword');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            toggle.addEventListener('click', function() {
                if (pwInput.type === 'password') {
                    pwInput.type = 'text';
                    eyeOpen.style.display = 'none';
                    eyeClosed.style.display = 'inline';
                    toggle.setAttribute('aria-label', 'Sembunyikan password');
                } else {
                    pwInput.type = 'password';
                    eyeOpen.style.display = 'inline';
                    eyeClosed.style.display = 'none';
                    toggle.setAttribute('aria-label', 'Tampilkan password');
                }
                pwInput.focus();
            });

            toggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggle.click();
                }
            });
        })();

        // Refresh captcha via AJAX
        async function loadCaptcha() {
            try {
                const resp = await fetch("{{ route('login.captcha.refresh') }}", {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                });
                if (!resp.ok) throw new Error('Gagal refresh');
                const data = await resp.json();
                document.getElementById('captchaQuestion').textContent = data.question;
            } catch (err) {
                console.error(err);
                alert('Gagal memuat soal baru. Reload halaman jika perlu.');
            }
        }

        // auto load captcha saat halaman pertama kali dibuka
        document.addEventListener('DOMContentLoaded', loadCaptcha);

        // tetap bisa refresh manual lewat tombol
        document.getElementById('refreshCaptcha').addEventListener('click', loadCaptcha);
    </script>


    <script src="/adminkit-main/static/js/app.js"></script>
    @include('template-admin-kit.js')
</body>

</html>
