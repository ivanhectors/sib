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
 

	switch ($_GET['jenis']) {
		//ambil data kota / kabupaten
		case 'fakultas':
		$id_fakultas = $_POST['id_fakultas'];
		if($id_fakultas == ''){
		     exit;
		}else{
		     $getcity = mysqli_query($con,"SELECT  * FROM ref_prodi WHERE id_fakultas ='$id_fakultas' ORDER BY id_prodi ASC") or die ('Query Gagal');
		     while($data = mysqli_fetch_array($getcity)){
		          echo '<option value="'.$data['id_prodi'].'">Program Studi '.$data['nama_prodi'].'</option>';
		     }
		     exit;    
		}
		break; 
		
	}

	switch ($_GET['jenis']) {
		//ambil data kota / kabupaten
		case 'fakultasedit':
		$id_fakultas = $_POST['id_fakultas'];
		if($id_fakultas == ''){
		     exit;
		}else{
		     $getcity = mysqli_query($con,"SELECT  * FROM ref_prodi WHERE id_fakultas ='$id_fakultas' ORDER BY id_prodi ASC") or die ('Query Gagal');
		     while($data = mysqli_fetch_array($getcity)){
		          echo '<option value="'.$data['id_prodi'].'">Program Studi '.$data['nama_prodi'].'</option>';
		     }
		     exit;    
		}
		break; 
		
	}

	switch ($_GET['jenis']) {
		//ambil data kota / kabupaten
		case 'fakultasedit2':
		$id_fakultas = $_POST['id_fakultas'];
		if($id_fakultas == ''){
		     exit;
		}else{
			echo '<option value="selected">Pilih Wali Studi Mahasiswa</option>';
		     $getacc = mysqli_query($con,"SELECT  * FROM user_acc WHERE id_fakultas ='$id_fakultas' ORDER BY nama_acc ASC") or die ('Query Gagal');
		     while($data_acc = mysqli_fetch_array($getacc)){
				  
		          echo '<option value="'.$data_acc['id_acc'].'">'.$data_acc['nama_acc'].'</option>';
		     }
		     exit;    
		}
		break; 
		
	}
?>