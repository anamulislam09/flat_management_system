<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .form-wrapper {
            display: flex;
            flex-direction: row;
            height: 100%;
        }

        .left-section {
            flex: 1;
            background-color: #3B4CB8;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .left-section h1 {
            margin-bottom: 10px;
        }

        .left-section a {
            color: white;
            text-decoration: none;
        }

        .left-section form {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 400px;
        }

        .left-section form input {
            margin-bottom: 15px;
            padding: 15px;
            border: none;
            border-radius: 5px;
        }

        label {
            margin-bottom: 7px;
            color: #bcdde7;
        }

        .left-section form button {
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #7A96D5;
            color: white;
            cursor: pointer;
            margin-top: 20px;
            transition: .3s;
            font-weight: 600
        }

        .left-section form button:hover {
            background-color: #3749a3;
        }

        .right-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right-section img {
            max-width: 100%;
            height: auto;
        }

        .link a{
            font-size: 14px;
            color: rgb(241, 239, 239);
            margin-right: 10px !important;
        }
        
        .link a:hover{
            color: rgb(147, 191, 236);
            border-bottom: 1px solid rgb(147, 191, 236);
        }

        @media (max-width: 767px) {
            .form-wrapper {
                flex-direction: column;
                height: auto;
            }

            .left-section form input {
                margin-bottom: 15px;
                padding: 15px;
                font-size: 14px;
                border: none;
                border-radius: 5px;
            }

            label {
                font-size: 14px;
                margin-bottom: 7px;
                color: #bcdde7;
            }

            .right-section {
                order: -1;
                /* Ensures the logo appears above the form */
                padding: 20px;
            }

            .left-section h1 {
                font-size: 28px;
            }

            .left-section p {
                font-size: 14px;
            }

            .right-section img {
                width: 50px;
                height: auto;
            }
        }

        @media (min-width: 768px) {

            .left-section form input {
                margin-bottom: 15px;
                padding: 15px;
                font-size: 14px;
                border: none;
                border-radius: 5px;
            }

            label {
                font-size: 14px;
                margin-bottom: 7px;
                color: #bcdde7;
            }

            .form-wrapper {
                flex-direction: row;
                height: 100%;
                /* Ensure height is 100% for larger screens */
            }

            .right-section {
                order: 2;
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .left-section h1 {
                font-size: 28px;
            }

            .left-section p {
                font-size: 14px;
            }

            .left-section {
                order: 1;
                flex: 1;
            }
        }
    </style>
</head>

<body>
    <div class="form-wrapper">
        <div class="right-section">
            <img src="{{ asset('admin/dist/img/logo.JPG') }}" alt="Flat Master Logo">
        </div>
        <div class="left-section">
            <h1>Let's you sign in</h1>
            <p>Welcome to Flat Master</p>
            @if (Session::has('message'))
                <div class="alert alert-danger" role="alert">
                    <strong class="text-danger">{{ Session::get('message') }}!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <label for="">Email</label>
                <input type="email" placeholder="Email" class="mt-2" name="email" required>
                <label for="">Password</label>
                <input type="password" placeholder="Password" name="password" required>

                <button type="submit">Sign In</button>
            </form>

            <div class="d-flex justify-content-between link">
                @if (Route::has('password.request'))
                    <a href="{{ route('admin.forgot-password') }}">Forgot your password?</a>
                @endif
                <a href="{{ route('register_form') }}">Create account?</a>
            </div>
        </div>
    </div>
</body>

</html>
