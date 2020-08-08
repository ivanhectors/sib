<?php 
session_start();
require_once("include/config.php");
if(!empty($_POST["username"])) {
	$username= $_POST["username"];
	$oldusername=$_POST["oldusername"];
		$result =mysqli_query($con,"SELECT username FROM user_admin WHERE username='$username' and username!='".$oldusername."' UNION SELECT username FROM user_acc WHERE username='$username' and username!='".$oldusername."'");
		$count=mysqli_num_rows($result);
if($count>0)
{
echo "<span style='color:red' title='Username Tidak Tersedia'><i class='fas fa-times-circle'></i></span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green' title='Username Tersedia'><i class='fas fa-check-circle'></i></span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}


?>
