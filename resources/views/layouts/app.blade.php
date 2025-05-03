<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco Login Portal</title>
    <style>
        :root {
            --primary: #199254;
            --secondary: #5ace5a;
            --tertiary: #a0cc36;
            --quaternary: #36cc91;
            --primary-rgb: 25, 146, 84;
            --secondary-rgb: 90, 206, 90;
            --tertiary-rgb: 160, 204, 54;
            --quaternary-rgb: 54, 204, 145;
            --primary-darker: #167f49;
            --secondary-darker: #4db14d;
            --tertiary-darker: #8bb330;
            --quaternary-darker: #2eb580;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .bg-shape {
            position: absolute;
            z-index: -1;
        }

        .shape-1 {
            top: -20%;
            left: -10%;
            width: 40%;
            height: 70%;
            background: rgba(var(--primary-rgb), 0.1);
            border-radius: 50%;
            transform: rotate(-20deg);
        }

        .shape-2 {
            bottom: -30%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: rgba(var(--tertiary-rgb), 0.1);
            border-radius: 50%;
        }

        .shape-3 {
            top: 10%;
            right: 20%;
            width: 20%;
            height: 20%;
            background: rgba(var(--quaternary-rgb), 0.1);
            border-radius: 50%;
        }

        .container {
            width: 900px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
        }

        .login-image {
            width: 50%;
            background: linear-gradient(135deg, var(--primary), var(--quaternary));
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
        }

        .login-image h2 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-image p {
            text-align: center;
            margin-bottom: 30px;
            font-size: 16px;
            line-height: 1.6;
        }

        .login-form {
            width: 50%;
            padding: 50px 40px;
        }

        .login-form h1 {
            color: var(--primary);
            margin-bottom: 30px;
            font-size: 32px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.2);
        }

        .form-check {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }

        .form-check input {
            margin-right: 10px;
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
        }

        .form-check label {
            font-size: 14px;
            color: #777;
        }

        .forgot-password {
            text-align: right;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: var(--primary-darker);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(var(--primary-rgb), 0.4);
        }

        .register-link {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .leaf-decoration {
            position: absolute;
            opacity: 0.1;
        }

        .leaf-1 {
            top: 10%;
            left: 10%;
            font-size: 40px;
            transform: rotate(-20deg);
        }

        .leaf-2 {
            bottom: 15%;
            right: 15%;
            font-size: 60px;
            transform: rotate(20deg);
        }

        .social-login {
            margin-top: 25px;
            text-align: center;
        }

        .social-login p {
            color: #777;
            font-size: 14px;
            margin-bottom: 15px;
            position: relative;
        }

        .social-login p::before,
        .social-login p::after {
            content: "";
            display: inline-block;
            width: 25%;
            height: 1px;
            background-color: #ddd;
            vertical-align: middle;
            margin: 0 10px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-icon:hover {
            background-color: #e5e5e5;
            transform: translateY(-3px);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 45px;
            cursor: pointer;
            color: #777;
        }

        @media (max-width: 900px) {
            .container {
                width: 90%;
                flex-direction: column;
            }

            .login-image,
            .login-form {
                width: 100%;
            }

            .login-image {
                padding: 30px 20px;
            }

            .login-form {
                padding: 30px 20px;
            }
        }

        /* Animation */
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0);
            }
            50% {
                transform: translateY(-10px) rotate(5deg);
            }
            100% {
                transform: translateY(0) rotate(0);
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>
{{ $slot }}
</body>
</html>