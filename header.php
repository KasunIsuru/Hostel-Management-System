<!-- header.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #660097;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .logo {
            width: 330px;
            height: 80px;
            padding: 4px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
        }

        .sign-up-btn {
            background-color: white;
            color: #4B0082;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .nav-links {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <header>

        <img src="./images/img/logo-web.png" alt="Logo" class="logo">

        <nav class="nav-links">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#announcements">Announcements</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>
</body>

</html>