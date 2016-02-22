<?php include ( dirname(__FILE__).'/inc/header.inc.php' );?>
<?php
if(!$username){
    header('location:index.php');
}
echo 'Hello,'.$username;
echo '<br/> Would you like to logout <a href="logout.php">Logout</a>';
?>
<?php include ( dirname(__FILE__).'/inc/footer.inc.php' );?>