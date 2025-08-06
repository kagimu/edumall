<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{{ config('app.name') }} | Login</title>

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
        .login-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 35px;
            max-width: 450px;
            width: 100%;
        }
        .login-logo img {
            max-width: 200px;
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #0c4572;
            border-color: #0c4572;
            border-radius: 30px;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .input-group-text {
            background-color: #f0f0f0;
            border-radius: 30px 0 0 30px;
        }
        .form-control {
            border-radius: 0 30px 30px 0;
            padding: 15px;
        }
        .alert {
            font-size: 14px;
        }
    </style>
</head>

<body class="light-mode">
<div class="page">
    <div class="login-card">
        <div class="text-center login-logo">
            <img src="https://i.imghippo.com/files/ynwR3604kw.png" alt="Logo">
            <h3>Welcome</h3>
        </div>

        <div id="alert-container"></div>

        <form id="loginForm">
            <!-- Email -->
            <div class="input-group mb-3">
                <span class="input-group-text">
                    <i class="fa fa-user"></i>
                </span>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <!-- Password -->
            <div class="input-group mb-4">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">
                Sign In <i class="fa fa-arrow-right ms-2"></i>
            </button>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/vendors/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const email = formData.get('email');
    const password = formData.get('password');
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Signing In...';
    submitBtn.disabled = true;
    
    // Clear previous alerts
    document.getElementById('alert-container').innerHTML = '';
    
    fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
            .then(data => {
            if (data.message === 'Login successful.') {
                // Show success message
                showAlert('Login successful! Redirecting...', 'success');
                // Redirect to success page after a short delay
                setTimeout(() => {
                    window.location.href = '/login-success';
                }, 1000);
            } else {
                showAlert(data.message || 'Login failed. Please try again.', 'danger');
            }
        })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred. Please try again.', 'danger');
    })
    .finally(() => {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function showAlert(message, type) {
    const alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
}
</script>
</body>
</html> 