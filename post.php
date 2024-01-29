<?php
session_start();
include('connection.php');
include('functions.php');

//user must be looged in to access this page
$user_data = check_login($con);
$id=$_SESSION['active']['id'];
//$author_username = $_SESSION['active']['user_name'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $title = $_POST['post_title'];
  $content = $_POST['post_content'];
  
//insert into database
$sql = "INSERT INTO articles (post_title, post_content, user_id, created_at) 
VALUES ('$title', '$content', '$id', CURRENT_TIMESTAMP)";

  if(mysqli_query($con,$sql)){
    //echo 'New record created successfully';
    header("Location: index.php");
    die;
  }else{
    echo "Error : ".$sql. "<br>".mysqli_error($con);
  }
  mysqli_close($con);
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
                <div class="Title">NEW POST</div>
                <div class="inputs">
                    <input type="text" name="post_title" placeholder="enter title here" required>
                </div>
                <div class="inputs">
                    <input type="text" name="post_content" placeholder="type the content here" rows="8" cols="38" required>
                </div>
                <?php if(isset($error_message)){?>
                    <div class="error"><?php echo $error_message;?></div>
                <?php } ?>    
                
                <div class="Submit_button">
                    <button type="submit">Post</button>
                </div>
                <div class="sign_up">
                    <a href="./index.php">Go back home</a>
                </div>
            </form>
        </div>

</body>
</html>
