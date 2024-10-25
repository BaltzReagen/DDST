<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- Link to your CSS if you have one -->
</head>
<body>

<div class="thank-you-container">
    <h1>Thank You!</h1>
    <p>Your responses have been saved successfully.</p>
    <p>We appreciate your time and effort in completing the milestone checklist.</p>
    
    <a href="{{ route('home') }}" class="btn">Back to Home</a> <!-- Ensure 'home' route exists -->
</div>

</body>
</html>
