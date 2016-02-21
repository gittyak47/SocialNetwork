<?php include ( dirname(__FILE__).'/inc/header.inc.php' );?>
<?php
if(!$username){
    header('location:index.php');
}
?>
<?php
// if requested to change password
if(@$_POST['change_password']){
if(@$_POST['change_password'] && $_POST['oldpassword'] && $_POST['newpassword'] && $_POST['newpasswordre']){
   // echo $_POST['oldpassword'].$_POST['newpassword'].$_POST['newpasswordre'];
    if($_POST['newpassword'] == $_POST['newpasswordre']){
    $pswdchngquery = mysqli_query($conn,"SELECT password FROM users WHERE username = '$username'");
    $chk_result = mysqli_num_rows($pswdchngquery);
    if($chk_result == 1){
        while($row = mysqli_fetch_assoc($pswdchngquery)){
            $password = $row['password'];
            //check whether entered old password equals actual password stored in database
            if(md5($_POST['oldpassword']) == $password){
                //echo $password;
                //continue changing password
                $newpasswordwncrypted = md5($_POST['newpassword']);
                $updatepswdquery = mysqli_query($conn,"UPDATE users SET password = '$newpasswordwncrypted' WHERE username = '$username'");
                if($updatepswdquery){
                    echo "<h2>Your password has been updated successfully</h2>";
                }
                else{
                    echo "<h3 class='error'>Sorry, we encountered some error while updating password. Please try again</h3>";
                }
            }
            else{
                echo "<h3 class='error'> Sorry, your old password doesn't match.</h3>";
            }
        }
    }
}
    else{
        echo "<h3 class='error'>Your two new passwords doesn't match each other, please re-enter";
    }
}
else{
    echo "<h3 class='error'>Please fill all the fields</h3>";
}
}
?>
<?php
//get details of this user
$getdetailsoflogedinuser = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username'");
$chkresultofloggedinuser = mysqli_num_rows($getdetailsoflogedinuser);
if($chkresultofloggedinuser == 1){
    while($row = mysqli_fetch_assoc($getdetailsoflogedinuser)){
        $aboutmeofloggedinuser = $row['aboutme'];
        /*
        
        UPDATE VARIABLES HERE IF NEED SOME OTHER DETAILS OF CURRENTLY LOGGED IN USER
        
        */
    }
}

?>
<h2>Edit your account settings below</h2>
<hr/><br/><br/>
<p><b>Change your password : </b></p>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
Old password : <input type="password" name="oldpassword" id="oldpassword" placeholder="Type old password"/>
New password : <input type="password" name="newpassword" id="newpassword" placeholder="Type new password"/>
Repeat password : <input type="password" name="newpasswordre" id="newpasswordre" placeholder="Repeat new password"/>
<input type="submit" value="change password" name="change_password">
</form>
<br/><br/><hr/><br/><br/>
<?php
    /*
    THIS STATUS IS SAME AS WE SET IN WHATSAPP
    */
?>
<p><b>Status</b></p>
Current Status : <?php echo $aboutmeofloggedinuser;?><br/>
<input type="text" id="about_me" placeholder="Status" style="color:green">
<input type="submit" id="saveaboutme" value="save"><br/>
<input type="text" readonly id="alertaboutme" style="color:red;border:none">
<script>
$(document).ready(function(){
  $("#saveaboutme").click(function(){
     var thisaboutme = $("#about_me").val();
      if(thisaboutme){
      alert(thisaboutme);
      }
      else{
          $("#alertaboutme").val("Please type something");
      }
  });  
$("#about_me").keypress(function(){
    $("#alertaboutme").val("");
});    
});  
</script>
<?php include ( dirname(__FILE__).'/inc/footer.inc.php' ); ?>

</body>
</html>