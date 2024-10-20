<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Form</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    </head>

    <body>
        <div class="form-container">
            <h1>Take Test as a Guest</h1>
            <p>As a guest you get instant results, however you will receive a limited test report. For the full test report register <a href="{{ route('register') }}">here</a>.</p>
            <p><strong>* Required field</strong></p>

            <form class="initial" action="{{ route('screenings.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="first-name">First Name *</label>
                        <input type="text" name="fname" id="first-name" placeholder="Enter First Name">
                    </div>
                    <div class="form-group">
                        <label for="child-name">Child's Name *</label>
                        <input type="text" name="child_name" id="child-name" placeholder="Enter Child's Name">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="dob">Date of Birth *</label>
                        <input type="date" name="dob" id="dob">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender *</label>
                        <select name="gender" id="gender">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>

                <button class="submit-btn" type="submit">Take Test</button>
            </form>

            <div class="account-section">
                <div class="account-option">
                    <p>Take Test with an Account</p>
                    <button class="register-btn" id="register-btn">Register Here!</button>
                </div>
                
            </div>
            <div class="account-section">
                <div class="account-option">
                    <p>Already Have One?</p>
                    <button class="login-btn" id="login-btn">Login Here!</button>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; 2024 - Kevin - Alpha Build</p>
        </footer>
    </body>
    
    <script>
        document.getElementById('login-btn').addEventListener('click', function(){
            window.location = '{{ url('login') }}';
        });
    </script>

    <script>
        document.getElementById('register-btn').addEventListener('click', function(){
            window.location = '{{ url('register') }}';
        });
    </script>
</html>