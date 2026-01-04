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
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/employee.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light admin-navbar">
    <div class="container-fluid">
        <h1 class="navbar-brand h4 m-0">N:Company</h1>
        <div id="current-date-time" class="small fw-semibold">
            {{ \Carbon\Carbon::now()->format('j F, Y H:i') }}
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('employee.profile') }}" class="nav-link" title="Profile">
                @if (!Auth::user()->profile_picture)
                    <img src="{{ asset('images/icon.jpg') }}" class="navbar-icon"
                         style="width: 32px; height: 32px; border-radius: 50%;">
                @else
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="navbar-icon"
                         style="width: 32px; height: 32px; border-radius: 50%;">
                @endif
            </a>
            <a href="#" class="nav-link position-relative" title="Notifications" data-bs-toggle="dropdown">
                <img src="{{ asset('images/notification.png') }}" class="navbar-icon" style="width: 32px; height: 32px;">
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                @forelse(auth()->user()->notifications as $notification)
                    <li>
                        <a class="dropdown-item {{ $notification->read_at ? '' : 'fw-bold text-success' }}"
                           href="{{ route('notifications.handle', $notification->id) }}">
                            @if ($notification->type === 'App\Notifications\LeaveRequestNotification')
                                <strong>{{ $notification->data['message'] }}</strong><small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            @elseif($notification->type === 'App\Notifications\NoticeCreatedNotification')
                                <strong>{{ $notification->data['message'] }}</strong> <small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            @elseif($notification->type === 'App\Notifications\EventCreatedNotification')
                                <strong>{{ $notification->data['message'] }}</strong> <small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            @elseif($notification->type === 'App\Notifications\LeaveUpdatedNotification')
                                <strong>{{ $notification->data['message'] }}</strong> <small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            @elseif($notification->type === 'App\Notifications\AssetUpdatedNotification')
                                <strong>{{ $notification->data['message'] }}</strong> <small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            @elseif($notification->type === 'App\Notifications\AssetAssignedNotification')
                                <strong>{{ $notification->data['message'] }}</strong> <small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            @else
                                {{ $notification->data['message'] ?? 'New notification' }}
                            @endif
                        </a>
                    </li>
                @empty
                    <li><a class="dropdown-item text-muted">No new notifications</a></li>
                @endforelse
            </ul>
            <form action="{{ route('logout') }}" method="post" class="m-0 d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0 border-0" title="Logout" style="background: none;">
                    <img src="{{ asset('images/logout.png') }}" class="navbar-icon"
                         style="width: 32px; height: 32px;">
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="d-flex">
    <nav class="admin-sidebar">
        <a href="{{ route('employee.dashboard') }}" class="d-block">Dashboard</a>
        <a href="{{ route('employee.assets.index') }}" class="d-block">My Assets</a>
        <a href="{{ route('employee.attendances.index') }}" class="d-block">My Attendances</a>
        <a href="{{route('employee.salaries.index')}}" class="d-block">My Salaries</a>
        <a href="{{ route('employee.leaves.index') }}" class="d-block">My Leaves</a>
        <a href="{{ route('employee.events.index') }}" class="d-block">Events</a>
        <a href="{{ route('employee.notices.index') }}" class="d-block">Notices</a>
    </nav>

    <main class="admin-main">
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
