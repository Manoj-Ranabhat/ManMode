<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManMode Footer</title>
    <style>
        /* Footer Styles */
        footer {
            background-color: #1d1b1e;
            color: white;
            padding: 40px 20px 20px 20px;
            border-top: 1px solid #e0dbdb;
            font-family: 'Arial', sans-serif;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }


        .footer-section {
            flex: 1 1 250px;
            margin: 20px;


        }

        .footer-section-link {
            flex: 1 1 250px;
            color: white;
            margin: 20px;
            position: relative;
            left: 170px;
        }

        .footer-section-link li {
            flex: 1 1 250px;
            list-style: none;


        }

        .footer-section-link a {
            flex: 1 1 250px;
            text-decoration: none;
            color: #ccc;
            font-size: 16px;
            position: relative;
            right: 40px;



        }

        .footer-section-link ul li a {
            display: block;
            margin-bottom: 10px;
        }

        .footer-section-contact {
            flex: 1 1 250px;
            margin: 20px;
            position: relative;
            left: 120px;
        }


        .footer-section h4 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #fff;
        }

        .footer-section p,
        .footer-section ul {
            margin: 0;
            padding: 0;
            list-style: none;
            color: #ccc;
            font-size: 16px;
            line-height: 1.6;
        }

        .footer-section ul {
            margin-top: 10px;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-section ul li a {
            text-decoration: none;
            color: #ccc;
            font-size: 16px;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #f0c040;
            text-decoration: underline;
        }

        .footer-bottom {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #444;
            font-size: 14px;
            color: #aaa;
        }
    </style>
</head>

<body>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Men's Grooming Products</h4>
                <p>Learn more about our premium products and brand story.</p>
            </div>
            <div class="footer-section-link">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="product.php">Products</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section-contact">
                <h4>Contact Us</h4>
                <p>Email: ManMode@gmail.com</p>
                <p>Phone: 9810103344</p>
                <p>Address: Kathmandu, Kalanki</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 ManMode. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>