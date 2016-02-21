<?php include ( dirname(__FILE__).'/inc/header.inc.php' );?>
<?php
if(!isset($_GET['u'])){
    die('<h2>Some error occured</h2>');
}
if(isset($_GET['u'])){
    //$usrname = mysqli_real_escape_string($conn, $_GET['u']);
    $usrname = $_GET['u'];
    //if(ctype_alnum($usrname)){
        //check if user exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='".$usrname."'");
        if(mysqli_num_rows($check) == 1){
            $get = mysqli_fetch_assoc($check);
            $uname = $get['username'];
            $fname = $get['fname'];
            $abouthisuser = $get['aboutme'];
        }
        else{
            echo '<h2>User does not exist</h2>';
            exit();
        }
    //}
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
    $(document).ready(function(){
        //on click of post button
       $("#postbtn").click(function(){
           var posthis = $("#post").val();
           $.ajax({
              type:"get",
               url:"send_post.php",
               data:"post="+posthis,
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
    $getposts = mysqli_query($conn, "SELECT * FROM posts WHERE user_posted_to = '$username' ORDER BY id DESC LIMIT 10") or die(mysqli_error($conn));
    while($row = mysqli_fetch_assoc($getposts)){
        $id = $row['id'];
        $body = $row['body'];
        $date_added = $row['date_added'];
        $added_by = $row['added_by'];
        $user_posted_to = $row['user_posted_to'];
        echo "
            <div class='posted_by'>Posted by :<a href='profile.php?u=".$added_by."'>$added_by</a> on date : $date_added  </div>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <p style='border-bottom:1px solid black;padding:5px'>$body</p>
        ";
    }
    
    ?>
</div>
<img src="" height="250" width="250" alt="<?php echo $uname.'\'s profile'; ?>" title="<?php echo $uname.'\'s profile'; ?>">
<br/>
<div class="textheader" align="center"><?php echo $usrname; ?>'profile</div>
<div class="profileftsidecontent"><?php echo $abouthisuser; ?></div>
<div class="textheader"><?php echo $usrname; ?>'friends</div>
<div class="profileftsidecontent">
    <img src="#" height="50" width="40" />&nbsp;&nbsp;
    <img src="#" height="50" width="40" />&nbsp;&nbsp;
    <img src="#" height="50" width="40" />&nbsp;&nbsp;
    <img src="#" height="50" width="40" />&nbsp;&nbsp;
    <img src="#" height="50" width="40" />&nbsp;&nbsp;
    <img src="#" height="50" width="40" />&nbsp;&nbsp;
    <img src="#" height="50" width="40" />&nbsp;&nbsp;
    <img src="#" height="50" width="40" />&nbsp;&nbsp;
</div>
</section>
<?php include ( dirname(__FILE__).'/inc/footer.inc.php' );?>
</body>
</html>