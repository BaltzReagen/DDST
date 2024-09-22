<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Register</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    </head>
    
    <body>
        <div class="login">
            <div class="back-button">
                <button onclick="window.history.back()">⬅ Back</button>
            </div>

            <div class="login-container">
                <div class="login-box">
                    <h1>Create Account</h1>
                    <form action="#">
                        <div class="login-form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter Full Name">
                        </div>
                        <div class="login-form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Enter Email">
                        </div>
                        <div class="login-form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Enter Password">
                        </div>
                        <div class="login-form-group">
                            <label for="confirm-password">Confirm Password</label>
                            <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password">
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