
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    {{-- @vite('resources/css/app.css') --}}
    <style>
        body {
            font-family: "Poppins", sans-serif;
        }
        * {
            font-family: inherit;
        }
        .sidebar {
            width: 220px;
            min-height: 100vh;
            border-right: 1px solid #ddd;
            padding: 15px;
        }
        .sidebar a{
            text-decoration: none;
            color: inherit;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <header class="navbar navbar-light bg-light px-3 border-bottom">
        <h1 class="h4 m-0">N:Company EMS</h1>

        <nav class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.profile') }}" class="text-decoration-none">Profile</a>
            <a href="#" class="text-decoration-none">Notification</a>

            <form action="{{ route('logout') }}" method="post" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
            </form>
        </nav>
    </header>

    <div class="d-flex">
        <nav class="sidebar bg-white">
            <a href="{{ route('dashboard') }}" class="d-block mb-2">Dashboard ✅</a>
            <a href="{{ route('employees.index') }}" class="d-block mb-2">Employees ✅</a>
                        <a href="#" class="d-block mb-2">Contracts</a>
            <a href="{{ route('departments.index') }}" class="d-block mb-2">Departments ✅</a>
            <a href="{{ route('notices.index') }}" class="d-block mb-2">Notices ✅</a>
            <a href="{{ route('assets.index') }}" class="d-block mb-2">Assets ✅</a>
            <a href="#" class="d-block mb-2">Salaries</a>
            <a href="#" class="d-block mb-2">Attendances</a>
            <a href="{{ route('events.index') }}" class="d-block mb-2">Events ✅</a>
        </nav>
        <main class="grow p-4">
            @yield('content')
        </main>
    </div>
</body>
</html>





