

$( document ).ready(function() {
	//untuk memanggil plugin select2
    $('#fakultasedits').select2({
		  placeholder: 'Pilih Fakultas',
	  	language: "id"
	});
	$('#dosen_wali').select2({
	  	placeholder: 'Pilih Dosen Wali Mahasiswa',
	  	language: "id"
	});
	$('#kecamatan').select2({
	  	placeholder: 'Pilih Kecamatan',
	  	language: "id"
	});
	$('#kelurahan').select2({
	  	placeholder: 'Pilih Kelurahan',
	  	language: "id"
	});

	//saat pilihan provinsi di pilih maka mengambil data di data-wilayah menggunakan ajax
	$("#fakultas").change(function(){
	      $("img#load1").show();
	      var kd_fakultas = $(this).val(); 
	      $.ajax({
	         type: "POST",
	         dataType: "html",
	         url: "data-wilayah.php?jenis=fakultas",
	         data: "kd_fakultas="+kd_fakultas,
	         success: function(msg){
	            $("select#prodi").html(msg);                                                       
	            $("img#load1").hide();
	            getAjaxKota();                                                        
	         }
	      });                    
	 });  
	 
	 $("#fakultasedit").change(function(){
		$("img#load1").show();
		var kd_fakultas = $(this).val(); 
		$.ajax({
		   type: "POST",
		   dataType: "html",
		   url: "data-wilayah.php?jenis=fakultasedit",
		   data: "kd_fakultas="+kd_fakultas,
		   success: function(msg){
			  $("select#prodiedit").html(msg);                                                       
			  $("img#load2").hide();
			  getAjaxKota();                                                        
		   }
		});                    
   });


   $("#fakultasedit").change(function(){
	$("img#load1").show();
	var kd_fakultas = $(this).val(); 
	$.ajax({
	   type: "POST",
	   dataType: "html",
	   url: "data-wilayah.php?jenis=fakultasedit2",
	   data: "kd_fakultas="+kd_fakultas,
	   success: function(msg){
		  $("select#dosen_wali").html(msg);                                                       
		  $("img#load2").hide();
		  getAjaxKota();                                                        
	   }
	});    
}); 
	
	
	var kd_fakultas = document.getElementById("fakultasedit").value; 
	$.ajax({
	   type: "POST",
	   dataType: "html",
	   url: "data-wilayah.php?jenis=fakultasedit2",
	   data: "kd_fakultas="+kd_fakultas,
	   success: function(msg){
		  $("select#dosen_wali").html(msg);                                                       
		  $("img#load2").hide();
		  getAjaxKota();                                                        
	   }
	});


});