<?php 
include 'inc/connect.inc.php';
if(!isset($_GET['post'])){
    header('location:index.php');
}
$post = $_GET['post'];
$added_by = $_GET['addedby'];
$user_posted_to = $_GET['userpostedto'];
if($post !=""){
    $date_added = date("y-m-d");
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