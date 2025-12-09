<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="" required><br><br>
         @error('email')
            <span>{{ $message }}</span>
        @enderror
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" required><br><br>
         @error('password')
            <span>{{ $message }}</span>
        @enderror
        <button type="submit">Login</button>
    </form>
</body>

</html>
