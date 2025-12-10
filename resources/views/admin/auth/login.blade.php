<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <style>
    body {
        font-family: 'Poppins', sans-serif;
    }
    * {
        font-family: inherit;
    }
</style>
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
