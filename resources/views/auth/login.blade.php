
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | WorkTrack</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f6fb;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 36px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 12px 40px rgba(30, 41, 59, .08);
        }

        .brand {
            color: #4f46e5;
            font-weight: 700;
        }

        .form-control {
            padding: 12px;
        }

        .btn-worktrack {
            background: #4f46e5;
            color: white;
            padding: 12px;
        }

        .btn-worktrack:hover {
            background: #4338ca;
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h3 class="brand mb-2">WorkTrack</h3>
        <p class="text-secondary mb-4">
            Sign in to manage your daily work.
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    required
                    autofocus
                >
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" class="btn btn-worktrack w-100">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>