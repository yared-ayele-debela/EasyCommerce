<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <!-- Bootstrap 4 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .app-brand-logo {
            width: 100px;
            height: auto;
        }
        .btn-primary {
            background: #17BE18;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #14a914;
        }
        .form-control {
            border-radius: 0.5rem;
        }
        .text-muted a {
            text-decoration: none;
            color: #17BE18;
        }
        .text-muted a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-lg-5 col-md-6">
        <div class="card p-4">
            <div class="card-body">
                <div class="pb-3 text-center">
                    <img src="{{ asset('/storage/appsettings/'.$appsettings[0]['logo']) }}" class="app-brand-logo">
                </div>
                <h4 class="font-weight-bold text-dark text-center">Admin Login</h4>
                <p class="text-muted text-center">Enter your credentials to access your account</p>

                <form method="POST" action="{{ url('admin/login') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group text-left">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Please enter a valid email address!</div>
                    </div>
                    <div class="form-group text-left">
                        <label for="yourPassword">Password</label>
                        <input type="password" name="password" class="form-control" id="yourPassword" pattern=".{8,}" title="At least 8 characters required" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                </form>
                <div class="mt-3">
                    <p class="text-muted"><a href="{{ url('admin/forget-password') }}">Forgot your password?</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 4 JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Bootstrap validation
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

</body>
</html>
