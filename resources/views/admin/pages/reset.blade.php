<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset-Password</title>

    <style>
        @media only screen and (max-width: 600px) {
            .login-box {
                width: 90% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 600px) {
            .login-box {
                width: 90% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 768px) {
            .login-box {
                width: 90% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 992px) {
            .login-box {
                width: 80% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 1200px) {
            .login-box {
                width: 50% !important;
                background: #999 !important
            }
        }

        .login-page {
            width: 100%;
            opacity: .8;
        }
    </style>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('login_form') }}" class="h1">Reset Password</a>
            </div>
            <div class="card-body">
                {{-- <p class="login-box-msg">Admin Login Panel</p> --}}
                @if (Session::has('message'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('message') }}!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" required
                            autocomplete="current-password"placeholder="Enter New Password">
                        <div class="input-group-append" data-toggle="tooltip" data-placement="top" title="Enter New Password">
                            <div class="input-group-text">
                                <span class="fas fa-lock" ></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="confirm_password" required
                            autocomplete="cconfirm-password"placeholder="confirm_Password">
                        <div class="input-group-append" data-toggle="tooltip" data-placement="top" title="Password Confirmation">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- jQuery -->
        <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
