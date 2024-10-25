<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

        <script>
            document.getElementById('back-btn').addEventListener('click', function(){
                window.location = '{{ url('form') }}';
            });
        </script>
    </head>

    <body class="login">
        <div class="back-button">
            <button class="back-btn" onclick="window.location='{{ url('form') }}'">Return</button>
        </div>

        <div class="login-container">
            <div class="login-box">
                <h1>LOGIN</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="login-form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter Email">
                    </div>
                    <div class="login-form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Password">
                    </div>
                    <button type="submit" class="login-page-btn" id="login-page-btn">LOGIN</button>
                </form>
                <div class="login-options">
                    <a href="#">Forgot Login?</a>
                    <a href="#">Sign Up</a>
                </div>
            </div>
        </div>

        <footer class="login-footer">
            <p>&copy; 2024 - Kevin - Alpha Build</p>
        </footer>
    </body>
</html>