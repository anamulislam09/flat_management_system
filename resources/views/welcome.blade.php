<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Flat Master Property Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .container img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            background-color: #99938b;
            border-radius: 5px;
        }

        li {
            border-right: 1px solid #bbb;
        }

        li:last-child {
            border-right: none;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #a19999;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            li a {
                padding: 10px 14px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('admin/dist/img/logo.JPG') }}" alt="Flat Master Logo">
        <ul>
            <li><a href="{{ route('register_form') }}">Admin Registration</a></li>
            <li><a href="{{ route('login_form') }}">Admin Login</a></li>
            <li><a href="{{ route('user.login_form') }}">User Login</a></li>
        </ul>
    </div>
</body>

</html>