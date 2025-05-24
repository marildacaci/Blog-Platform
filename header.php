<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Blog</title>
    <link href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #c2d9ff;
            display: flex;
            flex-direction: column;
        }

        header {
            width: 100%;
            background: #fff;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .header__container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo a {
            font-size: 26px;
            font-weight: bold;
            text-decoration: none;
            color: #1a73e8;
        }

        .main-navigation ul {
            list-style: none;
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .nav__link {
            text-decoration: none;
            font-weight: 500;
            color: #333;
            transition: color 0.3s ease;
        }

        .nav__link:hover {
            color: #1a73e8;
        }

        .login-link {
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            background-color: #1a73e8;
            color: white;
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .login-link:hover {
            background-color: #8f55f3;
            transform: scale(1.05);
        }

        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .main__content {
            background: #ffffff;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .main__content h1 {
            font-size: 2.5rem;
            color: #3e4e61;
            margin-bottom: 1rem;
        }

        .main__content p {
            font-size: 1.2rem;
            color: #555;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            width: 100%;
            background-color: #1a1a1a;
            color: #ccc;
            padding: 30px 2rem;
        }

        .footer__container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .footer__socials a {
            color: #ccc;
            font-size: 24px;
            margin: 0 10px;
            transition: color 0.3s ease;
            text-decoration: none;
        }

        .footer__socials a:hover {
            color: #1a73e8;
        }

        .footer__copyright {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .header__container {
                flex-direction: column;
                gap: 15px;
            }

            .main-navigation ul {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .main__content {
                padding: 2rem;
            }

            .main__content h1 {
                font-size: 2rem;
            }

            .main__content p {
                font-size: 1rem;
            }
        }

        .home-container {
            max-width: 1200px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 0 1rem;
        }

        .home-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .home-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .home-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: #1a73e8;
        }

        .home-paragraph {
            color: #555;
            font-size: 1rem;
        }

        .home-date {
            color: #999;
            display: block;
            margin-top: 0.5rem;
        }

        .post-container {
            max-width:800px; 
            margin:2rem auto; 
            padding:0 1rem;
        }

        .post-image {
            width:100%; 
            max-height:400px; 
            object-fit:cover; 
            border-radius:8px; 
            margin:1rem 0;
        }

        .post-paragraph {
            line-height:1.6; 
            color:#333; 
            margin-bottom:2rem;
        }

        .post-like-button {
            background:whitesmoke;
            color:black;
            border:none;
            padding:0.75rem 1.5rem;
            border-radius:6px;
            cursor:pointer;
        }

        .post-like-button.liked {
            background-color:rgb(36, 44, 208);
            color: white;
            border-color:rgb(255, 255, 255);
        }

        .post-comment {
            margin-bottom:1rem; 
            padding:0.75rem; 
            background:#f9f9f9; 
            border-radius:4px;
        }

        .post-comment-textarea{
            width:100%; 
            padding:0.75rem; 
            border-radius:4px; 
            border:1px solid #ccc;
        }

        .post-comment-button{
            background:#1a73e8;
            color:#fff;
            border:none;
            padding:0.5rem 1rem;
            border-radius:6px;
            cursor:pointer;
        }
    </style>
</head>

<body>

    <header>
        <div class="header__container">
            <div class="logo">
                <a href="./home.php">My Blog</a>
            </div>
            <nav class="main-navigation">
                <ul>
                    <li><a href="/categories" class="nav__link">Categories</a></li>
                    <li><a href="/about" class="nav__link">About</a></li>
                    <li><a href="#contact" class="nav__link">Contact</a></li>
                </ul>
            </nav>
            <div>
                <a href="./authentification/login.html" class="login-link">Login</a>
                <a href="profile.php" class="login-link">Profile</a>
                <a href="./admin/dashboard.html" class="login-link">Dashboard</a>
            </div>
        </div>
    </header>