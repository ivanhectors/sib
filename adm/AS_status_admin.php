<?php
include("include/config.php");

foreach($_POST as $fld=>$val) {$$fld=$val;}
$sql="update user_admin set status='$chk' where id_admin='$who' limit 1";
    // $link=mysqli_connect("localhost", "user", "pw", "db") or die("Could not connect : " . mysqli_error($link));
    if(mysqli_query($con, $sql)) {echo "OK";} // everything is Ok, the data was inserted
    else {echo "error";} // error happened
mysqli_close($con);
?>