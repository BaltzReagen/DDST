<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="thank-you-container">
    <h1>Thank You!</h1>
    <p>{{ session('status', 'Your responses have been saved successfully.') }}</p>
    <p>We appreciate your time and effort in completing the milestone checklist.</p>
    
    <a href="{{ route('home') }}" class="btn">Back to Home</a> 
</div>

</body>
</html>
