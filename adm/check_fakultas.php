<?php 
session_start();
require_once("include/config.php");
if(!empty($_POST["id_fakultas"])) {
	$id_fakultas= $_POST["id_fakultas"];
	
		
        $sql = "select * from ref_fakultas where id_fakultas=?";
            $stmt = $con->prepare($sql); 
            $stmt->bind_param("i", $id_fakultas);
            $stmt->execute();
            $result = $stmt->get_result();
            $count=mysqli_num_rows($result);
if($count>0)
{
echo "<span style='color:red' title='Kode Fakultas Tersebut Sudah Ada.'><i class='fas fa-times-circle'></i></span>";
 echo "<script>$('#tambah').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green' title='Kode Fakultas Tersedia.'><i class='fas fa-check-circle'></i></span>";
 echo "<script>$('#tambah').prop('disabled',false);</script>";
}
}

if(!empty($_POST["id_fakultas2"])) {
	$id_fakultas= $_POST["id_fakultas2"];
	
		
        $sql = "select * from ref_fakultas where id_fakultas=?";
            $stmt = $con->prepare($sql); 
            $stmt->bind_param("i", $id_fakultas);
            $stmt->execute();
            $result = $stmt->get_result();
            $count=mysqli_num_rows($result);
if($count>0)
{
echo "<span style='color:red' title='Kode Fakultas Tersebut Sudah Ada.'><i class='fas fa-times-circle'></i></span>";
 echo "<script>$('#edit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green' title='Kode Fakultas Tersedia.'><i class='fas fa-check-circle'></i></span>";
 echo "<script>$('#edit').prop('disabled',false);</script>";
}
}


?>
