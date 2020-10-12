<?php 
session_start();
require_once("include/config.php");
if(!empty($_POST["username"])) {
	$username= $_POST["username"];
	
		$result =mysqli_query($con,"SELECT username FROM user_admin WHERE username='$username' and username!='".$_SESSION['admlogin']."' UNION SELECT username FROM user_acc WHERE username='$username' and username!='".$_SESSION['admlogin']."'");
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


if(!empty($_POST["nimmhs"])) {
	$nimmhs = $_POST["nimmhs"];
	$nimmhsnow = $_POST["oldnim"];
	
		$result =mysqli_query($con,"SELECT nim FROM user_mhs WHERE nim='$nimmhs' and nim!='$nimmhsnow'");
		$count=mysqli_num_rows($result);
if($count>0)

{
echo "<span style='color:red' title='NIM Tidak Tersedia'><i class='fas fa-times-circle'></i></span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green' title='NIM Tersedia'><i class='fas fa-check-circle'></i></span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}

if(!empty($_POST["tambahnimbaru"])) {
	$tambahnimbaru = $_POST["tambahnimbaru"];
		$result =mysqli_query($con,"SELECT nim FROM user_mhs WHERE nim='$tambahnimbaru'");
		$count=mysqli_num_rows($result);
if($count>0)

{
echo "<span style='color:red' title='NIM Tidak Tersedia'><i class='fas fa-times-circle'></i></span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green' title='NIM Tersedia'><i class='fas fa-check-circle'></i></span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}


?>
