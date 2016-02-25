<?php include ( dirname(__FILE__).'/inc/header.inc.php' );?>
<?php
        if($username){
            header('location:home.php');
        }
        ?>
<?php
$reg= @$_POST['register'];
//declaring variable to prevent error
$fn = "";//First Name
$ln = "";//Last Name
$un = "";//UserName
$em = "";//Email
$em2 = "";//Re-enter Email
$pswd = "";//Password
$pswd2 = "";//Re-enter Password
$d ="";//Sign up Date
$u_chk = "";//Check if username already exists
//registration form
$fn = strip_tags(@$_POST['fname']);
$ln = strip_tags(@$_POST['lname']);
$un = strip_tags(@$_POST['username']);
$em = strip_tags(@$_POST['email']);
$em2 = strip_tags(@$_POST['email_re']);
$pswd = strip_tags(@$_POST['password']);
$pswd2 = strip_tags(@$_POST['password_re']);
$d = date("y-m-d");//Year-Month_date
//echo $fn.'<br/>'.$ln.'<br/>'.$un.'<br/>'.$em.'<br/>'.$em2.'<br/>'.$pswd.'<br/>'.$pswd2;
if($reg){
    if($em == $em2){
        //check if username already exists
        $u_chk = mysqli_query($conn, "select username from users where username = '".$un."'");
        //count the amount of rows where username  =  $un
        $chk = mysqli_num_rows($u_chk);
        //check if email already exists
        $em_chk = mysqli_query($conn, "select email from users where email = '".$em."'");
        $em_chk_result = mysqli_num_rows($em_chk);
        if($chk == 0 && $em_chk_result == 0){
            //check all fields have been filled
            if($fn && $ln && $un && $em && $em2 && $pswd && $pswd2){
                //check that password match
                if($pswd == $pswd2){
                    //check maximum length of username || first name || last name
                    if(strlen($un) > 25 || strlen($fn) > 25 || strlen($ln) > 25){
                        echo '<h3 class="error">Maximum limit for username, First name, Last name is 25 characters.</h3>';
                    }
                    else{
                        //check max length of password is 25 and minimum is 5 
                            if(strlen($pswd) > 30 || strlen($pswd) < 5){
                                echo '<h3 class="error">Your password length must be between 5 to 30 characters</h3>';
                            }
                        else{
                            //encrypt password using md5 encryption method
                            $pswd = md5($pswd);
                            $sql = " INSERT INTO `users`(`username`, `fname`, `lname`, `email`, `password`, `sign_up_date`, `activated`) VALUES ('".$un."','".$fn."','".$ln."','".$em."','".$pswd."','".$d."','0')";
                            if($conn->query($sql)){
                            die("<h2>Welcome to SocialNetwork</h2>, Login to get Started...");
                            }
                            else{
                                echo '<h3 class="error">Sorry some error occured, please try again</h3>';
                            }
                        }
                    }
                }
                else{
                    echo '<h3 class="error">Your password does not match !</h3>';
                }
            }
            else{
                echo '<h3 class="error">Please fill in all the fields</h3>';
            }
        }
        else{
            echo '<h3 class="error">Username or email already exists<h3>';
        }
    }
    else{
        echo '<h3 class="error">Your email id does not match</h3>';
    }
}

// user login script
if(isset($_POST['user_login']) && isset($_POST['password_login'])){
   // $user_in = preg_replace('#[^A-Za-z0-9]#i','',$_POST['user_login']);
    //$password_in = preg_replace('#[^A-Za-z0-9]#i','',$_POST['password_login']);
    //first convert passwrd to md5
    $user_in = $_POST['user_login'];
    $password_in = $_POST['password_login'];
    $password_in_md = md5($password_in);
    //query to check from sql table
    $loginsql = mysqli_query($conn,"SELECT id FROM users WHERE username = '".$user_in."' AND password = '".$password_in_md."' LIMIT 1");
    //count the number of rows returned
    $userCount = mysqli_num_rows($loginsql);
    if($userCount == 1){
        while($row = mysqli_fetch_array($loginsql)){
            $id = $row['id'];
        }
        $_SESSION['user'] = $user_in;
        header('Location:home.php');
        exit();
    }
    else{
        echo 'The information you provided is incorrect. Please try again';
        exit();
    }
}
?>
        <table width="100%">
            <tr>
                <td width="60%" valign="top">
                    <h2>Already a member ? Sign in below |</h2>
                    <form method="post">
                        <input type="text" name="user_login" size="35" placeholder="Username"><br/><br/>
                        <input type="password" name="password_login" size="35" placeholder="Password"><br/><br/>
                        <input type="submit" name="signin" value="Sign in">
                    </form>
                </td>
                <td width="40%" valign="top">
                    <h2>Sign up for more...</h2>
                    <form action="" method="post" >
                        <input type="text" name="fname" size="35" placeholder="First Name"><br/><br/>
                        <input type="text" name="lname" size="35" placeholder="Last Name"><br/><br/>
                        <input type="text" name="username" size="35" placeholder="Username"><br/><br/>
                        <input type="text" name="email" size="35" placeholder="email"><br/><br/>
                        <input type="text" name="email_re" size="35" placeholder="re-enter email"><br/><br/>
                        <input type="password" name="password" size="35" placeholder="password"><br/><br/>
                        <input type="password" name="password_re" size="35" placeholder="repeat password"><br/><br/>
                        <input type="submit" name="register" value="Sign Up">
                    </form>
                </td>
            </tr>
        </table>
<?php include ( dirname(__FILE__).'/inc/footer.inc.php' );?>