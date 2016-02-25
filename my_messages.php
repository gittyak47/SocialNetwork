<?php include ( dirname(__FILE__).'/inc/header.inc.php' );?>
<h2>My Unread Messages:</h2><p />
<?php
//take Unread messages from database for logged in user
$grab_unread_messages = mysqli_query($conn,"SELECT * FROM pvt_messages WHERE user_to='$username' AND opened='no' AND deleted='no'");
$count_rows = mysqli_num_rows($grab_unread_messages);
if($count_rows != 0){
    while ($get_msg = mysqli_fetch_assoc($grab_unread_messages)) {
        $id = $get_msg['id']; 
      $user_from = $get_msg['user_from'];
      $user_to = $get_msg['user_to'];
      $msg_title = $get_msg['msg_title'];
      $msg_body = $get_msg['msg_body'];
      $date = $get_msg['date'];
      $opened = $get_msg['opened'];
      $deleted = $get_msg['deleted'];
        echo "<a href='$user_from'>$user_from</a><b><span class='titleMessage'>$msg_title</span></b><p>$msg_body</p><br/>";

    }
}else{
    print("<h3 class='error'>You don't have any Unread msg yet");
}
?>
<hr/>
<h2>My Read Messages:</h2><br />
<?php
//take Read messages from database for logged in user
$grab_unread_messages = mysqli_query($conn,"SELECT * FROM pvt_messages WHERE user_to='$username' AND opened='yes' AND deleted='no'");
$count_rows = mysqli_num_rows($grab_unread_messages);
if($count_rows != 0){
    while ($get_msg = mysqli_fetch_assoc($grab_unread_messages)) {
        $id = $get_msg['id']; 
      $user_from = $get_msg['user_from'];
      $user_to = $get_msg['user_to'];
      $msg_title = $get_msg['msg_title'];
      $msg_body = $get_msg['msg_body'];
      $date = $get_msg['date'];
      $opened = $get_msg['opened'];
      $deleted = $get_msg['deleted'];
        echo "<div><a href='$user_from'>$user_from</a><b><p class='this'>$msg_title</p></b><p class='that'>$msg_body</p></div><br/>";

    }
}
?>
<script>

    $(document).ready(function(){
    $(".this").click(function(){
    $(this).next().show();

});
$(".that").hide();
});
</script>
<!--
THE ABOVE SCRIPT IS NOT WORKING FOR ABOVE ELEMENTS ( msg_body and msg_title)
IT WILL BE REVIEWED LATER

--->
<div>div (parent)
<p class="this">hahaha</p>
<p class="that">nanana</p>
</div>
<div>div (parent)
<p class="this">hahaha</p>
<p class="that">nanana</p>
</div>