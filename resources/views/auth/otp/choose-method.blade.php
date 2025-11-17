@extends('layouts.otp.app')

@section('content')
    <div class="p-5 rounded-4 shadow" style="width: 100%; max-width: 500px; background-color: rgba(255, 255, 255, 0.85);">
        <h3 class="text-center mb-4 text-dark fw-bold">Pilih Metode Verifikasi OTP</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('otp.send') }}" id="otpForm">
            @csrf
            <input type="hidden" name="via" id="viaInput">

            <div class="d-grid gap-3 mb-4">
                <button type="button" class="otp-option btn btn-outline-primary" data-value="email">
                    <i class="fas fa-envelope me-3 fs-5"></i> <span class="fs-5">Email</span>
                </button>

                <button type="button" class="otp-option btn btn-outline-success" data-value="sms">
                    <i class="fas fa-comment-dots me-3 fs-5"></i> <span class="fs-5">SMS</span>
                </button>
            </div>

            @error('via')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror

            <div class="text-center">
                <button type="submit" class="btn btn-success px-5 py-2">Kirim OTP</button>
            </div>
        </form>
    </div>

    <style>
        .otp-option {
            height: 60px;
            width: 100%;
            display: flex;
            align-items: center;
            padding-left: 24px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .otp-option.active {
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            background-color: rgba(0, 123, 255, 0.05);
        }

        .otp-option i {
            width: 24px;
            text-align: center;
        }

        .otp-option span {
            flex-grow: 1;
            text-align: left;
        }
    </style>

    <script>
        const buttons = document.querySelectorAll('.otp-option');
        const viaInput = document.getElementById('viaInput');

        buttons.forEach(btn => {
            btn.addEventListener('click', function () {
                buttons.forEach(b => b.classList.remove('active', 'border-3'));
                this.classList.add('active', 'border-3');
                viaInput.value = this.dataset.value;
            });
        });

        document.getElementById('otpForm').addEventListener('submit', function (e) {
            if (!viaInput.value) {
                e.preventDefault();
                alert('Silakan pilih salah satu metode OTP.');
            }
        });
    </script>
@endsection