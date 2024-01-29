<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

function greetings()
{
    $time = date('H');
    if ($time > 00 and $time < 10) {
        echo "Good Morning";
    } else if ($time >= 10 and $time < 16) {
        echo 'Good Afternoon';
    } else {
        echo 'Good evening';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Ngeti Blog</title>
    <style>
        body {
            padding: 0;
            margin: 0;
            background-image: url('./images/bar_images/blog.avif'); /* Replace with your image path */
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .posts {
            font-size: 35px;
            margin-top: 2%;
            text-align: center;
            color:aqua;
            width:70%;
        }

        .blog-post {
            background-color: #f8f9fa;
            margin: 1rem 0;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .blog-post img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .blog-post h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .blog-post .author {
            color: #6c757d;
            font-size: 1rem;
        }

        .navbar {
            background-color: #f8f9fa;
            padding: 1rem;
            width: 70%;
            text-align: center;
        }

        .navbar a {
            margin: 0 1rem;
            text-decoration: none;
            color: #495057;
            font-weight: bold;
        }

        .navbar a:hover {
            color: #007bff;
        }

        .navbar button {
            margin: 0 1rem;
            padding: 0.5rem 1rem;
        }

        .navbar button:hover {
            background-color: #007bff;
            color: #fff;
        }
        .navbar_1 {
            background-color: #f8f9fa;
            padding: 1rem;
            text-align: right;
            margin-top: -56px;
        }

        .navbar_1 a {
            margin: 0 1rem;
            text-decoration: none;
            color: #495057;
            font-weight: bold;
        }

        .navbar_1 a:hover {
            color: #007bff;
        }

        .navbar_1 button {
            margin: 0 1rem;
            padding: 0.5rem 1rem;
        }

        .navbar_1 button:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="./index.php">Ngeti Blog</a>
        </div>
        <div class="navbar_1">
        <a href="./post.php">New Post</a>
        <a href="./logout.php">Logout</a>
        </div>
 

    <div class="container">
        <div class="posts">
            <?php
            greetings();
            echo ", " . ($_SESSION['active']['user_name']) . '<br>....................................................';
            ?>
        </div>

        <?php
       $sql = "SELECT * FROM `articles` INNER JOIN `users` ON `users`.`id` = `articles`.`user_id` ORDER BY `articles`.`created_at` DESC LIMIT 5";
        $results = mysqli_query($con, $sql);

        if (!$results) {
            die("Error in SQL query: " . mysqli_error($con));
        }
        
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                ?>
                <div class="blog-post">
                    <!-- <img src="path/to/your/image.jpg" alt="Post Image"> -->
                    <h2><?php echo strtoupper($row['post_title']); ?></h2>
                    <p class="author">Author: <?php echo $row['user_name']; ?></p>
                     <?php echo $row['post_content']; ?>
                     <br/>
                            
                    <?php if ($_SESSION['active']['id'] == $row['user_id']) : ?>
                        <p>
                            <a href="update_process.php?post_id=<?php echo $row['post_id']; ?>">Update</a> |
                            <a href="delete_process.php?post_id=<?php echo $row['post_id']; ?>">Delete</a>
                        </p>
                    <?php endif; ?>
                    
                    <p class="author">Published at: <?php echo $row['created_at']; ?></p>
                </div>
                <?php
            }
        } else {
            echo "No records found";
        };
        ?>
    </div>
</body>
</html>
