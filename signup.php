<?php
session_start();

// Include database connection and utility functions
include("connection.php");
include("functions.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get user input from the form
    $UserName = mysqli_real_escape_string($con, $_POST['UserName']);
    $Email = mysqli_real_escape_string($con, $_POST['Email']);
    $Password = mysqli_real_escape_string($con, $_POST['Password']);
    $Confirm_Password = mysqli_real_escape_string($con, $_POST['Confirm_Password']);

    // Check if the email already exists in the 'users' table
    $check_email_query = "SELECT * FROM users WHERE email='$Email' LIMIT 1";
    $result = mysqli_query($con, $check_email_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $error_message = "Error, a user with the same email already exists.";
    } elseif ($Confirm_Password !== $Password) {
        $error_message = "Error, passwords do not match.";
    } else {
        // Store plain text password in a session variable
        $_SESSION['plain_text_password'] = $Password;

        // Insert username into 'articles' table
        $username_to_articles_query = "INSERT INTO articles (author_username) VALUES ('$UserName')";
        mysqli_query($con, $username_to_articles_query);

        // Insert user details into 'users' table
        $insert_user_query = "INSERT INTO users (user_name, email, password) VALUES ('$UserName', '$Email', '$Password')";
        mysqli_query($con, $insert_user_query);

        // Redirect to the dashboard after successful signup
        header("Location: index.php");
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .image-container {
            flex: 1;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-content {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: wheat;
            border: 2px solid grey;
        }

        .form-content .Title {
            font-size: 40px;
            margin-top: 60px;
            margin-bottom: 60px;
            text-align: center;
        }

        .form-content .inputs {
            margin-bottom: 40px;
            text-align: center;
        }

        .form-content .inputs input {
            text-align: center;
            height: 50px;
            width: 340px;
            border-radius: 20px;
            margin-bottom: 5px;
        }

        .form-content .Submit_button {
            text-align: center;
        }

        .form-content .Submit_button button {
            height: 40px;
            width: 200px;
            background-color: green;
            color: white;
            border-radius: 20px;
            cursor: pointer;
        }
        .error {
            position: absolute;
            top: 0;
            left: 85%;
            transform: translateX(-50%);
            background-color: #FF0000;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .login {
            text-align: center;
            margin-top: 20px;
        }

        .login a {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="./images/bar_images/blog.avif" alt="Cool Image">
    </div>
    
    <div class="form-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="Title">REGISTER</div>
            <br>
            <!-- Add error message display -->

            <div class="inputs">
                <input type="text" name="UserName" placeholder="Enter username" required>
            </div>
            <div class="inputs">
                <input type="email" name="Email" placeholder="Enter your email" required>
            </div>
            <div class="inputs">
                <input type="password" name="Password" placeholder="Enter your password" required>
            </div>
            <div class="inputs">
                <input type="password" name="Confirm_Password" placeholder="Confirm your password" required>
            </div>

            <?php if (isset($error_message)) { ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php } ?>

            <div class="Submit_button">
                <button type="submit">Sign Up</button>
            </div>
            <div class="login">
                <a href="./login.php">Already have an account? Login</a>
            </div>
        </form>
    </div>
</body>
</html>
