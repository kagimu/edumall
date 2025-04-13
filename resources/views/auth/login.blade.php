<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <title>{{config('app.name')}} | Login</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/logo/favicon.ico') }}" type="image/x-icon"/>

    <!-- Bootstrap css -->
    <link href="../../assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />

    <!-- Custom styles -->
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link href="../../assets/css/dark.css" rel="stylesheet" />
    <link href="../../assets/css/skins.css" rel="stylesheet" />
    <link href="../../assets/css/animated.css" rel="stylesheet" />
    <link href="../../assets/plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="../../assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="../../assets/plugins/web-fonts/plugin.css" rel="stylesheet" />

    <!-- Custom login page styles -->
    <style>
        body {
            background: url('https://i.imghippo.com/files/WwB1445I.jpg') center center/cover no-repeat;
            background-blur: 10px;
            background-size: cover;
            background-attachment: fixed;
            color: white;
        }
        .page {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            backdrop-filter: blur(10px);
        }
        .login-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 450px;
        }
        .login-logo img {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .card-body {
            padding: 30px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .input-group-addon svg {
            width: 20px;
            height: 20px;
            fill: #6c757d;
        }
        .input-group .form-control {
            border-radius: 30px;
            padding: 15px;
        }
        .input-group-addon {
            border-radius: 30px;
        }
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .text-center {
            text-align: center;
            color: #000;
            margin-bottom: 50px;
        }
    </style>
</head>

<body class="light-mode">
<div class="page">
    <div class="login-card">
        <div class="text-center login-logo">
            <!-- Add your logo here -->
            <img src="https://i.imghippo.com/files/dstf2415FDA.png" alt="Logo">

            <h3 class="text-center">Welcome</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email field -->
            <div class="input-group mb-3">
                <span class="input-group-addon">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3"/>
                        <circle cx="12" cy="8" opacity="1" r="2"/>
                        <path d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
                    </svg>
                </span>
                <input type="email" class="form-control" placeholder="Email" name="email" required>
            </div>

            <!-- Password field -->
            <div class="input-group mb-4">
                <span class="input-group-addon">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <g fill="none"><path d="M0 0h24v24H0V0z"/><path d="M0 0h24v24H0V0z" opacity="1"/></g>
                        <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity="1"/>
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
                    </svg>
                </span>
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>

            <!-- Submit button -->
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">
                    Sign In  <i class="fe fe-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="../../assets/js/vendors/jquery-3.5.1.min.js"></script>
<script src="../../assets/plugins/bootstrap/popper.min.js"></script>
<script src="../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="../../assets/plugins/othercharts/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>

</body>
</html>
