<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="jquery/jquery.min.js"></script>
    <script src="jquery/jquery.validate.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #1C1C1C;
            color: #fff;
        }
        h1 {
            color: #DC143C;
        }
        .contact-form {
            background-color: #1C1C1C;
            padding: 20px;
            border-radius: 8px;
        }
        .form-control {
            background-color: #2C2C2C;
            color: #F5F5F5;
            border: none;
        }
        .form-control::placeholder {
            color: #bbb;
        }
        .form-control:focus {
            background-color: #444;
            color: #F5F5F5;
        }
        label.error {
            color: #ff4d4d;
            font-size: 14px;
        }
        button {
            background-color: #800020;
            border: none;
        }
        footer {
            background-color: #333;
            color: #ccc;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<?php include 'includes/sidebar2.php'; ?>
<div class="container mt-5">
    <h1 class="text-center">Contact Us</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="contact-form p-4 shadow">
                <form id="contactForm" method="post" action="contacting.php">
                    <?php
                    if(isset($_SESSION['contact_error']) && !empty($_SESSION['contact_error'])){
                        echo "<p style='color:red;'>".$_SESSION['contact_error']. "</p>";
                        unset($_SESSION['contact_error']);
                    }
                    if(isset($_SESSION['scontact_success']) && !empty($_SESSION['contact_success'])){
                        echo "<p style='color:green;'>".$_SESSION['contact_success']. "</p>";
                        unset($_SESSION['contact_success']);
                    }
                    ?>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Your Name">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="email" placeholder="Your Email">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Your Message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100" name="contact">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $("#contactForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 10
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Name should be at least 3 characters long"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Enter a valid email address"
                    },
                    message: {
                        required: "Please enter your message",
                        minlength: "Message should be at least 10 characters long"
                    }
                }
            });
        });
        </script>
    <footer>
        <p class="fixed-bottom"><center>&copy; 2025 void. All Rights Reserved.</center></p>
    </footer>

</body>
</html>


