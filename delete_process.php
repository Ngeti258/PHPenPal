<?php
include('connection.php');
$sql = "DELETE from articles where post_id = '" . $_GET['post_id'] . "'";
if (mysqli_query($con, $sql)) {
    header("Location: index.php");
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
mysqli_close($con);
?>