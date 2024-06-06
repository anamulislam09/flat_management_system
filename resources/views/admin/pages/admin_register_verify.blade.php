<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Register-verify</title>
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

        .login-page {
            background-image: url(../login.png);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
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
            <div class="card-header text-center py-4">
                <a href="#" style="text-decoration: none; color:rgb(6, 106, 119)" class="h1">Verify</a>
            </div>
            <div class="card-body">
                {{-- <p class="login-box-msg">Admin Login Panel</p> --}}
                @if (Session::has('message'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('message') }}!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.verfy.store') }}">
                    @csrf
                    @php
                        $client = App\Models\Client::where('id', $client->id)->first();
                    @endphp
                    <input type="hidden" name="client_id" value="{{$client->id}}">
                    <div class="form-group">
                        <span style="font-size:14px">We sent you a code by your mobile :
                            <b>{{ $client->phone }}</b></span>
                        <input type="text" class="form-control" name="otp" placeholder="Enter Code">
                    </div>
            </div>

            <div class=" d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-block">Verify</button>
            </div>
            </form>
            <!-- /.card-body -->
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
