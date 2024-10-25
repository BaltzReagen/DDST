<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <script>
        function validatePasswords(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if(password.length < 8){
                event.preventDefault();
                alert('Password must be at least 8 characters long!');
                document.getElementById('password').value='';
                document.getElementById('confirm-password').value='';
            }

            if (password !== confirmPassword) {
                event.preventDefault(); // Prevent form submission
                alert('Passwords do not match!'); // Show alert message
                document.getElementById('password').value='';
                document.getElementById('confirm-password').value='';
            }
        }
    </script>

    <script>
        document.getElementById('back-btn').addEventListener('click', function(){
            window.location = '{{ url('form') }}';
        });
     </script>
</head>

<body>
    <div class="login">
        <div class="back-button">
            <button class="back-btn" onclick="window.location='{{ url('form') }}'">Return</button>
        </div>

        <div class="login-container">
            <div class="login-box">
                <h1>Create Account</h1>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Registration Form -->
                <form action="{{ route('register.store') }}" method="POST" onsubmit="validatePasswords(event)">
                    @csrf
                    <div class="login-form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter Username" required>
                    </div>
                    <div class="login-form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter Email" required>
                    </div>
                    <div class="login-form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Password" required>
                    </div>
                    <div class="login-form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="confirm-password" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" class="login-page-btn">REGISTER</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="login-footer">
        <p>&copy; 2024 - Kevin - Alpha Build</p>
    </footer>
</body>
</html>
