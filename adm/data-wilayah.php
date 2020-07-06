<?php
	include("include/config.php");     
	switch ($_GET['jenis']) {
		//ambil data kota / kabupaten
		case 'kota':
		$id_provinces = $_POST['id_provinces'];
		if($id_provinces == ''){
		     exit;
		}else{
		     $getcity = mysqli_query($con,"SELECT  * FROM regencies WHERE province_id ='$id_provinces' ORDER BY name_regency ASC") or die ('Query Gagal');
		     while($data = mysqli_fetch_array($getcity)){
		          echo '<option value="'.$data['id'].'">'.$data['name_regency'].'</option>';
		     }
		     exit;    
		}
		break; 

		//ambil data kecamatan
		case 'kecamatan':
		$id_regencies = $_POST['id_regencies'];
		if($id_regencies == ''){
		     exit;
		}else{
		     $getcity = mysqli_query($con,"SELECT  * FROM districts WHERE regency_id ='$id_regencies' ORDER BY name_district ASC") or die ('Query Gagal');
		     while($data = mysqli_fetch_array($getcity)){
		          echo '<option value="'.$data['id'].'">'.$data['name_district'].'</option>';
		     }
		     exit;    
		}
		break;
		

		//ambil data kelurahan
		case 'kelurahan':
		$id_district = $_POST['id_district'];
		if($id_district == ''){
		     exit;
		}else{
		     $getcity = mysqli_query($con,"SELECT  * FROM villages WHERE district_id ='$id_district' ORDER BY name ASC") or die ('Query Gagal');
		     while($data = mysqli_fetch_array($getcity)){
		          echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
		     }
		     exit;    
		}
		break;
		
	}
?>