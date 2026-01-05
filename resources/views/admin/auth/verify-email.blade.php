<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - N:Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body class="login-page verify-page">
<div class="company-brand">
    <span>N:Company</span> Employee Management System
</div>

<div class="login-container">
    <div class="login-card">
        <div class="login-header text-center mb-4">
            <h1 class="mb-2">Verify Your Email</h1>
            <p class="text-muted">Please verify your email address to continue</p>
        </div>

        <div class="user-greeting">
            Hi <strong>{{ auth()->user() ? auth()->user()->name : 'there' }}</strong>,
        </div>

        <div class="instructions">
            <p>Thanks for signing up! Before continuing, please check your email for a verification link.</p>
            <p>If you didn't receive the email, you can request another one below.</p>
        </div>

        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                A verification link has been sent to your email address.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="form-actions">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-fill">
                @csrf
                <button type="submit" class="btn btn-midnight w-100">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="flex-fill">
                @csrf
                <button type="submit" class="btn btn-midnight w-100">
                    Logout
                </button>
            </form>
        </div>

        <hr class="my-4">

        <div class="note">
            <p class="mb-0">If you can't find the verification email, check your spam/junk folder or confirm the email address in your account settings.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
