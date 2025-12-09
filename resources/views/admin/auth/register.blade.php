<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h1>EMS</h1>
    <h2>Register User</h2>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <label for="name">Full Name</label><br>
        <input type="text" name="name" id="name" required>
        @error('name')
            <span>{{ $message }}</span>
        @enderror
        <br><br>
        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" required>
        @error('email')
            <span>{{ $message }}</span>
        @enderror
        <br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password" required>
        @error('password')
            <span>{{ $message }}</span>
        @enderror
        <br><br>
        <label for="password_confirmation">Confirm Password</label><br>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        <br><br>
        <input type="hidden" name="role_id" value="1">

        <button type="submit">Register</button>
</body>

</html>
