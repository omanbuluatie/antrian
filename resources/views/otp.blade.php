<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form OTP</title>
    <style>
        body { font-family: sans-serif; }
        .form-container {
            margin: 100px auto;
            box-shadow: 0 0 15px -2px lightgray;
            width: 100%;
            max-width: 600px;
            padding: 20px;
            box-sizing: border-box;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }
        label { margin-bottom: 5px; }
        input {
            padding: 8px;
            border: 2px solid lightgray;
            border-radius: 5px;
        }
        button {
            background-color: orange;
            border: none;
            padding: 8px 16px;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-login { background-color: darkturquoise; }
        .alert { padding: 10px; margin-bottom: 10px; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 style="text-align: center;">OTP</h1>

        {{-- Tampilkan pesan sukses atau error --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        {{-- Jika nomor belum dikirim, tampilkan form untuk request OTP --}}
        @if (!session('nomor'))
            <form method="POST" action="{{ route('otp.send') }}">
                @csrf
                <div class="form-group">
                    <label for="nomor">Nomor</label>
                    <input placeholder="62812xxxx" name="nomor" type="text" id="nomor" required>
                </div>
                <button type="submit" name="submit-otp">Request OTP</button>
            </form>
        @else
            {{-- Jika OTP telah dikirim, tampilkan form verifikasi OTP --}}
            <form method="POST" action="{{ route('otp.verify') }}">
                @csrf
                <input type="hidden" name="nomor" value="{{ session('nomor') }}">
                <div class="form-group">
                    <label for="otp">OTP</label>
                    <input placeholder="xxxxxx" name="otp" type="text" id="otp" required>
                </div>
                <button type="submit" name="submit-login" class="btn-login">Login</button>
            </form>
        @endif
    </div>
</body>
</html>
