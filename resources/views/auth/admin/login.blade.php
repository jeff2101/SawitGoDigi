<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Admin</title>

    <!-- Fonts & Styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(rgba(27, 77, 62, 0.6), rgba(27, 77, 62, 0.6)),
                url('{{ asset('assets/img/sawit2.png') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }

        .bg-login-image {
            position: relative;
            background: url('{{ asset('assets/img/testimonials-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            overflow: hidden;
        }

        .bg-login-overlay {
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
            text-align: center;
            z-index: 1;
        }

        .bg-login-overlay img.logo {
            max-width: 120px;
            margin-bottom: 15px;
        }

        .bg-login-overlay h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .bg-login-overlay p {
            font-size: 16px;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- KIRI -->
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <div class="bg-login-overlay">
                                    <img src="{{ asset('assets/img/sawit.png') }}" alt="Logo" class="logo">
                                    <h2>SawitGoDigi</h2>
                                    <p>sawit adalah Uang</p>
                                    <p>Dan Uang adalah Sawit</p>
                                </div>
                            </div>

                            <!-- KANAN -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

                                    <!-- Form Login -->
                                    <form action="{{ route('admin.login.submit') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email"
                                                placeholder="Enter Email Address..." value="{{ old('email') }}" required
                                                autofocus>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="remember">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                        <a href="{{ route('google.login.admin') }}"
                                            class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google (Admin)
                                        </a>
                                    </form>
                                    <hr>
                                    <!-- Jangan ubah route -->
                                    <div class="text-center">
                                        <a class="small" href="#">Belum punya akun? Daftar!</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form -->
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