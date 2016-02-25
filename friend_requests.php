<?php include ( dirname(__FILE__).'/inc/header.inc.php' );?>
<br/><br/><br/><br/>
<?php
// FIND FRIEND REQUESTS
$findfriendrequestquery = mysqli_query($conn, "SELECT * FROM friend_requests WHERE user_to = '$username'");
$countfrndrequests = mysqli_num_rows($findfriendrequestquery);
if($countfrndrequests == 0){
    echo 'you have no friend requests yet';
    $requestfrom ="";
}
else{
    //  PRINT ALL FRIEND REQUESTS
    while($getrequests = mysqli_fetch_assoc($findfriendrequestquery)){
        $id =     $getrequests['id'];
        $request_to = $getrequests['user_to'];
        $requestfrom = $getrequests['user_from'];
        
        echo "$requestfrom wants to be friends with you .";

?>
<?php
if(isset($_POST['acceptrequest'.$requestfrom])){
    //get friend array for logged in user
    $getfriendschk = mysqli_query($conn,"SELECT friend_array FROM users WHERE username='$username'");
    $getfriendsrow = mysqli_fetch_assoc($getfriendschk);
    $friend_array = $getfriendsrow['friend_array'];
    $friendarrayexplode = explode(",",$friend_array);
    $friendarraycount = count($friendarrayexplode);

    //get friend array for person who sent request
    $get_friend_check_friend = mysqli_query($conn,"SELECT friend_array FROM users WHERE username='$requestfrom'");
    $req_from_frnd_row = mysqli_fetch_assoc($get_friend_check_friend);
    $req_from_frnd_array = $req_from_frnd_row['friend_array'];
    $req_from_frnd_explode = explode(",",$req_from_frnd_array);
    $req_from_frnd_count = count($req_from_frnd_explode);

if($friend_array == ""){
    $friendarraycount = count(NULL);
}

    
if($req_from_frnd_array == ""){
    $req_from_frnd_count = count(NULL);
}
    


if($friendarraycount == NULL){
    $query_to_add_friend = mysqli_query($conn, "UPDATE users SET friend_array=CONCAT(friend_array,'$requestfrom') WHERE username='$username'");
}    
if($req_from_frnd_count == NULL){
    $query_to_add_friend = mysqli_query($conn, "UPDATE users SET friend_array=CONCAT(friend_array,'$request_to') WHERE username='$requestfrom'");
}    
if($friendarraycount >= 1)    {
    $query_to_add_friend = mysqli_query($conn, "UPDATE users SET friend_array=CONCAT(friend_array,',$requestfrom') WHERE username='$username'");
}
if($req_from_frnd_count >= 1){
    $query_to_add_friend = mysqli_query($conn, "UPDATE users SET friend_array=CONCAT(friend_array,',$request_to') WHERE username='$requestfrom'");
}    


    // DELETE ENTRY OF FRIEND REQUEST FROM THE DATABASE
$delete_req_from_data = mysqli_query($conn, "DELETE FROM friend_requests WHERE user_to='$request_to' AND user_from='$requestfrom'");    
    echo "<h1>You are now friends .</h1>";
    header('location:friend_requests.php');
}

    // IF REQUEST IS IGNORED
        if (isset($_POST['ignorerequest'.$requestfrom])) {
$ignore_request = mysqli_query($conn,"DELETE FROM friend_requests WHERE user_to='$request_to' AND user_from='$requestfrom'");
  echo "<h1>Request Ignored!</h1>";
  header("Location: friend_requests.php");
}

     ?>
<form action="friend_requests.php" method="POST">
<input type="submit" name="acceptrequest<?php echo $requestfrom; ?>" value="Accept Request">
<input type="submit" name="ignorerequest<?php echo $requestfrom; ?>" value="Ignore Request">
</form>
<?php
}
}

?>