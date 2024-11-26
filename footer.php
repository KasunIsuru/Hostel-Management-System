<!-- footer.html -->
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

        footer {
            background-color: #111;
            color: white;
            padding: 2rem;
            font-family: Arial, sans-serif;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .footer-logo {
            width: 100px;
        }

        .footer-links h3 {
            margin-bottom: 1rem;
            color: white;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            color: #ccc;
            text-decoration: none;
        }

        .copyright {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #333;
            color: #666;
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <footer>
        <div class="footer-content">
            <div>
                <img src="./images/img/logouoc.png" alt="Footer Logo" class="footer-logo">
                <div class="social-links">
                    <a href="#twitter">Twitter</a>
                    <a href="#facebook">Facebook</a>
                    <a href="#linkedin">LinkedIn</a>
                    <a href="#youtube">YouTube</a>
                </div>
            </div>

            <div class="footer-links">
                <h3>CONTACT US</h3>
                <p>Faculty of Technology,<br>
                    University of Colombo,<br>
                    Mahanwatta, Pitipana,<br>
                    Homagama,<br>
                    Sri Lanka.</p>
            </div>

            <div class="footer-links">
                <h3>USEFUL LINKS</h3>
                <ul>
                    <li><a href="#privacy">Privacy Policy</a></li>
                    <li><a href="#university">University of Colombo</a></li>
                    <li><a href="#email">University Email Policy</a></li>
                    <li><a href="#vision">Vision and Mission</a></li>
                    <li><a href="#announcements">Announcements</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            © 2024 Faculty of Technology, University of Colombo, Sri Lanka. All rights reserved.
        </div>
    </footer>
</body>

</html>