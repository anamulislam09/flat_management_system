<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Register-Verified</title>
    <style>
        @media only screen and (max-width: 600px) {
            .login-box {
                width: 95% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 600px) {
            .login-box {
                width: 95% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 768px) {
            .login-box {
                width: 95% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 992px) {
            .login-box {
                width: 90% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 1200px) {
            .login-box {
                width: 50% !important;
                background: #999 !important
            }
        }

        .login-box {
            width: 70% !important;
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
        <div style="background: #f3f2f2; padding:30px 20px; text-align:center">
            <p>Welcome <b>{{ $client->name }}</b></p>
            <p>Your mobile is Verified! Please wait for admin approval.</p>
            <a href="{{route('login_form')}}">Login</a>
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
