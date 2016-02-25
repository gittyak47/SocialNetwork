<?php include ( dirname(__FILE__).'/inc/header.inc.php' );?>
<br/><br/><br/>
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
            
            //check if user is not sending messages to himself
            if($usrname != $username){
                if(isset($_POST['send_msg_btn'])){
                    $msg_title = strip_tags(@$_POST['msg_title']);
                    $msg_body = strip_tags(@$_POST['msg_body']);
                    $date = date("Y-m-d");
                    $opened = "no";
                    $deleted = "no";
                    if (strlen($msg_title) < 3 || strlen($msg_body) < 3) {
                        echo "Your input cannot be less than 3 characters in length!";
                        $a = $_POST['msg_title'];
                        $b = $_POST['msg_body'];
                        }
                    else{
                        $send_msg_now = mysqli_query($conn, "INSERT INTO pvt_messages VALUES ('','$username','$usrname','$msg_title','$msg_body','$date','$opened','$deleted')");
                        if(!$send_msg_now){
                            echo 'something went wrong';
                        }
                        echo "Your message has been sent!";
                        $a ="";
                        $b ="";
                    }
                    
                }else{
                    $a ="";
                    $b ="";
                }
                echo "
                    <form action='send_msg.php?u=$usrname' method='post' style='margin-left:40px'>
                    <h2>Send message to $usrname</h2>
                    <input name='msg_title' type='text' placeholder='enter msg title here' value='".$a."'/><br/><br/>
                    <textarea cols='40' rows='10' name='msg_body' placeholder='Type your message here...'>".$b."</textarea>
                    <input type='submit' name='send_msg_btn' value='Send message '>
                    </form>
                ";
            }else{
                header("location:$username");
            }
        }
    }
}


?>