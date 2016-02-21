<?php 
include 'inc/connect.inc.php';

$post = $_GET['post'];
if($post !=""){
    $date_added = date("y-m-d");
    $added_by = "test123";
    $user_posted_to = "test123";
    $sql_command = "INSERT INTO posts VALUES('','$post','$date_added','$added_by','$user_posted_to')";
    $query = mysqli_query($conn,$sql_command) or die(mysqli_error($conn));
    if($query){
        echo 'posted successfully..';
    }
}
else{
    echo 'You must enter something in your post field before you post it !!!';
}
?>