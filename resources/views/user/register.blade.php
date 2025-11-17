<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Petani</title>

    <!-- Styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body#register-page {
            background: linear-gradient(rgba(27, 77, 62, 0.6), rgba(27, 77, 62, 0.6)),
                url('{{ asset('assets/img/sawit2.png') }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }

        .bg-register-image {
            position: relative;
            background: url('{{ asset('assets/img/testimonials-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            overflow: hidden;
        }

        .bg-register-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(0.5px);
            background-color: rgba(0, 0, 0, 0.3);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            text-align: center;
            z-index: 1;
        }

        .bg-register-overlay img.logo {
            max-width: 120px;
            margin-bottom: 15px;
        }

        .bg-register-overlay h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .bg-register-overlay p {
            font-size: 16px;
        }
    </style>
</head>

<body id="register-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <div class="row">
                            <!-- Gambar kiri dengan overlay -->
                            <div class="col-lg-6 d-none d-lg-block bg-register-image">
                                <div class="bg-register-overlay">
                                    <img src="{{ asset('assets/img/sawit.png') }}" alt="Logo" class="logo">
                                    <h2>SawitGoDigi</h2>
                                    <p>sawit adalah Uang</p>
                                    <p>Dan Uang adalah Sawit</p>
                                </div>
                            </div>

                            <!-- Form Register -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Daftar Sebagai Petani</h1>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('user.register.submit') }}">
                                        @csrf
                                        <input type="hidden" name="role" value="petani">

                                        <div class="form-group">
                                            <input type="text" name="nama" class="form-control form-control-user"
                                                placeholder="Nama Lengkap" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                placeholder="Email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="kontak" class="form-control form-control-user"
                                                placeholder="Nomor Kontak" required>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" name="password"
                                                    class="form-control form-control-user" placeholder="Password"
                                                    required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" name="password_confirmation"
                                                    class="form-control form-control-user" placeholder="Ulangi Password"
                                                    required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Daftar
                                        </button>

                                        <hr>
                                        <div class="text-center mb-3">
                                            <a href="{{ route('google.login') }}"
                                                class="btn btn-danger btn-user btn-block">
                                                <i class="fab fa-google fa-fw"></i> Daftar / Login dengan Google
                                            </a>
                                        </div>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">Sudah punya akun? Login!</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Register -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>

</html>