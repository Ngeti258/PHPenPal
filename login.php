<?php
session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];

    // Read from the database
    $query = "SELECT * FROM users WHERE user_name='$UserName' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        if ($user_data['password'] === $Password) {
            $_SESSION['active'] = $user_data;
            header("Location: index.php");
            die;
        } else {
            $error_message="incorrect password for the email";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
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
        margin-bottom: 70px; /* Adjusted margin */
        text-align: center;
    }

    .form-content .inputs input {
        text-align: center;
        height: 50px;
        width: 340px;
        border-radius: 20px;
        margin-bottom: 10px; /* Spacing between input fields */
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
    .sign_up {
        text-align: center;
        margin-top: 20px;
    }

    .sign_up a {
        color: blue;
        text-decoration: none;
    }
</style>

<body>
    <div class="image-container">
        <img src="./images//bar_images/blog.avif" alt="Cool Image">
    </div>
    
        <div class="form-content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="Title">LOGIN</div>
                <div class="inputs">
                    <input type="text" name="UserName" placeholder="Enter username" required>
                </div>
                <div class="inputs">
                    <input type="password" name="Password" placeholder="Enter your password" required>
                </div>
                <?php if(isset($error_message)){?>
                    <div class="error"><?php echo $error_message;?></div>
                <?php } ?>    
                
                <div class="Submit_button">
                    <button type="submit">Login</button>
                </div>
                <div class="sign_up">
                    <a href="./signup.php">Don't have an account? Sign Up</a>
                </div>
            </form>
        </div>

</body>
</html>
