<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <!-- velidation -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#loginForm").validate({
                    rules: {
                        email: {
                            required: true,
                email: true
            },
            pass: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            pass: {
                required: "Please enter a password",
                minlength: "Password must be at least 6 characters long"
            }
        },
        errorClass: "text-danger",
        submitHandler:function(form){
            form.submit();
        }
    });
});

</script>

<!-- velidation ends -->
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
        h1 { 
            
            font-size: 60PX;
            
            font-family: Arial, Helvetica, sans-serif; 
            background: linear-gradient(45DEG, #DC143C,#800020,#F5F5F5); 
            -webkit-text-fill-color: transparent; 
            -webkit-background-clip: text; 
            
        } 
        
        
        /* new btn  */
        .button {
            left:37%;
            position: relative;
            overflow: hidden;
            padding: 0 2rem;
            border-radius: 1.5rem;
            background: #3d3a4e;
            background-size: 400%;
            color: #fff;
            border: none;
            cursor: pointer;
            height: 3rem;
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
            
            .button2 {
                
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
            
            .button2:hover::before {
                transform: scaleX(1);
            }
            
            .button-content {
                position: relative;
                z-index: 1;
            }
            
            .button2::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                transform: scaleX(0);
                transform-origin: 0 50%;
                width: 100%;
                height: inherit;
                border-radius: inherit;
                background: linear-gradient(82.3deg,rgba(220, 20, 60, 1) 10.8%,rgba(128, 0, 32, 1) 94.3%);
                transition: all 0.475s;
            }
                
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><STrong>Login</STrong></h1>
        <form class="mx-auto" style="max-width: 400px; position: relative;" action="logining.php" id="loginForm" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control typing-field" id="email" placeholder="Enter your email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control typing-field" id="password" placeholder="Enter your password" name="pass">
            </div>
            <!-- From Uiverse.io by Madflows --> 
            <button class="button" type="submit" name="login">
                <span class="button-content">Login</span>
            </button>
            <div class="text-center mt-3">
                <a href="forgot-password.php" class="text-light">Forgot Password?</a> <!-- Link for Forgot Password -->
            </div>
            <br>
        </form>
        <P style="margin-left: 20%;"></P><center>
            <form action="register.php"style="max-width: 400px; position: relative;">
                <div class="mb-3">
                    <label for="" class="form-label">IF YOU HAVE NOT REGISTERED</label>
                    <br>
                    <br>
                    <button class="button2">
                        <span class="button-content">Register</span>
                    </button>
                    
                </form>
            </center>
            
            
        </div>
        <footer>
            <p>&copy; 2025 void. All Rights Reserved.</p>
        </footer>
        
        <script>
            // Function to create a flying music note
            function createMusicNote(event) {
                const input = event.target;
                
                // Skip animation for the name and email fields
                if (input.id === 'name' || input.id === 'email') return;
                
            const caretPosition = getCaretCoordinates(input, input.selectionStart);
            
            // Create the music note
            const note = document.createElement('span');
            note.textContent = '🎵'; // Music note emoji
            note.className = 'music-note';
            note.style.left = `${caretPosition.left}px`;
            note.style.top = `${caretPosition.top}px`;
            
            document.body.appendChild(note);
            
            // Remove the note after animation ends
            note.addEventListener('animationend', () => {
                note.remove();
                });
                }
                
                // Function to get caret position relative to the viewport
                function getCaretCoordinates(input, position) {
                    const div = document.createElement('div');
                    const style = getComputedStyle(input);
                    
                    // Copy input styles to the div
                    for (let prop of style) {
                div.style[prop] = style[prop];
                }
            div.style.position = 'absolute';
            div.style.whiteSpace = 'pre-wrap';
            div.style.visibility = 'hidden';
            
            // Set the text content up to the caret position
            div.textContent = input.value.substring(0, position);
            
            // Add a marker at the caret position
            const span = document.createElement('span');
            span.textContent = input.value.substring(position) || '.';
            div.appendChild(span);
            
            document.body.appendChild(div);
            
            // Calculate caret coordinates
            const { offsetLeft, offsetTop } = span;
            const { left, top } = input.getBoundingClientRect();
            
            // Cleanup
            document.body.removeChild(div);
            
            // Return adjusted coordinates
            return {
                left: left + offsetLeft,
                top: top + offsetTop + window.scrollY,
                };
                }
                
                // Attach event listener to inputs
                document.querySelectorAll('.typing-field').forEach(input => {
            input.addEventListener('input', createMusicNote);
            });
        </script>
</body>
</html>


