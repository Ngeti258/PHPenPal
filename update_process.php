<?php
include_once 'connection.php';

// Initialize variables
$error_message = "";
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_GET['post_id']; // Get post_id from the URL

    // Validate and sanitize user inputs
    $postTitle = mysqli_real_escape_string($con, $_POST['post_title']);
    $postContent = mysqli_real_escape_string($con, $_POST['post_content']);

    // Check if inputs are not empty
    if (!empty($postTitle) && !empty($postContent)) {
        // Update the post in the database
        $sql = "UPDATE articles SET post_title='$postTitle', post_content='$postContent' WHERE post_id='$post_id'";
        if (mysqli_query($con, $sql)) {
            $message = "Post updated successfully.";
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Error updating post: " . mysqli_error($con);
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}

// Fetch the current post details
$result = mysqli_query($con, "SELECT * FROM articles WHERE post_id='" . $_GET['post_id'] . "'");
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Blog</title>
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
            margin-bottom: 70px;
            text-align: center;
        }

        .form-content .inputs input {
            text-align: center;
            height: 50px;
            width: 340px;
            border-radius: 20px;
            font-size: 20px;
            margin-bottom: 10px;
            word-wrap: break-word; /* Allow words to break and wrap */
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
            margin-top: 50px;
        }

        .content {
            height: 100px;
            width: 400px;
            margin-bottom: 60px;
            border-radius: 20px;
            text-align: center;
            font-size: 15px;
            word-wrap: break-word;
        }

        .sign_up a {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    
    <div><?php if (isset($message)) { echo $message; } ?></div>

    <div class="image-container">
        <img src="./images//bar_images/blog.avif" alt="Cool Image">
    </div>

    <div class="form-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?post_id=" . $_GET['post_id']; ?>" method="POST">
            <div class="Title">UPDATE POST</div>
            <div class="inputs">
                <input type="text" name="post_title" required value="<?php echo isset($row['post_title']) ? $row['post_title'] : ''; ?>">
            </div>
            <div>
                <input type="text" name="post_content" class="content" required value="<?php echo isset($row['post_content']) ? $row['post_content'] : ''; ?>">
            </div>
            <?php if(isset($error_message)){?>
                <div class="error"><?php echo $error_message;?></div>
            <?php } ?>    

            <div class="Submit_button">
                <button type="submit">POST</button>
            </div>
            <div class="sign_up">
                    <a href="./index.php">Go back home</a>
                </div>
        </form>
    </div>
</body>
</html>