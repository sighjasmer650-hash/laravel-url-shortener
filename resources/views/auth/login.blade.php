<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - URL Shortener</title>

     <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-wrapper">

        <!-- Left Section -->
        <div class="login-left">

            <h1>URL Shortener</h1>

            <p>
                Manage your company's short URLs securely
                with role-based access and centralized management.
            </p>

            <ul class="feature-list">
                <li>Secure Authentication</li>
                <li>Role Based Access</li>
                <li>Company Management</li>
                <li>Short URL Management</li>
            </ul>

        </div>


        <!-- Right Section -->
        <div class="login-right">

            <h2>Welcome Back</h2>

            <p class="login-subtitle">
                Sign in to your account to continue
            </p>


            @if ($errors->any())

                <div class="error-box">

                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach

                </div>

            @endif


            <form action="{{ route('login.submit') }}" method="POST">

                @csrf


                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                        autofocus
                    >

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                </div>


                <button type="submit" class="login-button">
                    Sign In
                </button>

            </form>


            <div class="login-footer">
                URL Shortener &copy; {{ date('Y') }}
            </div>

        </div>

    </div>

</body>

</html>

