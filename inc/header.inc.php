<?php 
require_once ( dirname(__FILE__).'/connect.inc.php');
session_start();
if(!isset($_SESSION['user'])){
 $username = '';   
}else{
    $username = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SocialNetwork</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="<?php echo 'js/main.js'?>" type="text/javascript"></script>
        <script src="<?php echo 'js/jquery-2.2.0.min.js'?>" type="text/javascript"></script>
    </head>
    <body>
        <div class="headerMenu">
            <div id="wrapper">
                <div class="logo">
                    SocialNetwork
                </div>
                <div class="searchBox">
                    <input name="q" id="search" placeholder="Search anything...&#128269;" autofocus autocomplete="on">
                </div>
            </div>
        </div>
        <div id="menu">
             <a href="index.php">Home</a>
             <a href="javascript:void(0)">About</a>
            <?php 
            if(!@$username){ 
            ?>
             <a href="index.php">Sign Up</a>
             <a href="index.php">Sign In</a>
            <?php 
                                 } 
            else{ 
                ?>
                <a href="profile.php?u=<?php echo $username; ?>"><?php echo $username; ?>'profile</a>
                <a href="account_settings.php">Account Setting</a>
                <a href="logout.php">log out</a>
            <?php
            }
            ?>
        </div>