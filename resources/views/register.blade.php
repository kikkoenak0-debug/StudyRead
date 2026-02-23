<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Digital Library</title>
    <link rel="stylesheet" href="{{ asset('css/daftar.css') }}">
</head>
<body>
    <div class="book-icon">📖</div>
    <div class="container">
        <div class="form-box">
            <h2>Register Member</h2>
            <p>Complete the data to join.</p>
            <form action="/register" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="error-messages">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Full name" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Error" required>
                </div>
                <div class="input-group">
                    <label>New Password</label>
                    <input type="password" name="password" placeholder="Password" required minlength="8">
                </div>
                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required minlength="8">
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
            <p class="switch-text">Already a member? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>

</body>
</html>