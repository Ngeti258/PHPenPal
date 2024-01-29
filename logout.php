<?php
session_start();

session_unset();
session_destroy();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .logged_out_message{
            position: absolute;
            top: 20%;
            left: 40%;
        }
    </style>
</head>
<body>
    <div class="logged_out_message"><p>You have successfully logged out </p><br/>
    <a href="./login.php">Log in</a>

</div>    
</body>
</html>