<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{{ config('app.name') }} | Login Success</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/logo/favicon.ico') }}" type="image/x-icon"/>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>

    <!-- App CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/dark.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/skins.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/animated.css') }}" rel="stylesheet"/>

    <!-- Fonts and Icons -->
    <link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet"/>

    <!-- Custom Styles -->
    <style>
        body {
           background: url('https://i.imghippo.com/files/QaUM5275qQ.jpg') center center/cover no-repeat;
            background-blur: 2px;
            background-size: cover;
            background-attachment: fixed;
            color: black;
        }
        .page {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            backdrop-filter: blur(10px);
        }
        .success-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 35px;
            max-width: 450px;
            width: 100%;
            text-align: center;
        }
        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #0c4572;
            border-color: #0c4572;
            border-radius: 30px;
            padding: 10px 30px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>

<body class="light-mode">
<div class="page">
    <div class="success-card">
        <div class="success-icon">
            <i class="fa fa-check-circle"></i>
        </div>
        
        <h2 class="mb-3">Login Successful!</h2>
        <p class="mb-4">You have successfully logged into your account.</p>
        
        <div class="mb-4">
            <a href="/api-login" class="btn btn-primary me-2">
                <i class="fa fa-sign-out"></i> Logout
            </a>
            <a href="/dashboard" class="btn btn-outline-primary">
                <i class="fa fa-dashboard"></i> Go to Dashboard
            </a>
        </div>
        
        <small class="text-muted">
            Your session is now active. You can access all features of the application.
        </small>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/vendors/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html> 