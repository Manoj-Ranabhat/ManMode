<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Us - ManMode</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      margin: 0;
      background-color: #f4f4f4;
      color: #222;
    }

    .contact-header {
      background: #e2dcdc;
      color: #817474;
      text-align: center;
      padding: 50px 20px;
    }

    .contact-header h1 {
      font-size: 3rem;
      margin: 0;
    }

    .contact-section {
      max-width: 900px;
      margin: 40px auto 80px;
      background-color: #fff;
      padding: 40px 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .contact-section h2 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #333;
      text-align: center;
    }

    .contact-section p {
      text-align: center;
      margin-bottom: 30px;
      color: #666;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    input, textarea {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border 0.3s ease;
    }

    input:focus, textarea:focus {
      border-color: #333;
      outline: none;
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    button {
      padding: 12px;
      background-color: #333;
      color: #fff;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #555;
    }

    .contact-details {
      margin-top: 40px;
      text-align: center;
      color: #444;
    }

    .contact-details p {
      margin: 5px 0;
    }

    @media (max-width: 600px) {
      .contact-section {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <?php include_once('../includes/header.php'); ?>

  <div class="contact-header">
    <h1>Contact Us</h1>
  </div>

  <div class="contact-section">
    <h2>We'd Love to Hear From You</h2>
    <p>Have questions, feedback, or a custom grooming need? Fill out the form below and we’ll get back to you as soon as possible.</p>

    <form id="contactform" action="submit_contact.php" method="post" onsubmit="return submitForm();">
    <input type="text" name="name" placeholder="Your Name" required />
    <input type="email" name="email" placeholder="Your Email" required />
    <input type="text" name="subject" placeholder="Subject" required />
    <textarea name="message" placeholder="Your Message" required></textarea>
    <div class="form-group">
        <button type="submit">Submit</button>
    </div>
</form>




    <div class="contact-details">
      <p>Email: support@manmode.com</p>
      <p>Phone: +977-9810103344</p>
      <p>Location: Kathmandu, Nepal</p>
    </div>
  </div>

  <?php include_once('../includes/footer.php'); ?>
</body>
</html>
<script>
    function submitForm() {
        // Show thank you message
        alert("Thank you for contacting us!");
        
        // Redirect to home.php after 2 seconds (to allow the alert to be visible)
        setTimeout(function() {
            window.location.href = "customer_index.php";
        }, 2000);

        return false; // Prevent form from submitting the traditional way
    }
</script>

