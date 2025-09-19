<?php
require 'includes/config.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = $_GET['id'];
$sql = "SELECT * FROM contact_us WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reply to Message</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
    <style>
        body {
            background: #0a0a0a;
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
        .form-control {
            background: #2C2C2C;
            color: white;
            border: none;
        }
        .form-control:focus {
            background: #3d3a4e;
            color: white;
            box-shadow: none;
        }
        .button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(45deg, #DC143C, #800020);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .button:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(255, 77, 77, 0.5);
        }
        .back-button {
            width: 100%;
            padding: 10px;
            background: #3d3a4e;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s;
        }
        .back-button:hover {
            transform: scale(1.05);
            background: #5a5775;
        }
        p {
            padding: 5px 0;
        }
        textarea {
            height: 150px;
        }
        .text-danger {
            color: #DC143C;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Reply to User</h2>
        <form id="replyForm" action="replying.php" method="post">
            <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Message:</strong> <?php echo $row['message']; ?></p>
            
            <div class="mb-3">
                <label for="reply" class="form-label">Your Reply:</label>
                <textarea class="form-control" name="reply" required></textarea>
            </div>
            
            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            <button type="submit" class="button">Send Reply</button>
            <button type="button" class="back-button" onclick="window.history.back();">Back</button>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            $("#replyForm").validate({
                rules: {
                    reply: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    reply: {
                        required: "Reply cannot be empty",
                        minlength: "Reply must be at least 5 characters long"
                    }
                },
                errorClass: "text-danger",
                submitHandler: function(form){
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
