<?php include ( dirname(__FILE__).'/inc/header.inc.php' );?>
<?php
if(!isset($_GET['u'])){
    die('<h2>Some error occured</h2>');
}
if(isset($_GET['u'])){
    //$usrname = mysqli_real_escape_string($conn, $_GET['u']);
    $usrname = $_GET['u'];
    if(ctype_alnum($usrname)){
        //check if user exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='".$usrname."'");
        if(mysqli_num_rows($check) == 1){
            $get = mysqli_fetch_assoc($check);
            $uname = $get['username'];
            $fname = $get['fname'];
            $abouthisuser = $get['aboutme'];
            $profilepicofthisuser = $get['profile_pic'];
        }
        else{
            echo '<h2>User does not exist</h2>';
            exit();
        }
    }
}
?>
<style>
    section{
        margin-left: 16%;
    }    
</style>
<section>
<h2>Profile page for <?php echo $uname; ?></h2>
<h2>First Name : <?php echo $fname; ?></h2>
<div class="postform">
    <p id="postfail"></p>
    <textarea id="post" name="post" rows="4" cols="54"></textarea>
        <input type="submit" id="postbtn" name="send" value="Post" style="background-color:#DCE5EE;float:right;border:1px solid #666;">
    
    <script>
        /*
        #############################################################
        SCRIPT FOR POST SOMETHING ON YOUR TIMELINE
        
        #############################################################
        */
    $(document).ready(function(){
        //on click of post button
       $("#postbtn").click(function(){
           var posthis = $("#post").val();
           $.ajax({
              type:"get",
               url:"send_post.php",
               data:"post="+posthis+"&addedby=<?php echo $usrname;?>&userpostedto=<?php echo $username;?>",
               success:function(result){
                   if(result){
                       $("#postfail").html(result);
                       $('#post').val('');
                   }
                   else{
                       $("#postfail").html("error");
                   }
               }
           });
       }); 
    });
    </script>
</div>
<div class="profilepost">
    <?php
    /*
    #############################################################
    THIS SCRIPT PRINTS 10 RECENT POSTS DONE FOR YOU
    #############################################################
    */
    
    $getposts = mysqli_query($conn, "SELECT * FROM posts WHERE user_posted_to = '$username' ORDER BY id DESC LIMIT 10") or
        die(mysqli_error($conn));
    while($row = mysqli_fetch_assoc($getposts)){
        $id = $row['id'];
        $body = $row['body'];
        $date_added = $row['date_added'];
        $added_by = $row['added_by'];
        $user_posted_to = $row['user_posted_to'];
        echo "
            <div class='posted_by'>Posted by :<a href='$added_by'>$added_by</a> on date : $date_added  </div>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <p style='border-bottom:1px solid black;padding:5px'>$body</p>
        ";
    }
    /*
    #############################################################
        ENDS HERE
    #############################################################
    */
    ?>
</div>
<img src="<?php echo 'userdata/profilepics/'.$profilepicofthisuser;?>" height="250" width="250" alt="<?php echo $uname.'\'s profile'; ?>"
     title="<?php echo $uname.'\'s profile'; ?>">
<br/>
    
<div class="textheader" align="center"><?php echo $usrname; ?>'profile</div>
<form action="<?php echo $usrname; ?>" method="post">

    <?php
    
    // ADD FRIEND BUTTON IF YOU ARE IN FRIEND LIST ELSE REMOVE FRIEND BUTTON
$friendsArray = "";
$countFriends = "";
$friendsArray12 = "";
$addAsFriend = "";
$selectFriendsQuery = mysqli_query($conn,"SELECT friend_array FROM users WHERE username='$usrname'");
$friendRow = mysqli_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];
if ($friendArray != "") {
   $friendArray = explode(",",$friendArray);
   $countFriends = count($friendArray);
   $friendArray12 = array_slice($friendArray, 0);

$i = 0;
if (in_array($username,$friendArray)) {
 $addAsFriend = '<input type="submit" name="removefriend" value="UnFriend">';
}
else
{
 $addAsFriend = '<input type="submit" name="addfriend" value="Add Friend">';
}
echo $addAsFriend;
}
else
{
 $addAsFriend = '<input type="submit" name="addfriend" value="Add Friend">';
 echo $addAsFriend;
}
/*
#############################################################
REMOVE SOMEONE FROM YOUR FRIEND LIST 
SCRIPT STARTS HERE
THIS IS A CONDITIONAL STATEMENT ON CLICK UNFRIEND BUTTON
USING POST METHOD
#############################################################
*/
    // REMOVE FRIEND SCRIPT
    // $usrname = WHOSE PROFILE IS BEING VISITED
    // $username = WHO IS LOGGED IN 
    if (@$_POST['removefriend']) {
  //Friend array for logged in user
  $add_friend_check = mysqli_query($conn, "SELECT friend_array FROM users WHERE username='$username'");
  $get_friend_row = mysqli_fetch_assoc($add_friend_check);
  $friend_array = $get_friend_row['friend_array'];
  $friend_array_explode = explode(",",$friend_array);
  $friend_array_count = count($friend_array_explode);
  
  //Friend array for user who owns profile
  $add_friend_check_username = mysqli_query($conn,"SELECT friend_array FROM users WHERE username='$usrname'");
  $get_friend_row_username = mysqli_fetch_assoc($add_friend_check_username);
  $friend_array_username = $get_friend_row_username['friend_array'];
  $friend_array_explode_username = explode(",",$friend_array_username);
  $friend_array_count_username = count($friend_array_explode_username);
  
  $usernameComma = ",".$username;
  $usernameComma2 = $username.",";
  
  $userComma = ",".$user;
  $userComma2 = $user.",";
  
  if (strstr($friend_array,$usernameComma)) {
   $friend1 = str_replace("$usernameComma","",$friend_array);
  }
  else
  if (strstr($friend_array,$usernameComma2)) {
   $friend1 = str_replace("$usernameComma2","",$friend_array);
  }
  else
  if (strstr($friend_array,$username)) {
   $friend1 = str_replace("$username","",$friend_array);
  }
  //Remove logged in user from other persons array
  if (strstr($friend_array,$userComma)) {
   $friend2 = str_replace("$userComma","",$friend_array);
  }
  else
  if (strstr($friend_array,$userComma2)) {
   $friend2 = str_replace("$userComma2","",$friend_array);
  }
  else
  if (strstr($friend_array,$user)) {
   $friend2 = str_replace("$user","",$friend_array);
  }

  $friend2 = "";

  $removeFriendQuery = mysqli_query($conn,"UPDATE users SET friend_array='$friend1' WHERE username='$username'");
  $removeFriendQuery_username = mysqli_query($conn,"UPDATE users SET friend_array='$friend2' WHERE username='$usrname'");
  echo "Friend Removed ...";
  header("Location: $usrname");
}
    
    /*
    #############################################################
    REMOVE SOMEONE FROM YOUR FRIEND LIST 
    SCRIPT ENDS HERE
    #############################################################
    */
//////////////////////////////////
    ?>
<input type="submit" name="sendmsg" value="Send Msg" />
</form>
<?php
    
    if(isset($_POST['sendmsg'])){
        header("location:send_msg.php?u=$usrname");
    }
// SCRIPT TO SEND FRIEND REQUESTS    
    /*
    #############################################################
    SCRIPT TO SEND FRIEND REQUEST STARTS FROM HERE
    THIS IS A CONDITIONAL SCRIPT AND EXECUTES WHEN THE USER CLICKS
    ON AD AS FRIEND BUTTON 
    VALUE IS PASSED USING POST METHOD
    #############################################################
    */
    if(isset($_POST['addfriend'])){
        $friend_request = $_POST['addfriend'];
        $userTo = $usrname;
        $userFrom = $username;
        if($userTo == $userFrom){
            echo "<h3 class='error'>You can't send request to yourself</h3>";
        }
        else{
            $create_request = mysqli_query($conn, "INSERT INTO friend_requests VALUES('','$userFrom','$userTo')");
            
            if($create_request){
                echo "Your request has been sent successfully.";
            }
        }
    }
    else{
        // DO NOTHING
    }
    /*
    #############################################################
    SEND FRIEND REQUEST SCRIPTS ENDS HERE
    #############################################################
    */
?>
<div class="profileftsidecontent"><?php echo $abouthisuser; ?></div
<div class="textheader"><?php echo $usrname; ?>'friends</div>
<div class="profileftsidecontent">
    <?php
    //PRINT LIST OF FRIENDS
    /*
    THE BELOW QUERY GETS NAME OF FRIENDS FROM THE DATABASE 
    SPLIT THEM INTO ARRAY ELEMENTS
    AND GET PROFILE IMAGE OF THE RESPECTIVE USER
    
    THIS SCRIPT EXECUTES AT THE TIME PAGE LOADS
    
    */
    if ($countFriends != 0) {
foreach ($friendArray12 as $key => $value) {
 $i++;
 $getFriendQuery = mysqli_query($conn,"SELECT * FROM users WHERE username='$value' LIMIT 1");
 $getFriendRow = mysqli_fetch_assoc($getFriendQuery);
 $friendUsername = $getFriendRow['username'];
 $friendProfilePic = $getFriendRow['profile_pic'];

 if ($friendProfilePic == "") {
  echo "<a href='$friendUsername'><img src='img/default-profile-pic.jpg' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\"
  height='50' width='40' style='padding-right: 6px;'></a>";
 }
 else
 {
  echo "<a href='$friendUsername'><img src='userdata/profilepics/$friendProfilePic' alt=\"$friendUsername's Profile\" title=\"$friendUsername's
  Profile\" height='50' width='40' style='padding-left: 6px;'></a>";
 }
}
}
else
echo $username." has no friends yet.";

    /*
    #############################################################
    PRINTING LIST OF FRIENDS SCRIPT FINISHES HERE
    #############################################################
    */
    ?>
    
    
</div>
</section>
<?php include ( dirname(__FILE__).'/inc/footer.inc.php' );?>