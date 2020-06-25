<?php
session_start();
include("include/config.php");
$_SESSION['admlogin']=="";
date_default_timezone_set('Asia/Jakarta');
$ldate=date( 'd-m-Y h:i:s A', time () );
mysqli_query($con,"UPDATE userlog  SET logout = '$ldate' WHERE username = '".$_SESSION['admlogin']."' ORDER BY iduserlog DESC LIMIT 1");
session_unset();
//session_destroy();
$_SESSION['errmsg']=" You have successfully logout";
?>
<script language="javascript">
document.location="../login";
</script>