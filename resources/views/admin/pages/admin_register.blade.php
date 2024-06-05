<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Register</title>
    <style>
        @media only screen and (max-width: 600px) {
            .register-box {
                width: 99% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 600px) {
            .register-box {
                width: 99% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 768px) {
            .register-box {
                width: 99% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 992px) {
            .register-box {
                width: 95% !important;
                background: #999 !important
            }
        }

        @media only screen and (min-width: 1200px) {
            .register-box {
                width: 50% !important;
                background: #999 !important
            }
        }

        .register-page {
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

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('register_form') }}" class="h1"><b>Admin</b> Registration (Flat)</a>
            </div>
            <div class="card-body">
                {{-- <p class="login-box-msg">Register a new membership</p> --}}
                @if (Session::has('message'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('message') }}!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Enter FullName" required>
                        <div class="input-group-append" data-toggle="tooltip" data-placement="top"
                            title="Enter Full Name">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="phone"
                            placeholder="Enter a Valid Phone Number " required>
                        <div class="input-group-append" data-toggle="tooltip" data-placement="top"
                            title="Enter Phone Number">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <textarea name="address" id="" cols="" class="form-control" rows="" placeholder="Enter Address"
                            required></textarea>
                        <div class="input-group-append" data-toggle="tooltip" data-placement="top"
                            title="Enter your Address">
                            <div class="input-group-text">
                                <span class="fas fa-house-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="nid_no" placeholder="Enter NID / NRC Number"
                            required>
                        <div class="input-group-append" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                            title="Enter yor NID / NRC Number">
                            <div class="input-group-text">
                                <i class="fa fa-id-card"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Enter Valid Email"
                            required>
                        <div class="input-group-append" data-toggle="tooltip" data-placement="top"
                            title="Enter Your Valid Email">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Enter a Password"
                            required>
                        <div class="input-group-append" data-toggle="tooltip" data-placement="top"
                            title="Enter a Password">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Retype Password" required>
                        <div class="input-group-append" data-toggle="tooltip" data-placement="top"
                            title="Password Confirmation">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            {{-- <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div> --}}
                            <a href="{{ route('login_form') }}" class="text-center">I have already a membership</a>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
