<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite('resources/css/app.css') --}}
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <style>
    body {
        font-family: 'Poppins', sans-serif;
        text-align: center;
        margin: 0;
        padding: 0;
    }
    * {
        font-family: inherit;
    }
</style>
</head>

<body>
    <header>
        <h1>N:Company EMS</h1>
        <nav>
            <a href="#">Profile</a>
            <a href="#">Notification</a>
            <a href=""></a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
    </header>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard ✅</a>
        <a href="{{ route('employees.index') }}">Employees</a>
        <a href="{{ route('departments.index') }}">Departments ✅</a>
        <a href="{{ route('notices.index') }}">Notices ✅</a>
        <a href="#">Assets</a>
        <a href="#">Salaries</a>
        <a href="#">Attendances</a>
        <a href="{{ route('events.index') }}">Events ✅</a>
    </nav>
    <main>
        @yield('content')
    </main>

</body>

</html>
