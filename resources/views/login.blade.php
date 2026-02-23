<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Digital Library</title>
     <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="book-icon">📖</div>
    <div class="container">
        <div class="form-box">
            <h2>Login to Library</h2>
            <p>Please login to borrow books.</p>
            @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif
            @if($errors->has('email'))
                <p style="color: red;">{{ $errors->first('email') }}</p>
            @endif
            <form action="/login" method="POST">
                @csrf
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter email" autocomplete="off" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" autocomplete="off" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p class="switch-text">Don't have an account? <a href="{{ route('register') }}">Register here</a> | <a href="/">Back to Home</a></p>
        </div>
    </div>

</body>
</html>