<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        
        <!-- jQuery Validation -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <!--  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(to right, #1C1C1C, #2C2C2C); /* Gradient background */
            color: #f0f0f0;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        h1 { 
            
            font-size: 60PX;
            
            font-family: Arial, Helvetica, sans-serif; 
            background: linear-gradient(45DEG, #DC143C,#800020,#F5F5F5); 
            -webkit-text-fill-color: transparent; 
            -webkit-background-clip: text; 
            
        } 
        
        
        .container {
            flex: 1;
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
        .music-note {
            position: absolute;
            font-size: 14px; /* Smaller music icon */
            animation: fly 1.5s ease-out forwards;
            pointer-events: none;
        }
        @keyframes fly {
            0% {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(-10px, -10px) scale(1.1);
            }
            50% {
                transform: translate(15px, -20px) scale(0.9);
            }
            100% {
                opacity: 0;
                transform: translate(-20px, -40px) scale(0.7);
            }
        }
        .button {
            left:35%;
            position: relative;
            overflow: hidden;
            height: 3rem;
            padding: 0 2rem;
            border-radius: 1.5rem;
            background: #3d3a4e;
            background-size: 400%;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        
        .button:hover::before {
            transform: scaleX(1);
        }

        .button-content {
            position: relative;
            z-index: 1;
        }
        
        .button::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            transform: scaleX(0);
            transform-origin: 0 50%;
            width: 100%;
            height: inherit;
  border-radius: inherit;
  background: linear-gradient(
    82.3deg,
    rgba(220, 20, 60, 1) 10.8%,
    rgba(128, 0, 32, 1) 94.3%
    );
    transition: all 0.475s;
}

</style>
    <!--  -->
    
    <script>
        $(document).ready(function(){
            $("#RegisterForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    pass: {  // Updated to match the input field name
                        required: true,
                        minlength: 6
                    },
                    c_pass: {  // Updated to match the input field name
                        required: true,
                        minlength: 6,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Name must be at least 3 characters long"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    pass: {  // Updated to match the input field name
                        required: "Please enter a password",
                        minlength: "Password must be at least 6 characters long"
                    },
                    c_pass: {  // Updated to match the input field name
                        required: "Please confirm password",
                        minlength: "Password is not matching",
                        equalTo: "Passwords do not match"
                    }
                },
                errorClass: "text-danger",
                submitHandler: function(form){
                    form.submit();
                }
            });
        });
        </script>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary">Register</h1>
        <form id="RegisterForm" class="mx-auto" style="max-width: 400px; position: relative;" method="post" action="registering.php">
            <?php
            if(isset($_SESSION['signup_error']) && !empty($_SESSION['signup_error'])){
                echo "<p style='color:red;'>".$_SESSION['signup_error']. "</p>";
                unset($_SESSION['signup_error']);
            }
            if(isset($_SESSION['signup_success']) && !empty($_SESSION['signup_success'])){
                echo "<p style='color:green;'>".$_SESSION['signup_success']. "</p>";
                unset($_SESSION['signup_success']);
            }
            ?>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control typing-field" id="name" placeholder="Enter your full name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control typing-field" id="email" placeholder="Enter your email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control typing-field" id="password" placeholder="Create a password" name="pass">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control typing-field" id="confirm_password" placeholder="Confirm password" name="c_pass">
            </div>
            <button class="button" type="submit" name="signup">
                <span class="button-content">Register</span>
            </button>
        </form>
    </div>
</body>
</html>

