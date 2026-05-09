<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - Lumière</title>
    <style>
        body {
            min-height: 100vh;
            display: grid;
            place-items: center;
            margin: 0;
            background:
                radial-gradient(circle at top right, rgba(0, 215, 96, 0.15), transparent 36%),
                #050505;
            color: #f5f5f5;
            font-family: Verdana, sans-serif;
        }

        .box {
            width: min(440px, calc(100vw - 32px));
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            padding: 32px;
            background: #111111;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.36);
        }

        a {
            color: #00d760;
            text-decoration: none;
            font-weight: 800;
        }

        h1 {
            margin: 18px 0 20px;
            font-size: 44px;
            line-height: 0.95;
            letter-spacing: -0.07em;
            text-transform: uppercase;
        }

        label {
            display: block;
            margin: 16px 0 8px;
            color: #a3a3a3;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 13px 14px;
            background: #050505;
            color: white;
            font: inherit;
        }

        button {
            width: 100%;
            margin-top: 22px;
            border: 0;
            border-radius: 999px;
            padding: 14px 18px;
            background: #00d760;
            color: #03130a;
            font: inherit;
            font-weight: 900;
            cursor: pointer;
        }

        p {
            color: #a3a3a3;
            line-height: 1.6;
        }

        .error {
            margin: 12px 0;
            border: 1px solid rgba(0, 215, 96, 0.35);
            border-radius: 14px;
            padding: 12px;
            background: rgba(0, 215, 96, 0.08);
            color: #bbf7d0;
        }
    </style>
</head>
<body>
    <main class="box">
        <a href="{{ route('home') }}">← Trang chủ</a>
        <h1>Đăng nhập</h1>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="user@example.com" required autofocus>

            <label for="password">Mật khẩu</label>
            <input id="password" name="password" type="password" placeholder="Nhập mật khẩu" required>

            <button type="submit">Đăng nhập</button>
        </form>

        <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
    </main>
</body>
</html>
