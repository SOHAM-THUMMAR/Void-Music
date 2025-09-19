<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    $("#forgot").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            }
        },
        errorClass: "text-danger",
        submitHandler: function(form) {
            alert("Form is valid! Submitting...");
            form.submit();
        }
    });
});

</script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1C1C1C, #2C2C2C);
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
            font-size: 14px;
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
        /* button */

        .button {
            left:33%;
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
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary">Forgot Password</h1>
        <?php
session_start();
if (isset($_SESSION['signup_success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['signup_success'] . '</div>';
    unset($_SESSION['signup_success']);
}
if (isset($_SESSION['signup_error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['signup_error'] . '</div>';
    unset($_SESSION['signup_error']);
}
?>

        <form class="mx-auto" style="max-width: 400px; position: relative;" id="forgot" method="post" action="forgot_pass_mail_chack.php">
            <div class="mb-3">
                <p class="text-light">Enter your email address and we'll send you a link to reset your password.</p>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control typing-field" id="email" placeholder="Enter your email" name="email">
            </div>
            <button class="button" type="submit" name="send">
                <span class="button-content">Send Mail</span>
            </button>
            <div class="text-center mt-3">
                <a href="login.php" class="text-light">Back to Login</a>
            </div>
        </form>
    </div>
    <footer>
        <p>&copy; 2025 Fierce Femmes. All Rights Reserved.</p>
    </footer>

    <script>
        function createMusicNote(event) {
            const input = event.target;

            if (input.id === 'email') return;

            const caretPosition = getCaretCoordinates(input, input.selectionStart);

            const note = document.createElement('span');
            note.textContent = '🎵';
            note.className = 'music-note';
            note.style.left = `${caretPosition.left}px`;
            note.style.top = `${caretPosition.top}px`;

            document.body.appendChild(note);

            note.addEventListener('animationend', () => {
                note.remove();
            });
        }

        function getCaretCoordinates(input, position) {
            const div = document.createElement('div');
            const style = getComputedStyle(input);

            for (let prop of style) {
                div.style[prop] = style[prop];
            }
            div.style.position = 'absolute';
            div.style.whiteSpace = 'pre-wrap';
            div.style.visibility = 'hidden';

            div.textContent = input.value.substring(0, position);

            const span = document.createElement('span');
            span.textContent = input.value.substring(position) || '.';
            div.appendChild(span);

            document.body.appendChild(div);

            const { offsetLeft, offsetTop } = span;
            const { left, top } = input.getBoundingClientRect();

            document.body.removeChild(div);

            return {
                left: left + offsetLeft,
                top: top + offsetTop + window.scrollY,
            };
        }

        document.querySelectorAll('.typing-field').forEach(input => {
            input.addEventListener('input', createMusicNote);
        });
    </script>
</body>
</html>