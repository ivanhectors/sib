<?php

use Dompdf\Autoloader;

session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../403');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    $kd_daftar = $_GET['kd_daftar'];
    $content = '
	<html> 
	<body>
		<h1>MPDF WORK !'. $kd_daftar .'</h1> 
		Selamat datang di rachmat.ID'. $_GET['kd_daftar'] .'
	</body>
	</html>
	';

	require_once "js/mpdf/vendor/autoload.php";
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->setFooter('Hal {PAGENO} || Sistem Informasi Beasiswa UKDW');
	$mpdf->AddPage("P","","","","","15","15","15","15","","","","","","","","","","","","A4");
	$mpdf->WriteHTML($content);
	$mpdf->Output();
    



}

?>