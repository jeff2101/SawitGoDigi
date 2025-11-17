@extends('layouts.otp.app')

@section('content')
    <div class="p-5 rounded-4 shadow" style="width: 100%; max-width: 500px; background-color: rgba(255, 255, 255, 0.85);">
        <h3 class="text-center mb-2 text-dark fw-bold">Masukkan Kode Verifikasi</h3>
        <p class="text-center mb-4 text-secondary">
            Kode verifikasi telah dikirim ke <strong>{{ $tujuan }}</strong>
        </p>

        <form action="{{ route('otp.verify') }}" method="POST" id="verifyForm">
            @csrf

            <div class="d-flex justify-content-center gap-2 mb-4">
                @for ($i = 0; $i < 6; $i++)
                    <input type="text" class="form-control otp-box" maxlength="1" name="otp[]" inputmode="numeric"
                        pattern="[0-9]*" required>
                @endfor
            </div>

            @error('kode_otp')
                <div class="text-danger text-center mb-3">{{ $message }}</div>
            @enderror

            <input type="hidden" name="remember_device" value="1">

            <div class="text-center">
                <button type="submit" class="btn btn-success px-5 py-2">Verifikasi</button>
            </div>
        </form>
    </div>

    <style>
        .otp-box {
            width: 48px;
            height: 56px;
            font-size: 24px;
            text-align: center;
            border: 1px solid #ced4da;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.3s;
        }

        .otp-box:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
        }

        .otp-box::-webkit-inner-spin-button,
        .otp-box::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <script>
        const inputs = document.querySelectorAll('.otp-box');

        inputs.forEach((input, index) => {
            input.addEventListener('input', function () {
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function (e) {
                if (e.key === "Backspace" && this.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        document.getElementById('verifyForm').addEventListener('submit', function () {
            const otp = Array.from(inputs).map(input => input.value).join('');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'kode_otp';
            hiddenInput.value = otp;
            this.appendChild(hiddenInput);
        });
    </script>
@endsection