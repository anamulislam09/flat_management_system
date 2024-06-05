<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>sdl-ltd</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .body {
            /* background: url('house2.jpg'); */
            /* height: 100%; */
            height: 827px;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            opacity: 1.1;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        li {
            float: left;
            border-right: 1px solid #bbb;
        }

        li:last-child {
            border-right: none;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #a19999;
        }

        .main h2 {
            font-weight: bold;
            font-size: 85px;
            font-family: cursive;
            /* color: #9cb12c; */
            color: #83df30de;
            transform: translateX(8px);

            text-transform: uppercase
        }

        .main {
            width: 50%;
            text-align: center;
            top: 30%;
            left: 25%;
            background: #c5c5c54f;
            position: absolute;
            border-radius: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">

            <ul>
                <li style="float:right"><a href="{{ route('register_form') }}">Admin Registration</a></li>
                <li style="float:right"><a href="{{ route('login_form') }}">Admin Login</a></li>/
                <li style="float:right"><a href="{{ route('user.login_form') }}">User Login</a></li>
            </ul>
        </div>
        <div class=" row body">
            <div class="col-lg-12 col-md-12 col-sm-12 main">
                    <h2>Welcome to our community</h2>
                
            </div>
        </div>
    </div>
</body>

</html>
