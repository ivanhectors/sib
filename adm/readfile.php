<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../403');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Sistem Informasi Beasiswa Kebutuhan dan Pinjaman Registrasi">
	<meta name="author" content="UKDW">
	<title>SIB - Sistem Informasi Beasiswa Kebutuhan dan Pinjaman Registrasi</title>
	<!-- Favicon -->
	<link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">
	<!--
	This example created for PDFObject.com by Philip Hutchison (www.pipwerks.com)
	Copyright 2016-2018, MIT-style license http://pipwerks.mit-license.org/
	Documentation available at http://pdfobject.com
	Source code available at https://github.com/pipwerks/PDFObject
	-->

	<style>
		@charset "UTF-8";

		* {
			box-sizing: border-box;
		}

		body {
			font: 16px sans-serif;
			color: #454545;
			/*background: rgb(218,244,249);*/
			background: #fff;
			margin: 0;
			padding: 3rem 2rem 2rem 2rem;
		}

		h1 {
			font-weight: normal;
			font-size: 1.4rem;
			color: #555;
		}

		.pdfobject-com {
			position: absolute;
			top: 0;
			left: 0;
			z-index: 2016;
		}

		.pdfobject-com a:link,
		.pdfobject-com a:visited {
			color: #fff;
			font-weight: bold;
			display: block;
			padding: .25rem 1rem;
			background: #6699FF;
			text-decoration: none;
		}

		.pdfobject-com a:hover,
		.pdfobject-com a:visited:hover {
			color: #FFF;
			background: #FF3366;
			text-decoration: none;
		}

		.pdfobject-com a:before {
			content: "\2190";
			margin-right: .25rem;
		}
	</style>
</head>

<body>
	<div class="pdfobject-com"></div>
	<script src="js/pdfobject.min.js"></script>
	<script>
		PDFObject.embed("../mhs/file/<?php echo $_GET["file"] ?>");
	</script>
</body>
</html>
<?php } ?>