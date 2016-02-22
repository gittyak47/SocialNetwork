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
<?php
//Check whether the user has uploaded a profile pic or not
  $check_pic = mysqli_query($conn,"SELECT profile_pic FROM users WHERE username='$username'");
  $get_pic_row = mysqli_fetch_assoc($check_pic);
  $profile_pic_db = $get_pic_row['profile_pic'];
  if ($profile_pic_db == "") {
  $profile_pic = "img/default-profile-pic.jpg";
  }
  else
  {
  $profile_pic = "userdata/profilepics/".$profile_pic_db;
  }

//UPLOAD PROFILE PICTURE
if (isset($_FILES['profilepic'])) {
    if(isset($_FILES["profilepic"])){
   if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)) //1 Megabyte
  {
   $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $rand_dir_name = substr(str_shuffle($chars), 0, 15);
   mkdir("userdata/profilepics/$rand_dir_name");

   if (file_exists("userdata/profilepics/$rand_dir_name/".@$_FILES["profilepic"]["name"]))
   {
    echo @$_FILES["profilepic"]["name"]." Already exists";
   }
   else
   {
    //move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/profilepics/$rand_dir_name/".$_FILES["profilepic"]["name"]);
       move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/profilepics/$rand_dir_name/".$username.'.jpg');
    //echo "Uploaded and stored in: userdata/profilepics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
    //$profile_pic_name = @$_FILES["profilepic"]["name"];
    $profile_pic_query = mysqli_query($conn,"UPDATE users SET profile_pic='$rand_dir_name/$username.jpg' WHERE username='$username'");
    header("Location: account_settings.php");
    
   }
  }
  else
  {
      echo "<h3 class='error'>Invailid File! Your image must be no larger than 1MB and it must be either a .jpg, .jpeg, .png or .gif</h3>";
  }
    }
    else{
        echo "<h3 class='error'>please select an image. </h3>";
    }
  }

?>
<p><b>Change your profile picture</b></p>
<form action="" method="POST" enctype="multipart/form-data">
<img src="<?php echo $profile_pic; ?>" width="100" />
<input type="file" name="profilepic" accept="image/jpeg,image/png,image/jpg" />
<input type="submit" name="uploadpic" value="Upload Image">
</form>


<?php include ( dirname(__FILE__).'/inc/footer.inc.php' ); ?>

