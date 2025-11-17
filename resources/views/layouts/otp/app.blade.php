<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>

    <!-- Fonts & Styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    @include('sweetalert::alert')

    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(rgba(27, 77, 62, 0.6), rgba(27, 77, 62, 0.6)),
                url('{{ asset('assets/img/sawit2.png') }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Nunito', sans-serif;
        }

        .otp-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .otp-card {
            width: 100%;
            max-width: 480px;
            background-color: rgba(255, 255, 255, 0.88);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.25);
        }

        .otp-input {
            width: 50px;
            height: 55px;
            font-size: 22px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 0 5px;
        }

        .form-option-btn {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 10px;
            border: 2px solid transparent;
            background-color: #f9f9f9;
            text-align: left;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .form-option-btn:hover,
        .form-option-btn.active {
            background-color: #e9ecef;
            border-color: #28a745;
        }
    </style>
</head>

<body>

    <div class="otp-wrapper">
        <div class="otp-card">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @yield('script')
</body>

</html>