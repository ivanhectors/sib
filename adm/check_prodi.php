<?php 
session_start();
require_once("include/config.php");
if(!empty($_POST["id_prodi"])) {
	$id_prodi= $_POST["id_prodi"];
	
		
        $sql = "select * from ref_prodi where id_prodi=?";
            $stmt = $con->prepare($sql); 
            $stmt->bind_param("i", $id_prodi);
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

if(!empty($_POST["id_prodi2"])) {
	$id_prodi= $_POST["id_prodi2"];
	
		
        $sql = "select * from ref_prodi where id_prodi=?";
            $stmt = $con->prepare($sql); 
            $stmt->bind_param("i", $id_prodi);
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
