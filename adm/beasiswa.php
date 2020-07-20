<?php
session_start();

include("include/config.php");
 
if(strlen($_SESSION['admlogin'])==0)
  { 
    header('location:../login');
}
else{
date_default_timezone_set('Asia/Jakarta');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
// include("include/header.php");
// include("include/sidebar.php");


if(isset($_POST['submit']))
{
    //update info pribadi
    $password = $_POST["password_default"];
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);
    $username = $_POST["username"];
    $email=$_POST['email'];
    $status=1;
    $role=1;


    //tambah acc
    $sql=mysqli_query($con,"INSERT INTO user_acc (username, password, email, status, kd_role) VALUES ('$username', '$passwordhash', '$email', '$status', '$role')");
    $_SESSION['msg']="1";
}else{
    $_SESSION['msg']="0";
}

if(isset($_GET['del']))
		  {
              mysqli_query($con,"delete from user_acc where id_acc = '".$_GET['id']."'");
        $_SESSION['delmsg']="1";
		  }else{
        $_SESSION['delmsg']="0";
      }

if(isset($_GET['on']))
		  {
              mysqli_query($con,"update user_acc set status='1' where id_acc = '".$_GET['id']."'");
        $_SESSION['stsmsg1']="1";
		  }else{
        $_SESSION['stsmsg1']="0";
      }

if(isset($_GET['off']))
		  {
              mysqli_query($con,"update user_acc set status='0' where id_acc = '".$_GET['id']."'");
        $_SESSION['stsmsg']="1";
		  }else{
        $_SESSION['stsmsg']="0";
      }
 ?>
 <?php
include("include/header.php");
 ?>
 <script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "add_admin_check_username.php",
data:'username='+$("#username").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>
<?php
include("include/sidebar.php");
 ?>



  <!-- Main content -->
  <div class="main-content" id="panel">

    <?php
    include("include/topnav.php"); //Edit topnav on this page
    ?>
<?php if(isset($_POST['submit']))
{ if ($_SESSION['msg'] > 0){
  
  ?>
                  <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span> 
                  <span data-notify="message">Data Penyeleksi baru berhasil ditambahkan.</span>
                </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } else {?> 
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan saat menambah Data Penyeleksi baru. Coba sesaat lagi.</span>
                </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } }?> 

<?php if(isset($_GET['del']))
{ if ($_SESSION['delmsg'] > 0){
  
  ?>
                  <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span> 
                  <span data-notify="message">Penyeleksi berhasil dihapus.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } else {?> 
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan saat menghapus Penyeleksi. Coba sesaat lagi.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } }?> 


<?php if(isset($_GET['on']))
{ if ($_SESSION['stsmsg1'] > 0){
  
  ?>
                  <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span> 
                  <span data-notify="message">Akun Penyeleksi berhasil di aktifkan.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } else {?> 
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan saat mengaktifkan akun Penyeleksi. Coba sesaat lagi.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } }?> 


<?php if(isset($_GET['off']))
{ if ($_SESSION['stsmsg'] > 0){
  
  ?>
                  <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span> 
                  <span data-notify="message">Akun Penyeleksi berhasil di nonaktifkan.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } else {?> 
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan saat me-nonaktifkan akun Penyeleksi. Coba sesaat lagi.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } }?> 
    <!-- Header -->


    <!-- Header & Breadcrumbs -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="../adm">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Beasiswa</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Batas Header & Breadcrumbs -->



    <div class="col-md-4">
                  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-body p-0">
                          <div class="card bg-secondary border-0 mb-0">
                            <div class="card-body px-lg-5 py-lg-5">
                              <div class="text-center text-muted mb-4">
                                <small>Form Tambah Penyeleksi Baru</small>
                              </div>
                              <form role="form" method="post">
                              <div class="form-group mb-3">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                                    </div>
                                    <input onBlur="userAvailability()" id="username" name="username" class="form-control" placeholder="Username Penyeleksi Baru" type="text" title="Masukkan Username"  oninvalid="this.setCustomValidity('Selahkan masukkan Username Penyeleksi baru.')" oninput="setCustomValidity('')" required>
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="user-availability-status1"></span>
                                    </div>
                                </div>
                                <span id="user-availability-status1"></span>
                                </div>
                                <div class="form-group mb-3">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control" name="email" placeholder="Email Penyeleksi Baru" type="email" title="Masukkan Email"  oninvalid="this.setCustomValidity('Selahkan masukkan Email Penyeleksi baru.')" oninput="setCustomValidity('')" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" type="password" name="password_default" placeholder="Password" value="1234" readonly="readonly">
                                  </div>
                                  <small>Password default Penyeleksi baru :</small><small style="color:red;"> 1234</small>
                                </div>
                                <div class="text-center">
                                  <button type="submit" id="submit" name="submit" class="btn btn-primary my-4">Tambah Penyeleksi Baru</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
    

 

<!-- Page content -->
<div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">

        <div class="card">
        <!-- Card header -->
        <div class="card-header border-0">
          <div class="row">
            <div class="col-6">
              <h3 class="mb-0">Beasiswa</h3>
            </div>
            <div class="col-6 text-right">
              <a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary btn-round btn-icon" style="color:white;">
                <span class="btn-inner--icon"><i class="fas fa-user-plus" style="color:white;"></i></span>
                <span class="btn-inner--text" style="color:white;">Tambah Beasiswa Baru</span>
              </a>
            </div>
          </div>
        </div>
        <!-- Light table -->
        <div class="table-responsive">
          <table class="table align-items-center table-flush table-striped" >
            <thead class="thead-light">
              <tr>
                <th>Penyeleksi</th>
                <th>Tgl Dibuat</th>
                <th>Email</th>
                <th>No. Telp</th>
                <th>Status</th>
                <th>Pilihan</th>
              </tr>
            </thead>
            
            <tbody>
            <?php $query=mysqli_query($con,"select * from user_acc where username!='".$_SESSION['admlogin']."' order by username DESC");
                      $cnt=1;
                      while($row=mysqli_fetch_array($query))
                      {
                ?>
              <tr>
                <td class="table-user">
                <?php $userphoto=$row['photo_acc'];
                        if($userphoto=="" || $userphoto=="NULL" ):
                        ?>
                  <img src="img/profile.png" class="avatar rounded-circle mr-3">
                  <?php else:?>
                    <img src="img/<?php echo htmlentities($userphoto);?>" class="avatar rounded-circle mr-3">
                    <?php endif;?>
                  <b>
                  <?php $nama_acc=$row['nama_acc'];
                        if($userphoto=="" || $userphoto=="NULL" ){
                          echo htmlentities($row['username']);
                        }else{
                          echo htmlentities($row['nama_acc']);
                        }
                
                        
                        ?>
                  </b>
                </td>
                <td>
                  <span class="text-muted"><?php echo htmlentities($row['createDate']);?></span>
                </td>
                <td>
                  <a href="mailto:<?php echo htmlentities($row['email']);?>" class="font-weight-bold"><?php echo htmlentities($row['email']);?></a>
                </td>
                <td>
                  <a href="tel:<?php echo htmlentities($row['no_telp']);?>" class="font-weight-bold"><?php echo htmlentities($row['no_telp']);?></a>
                </td>
                <td>
                <?php $status=$row['status'];
                        if($status > 0){
                          echo '<span class="badge badge-success">Aktif</span>';
                        }else{
                          echo '<span class="badge badge-danger">Tidak Aktif</span>';
                        }
                        ?>
                </td>
                <td class="text-right">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <?php $status=$row['status'];
                        if($status > 0):
                          ?>
                          <a class="dropdown-item" href="data_penyeleksi?id=<?php echo $row['id_acc']?>&off=0"><i class="fas fa-lock" style="color:#fb6340;"></i> Nonaktifkan Akun</a>
                          <?php else:?>
                          <a class="dropdown-item" href="data_penyeleksi?id=<?php echo $row['id_acc']?>&on=1"><i class="fas fa-lock-open" style="color:#2dce89;"></i> Aktifkan Akun</span></a>
                          <?php endif;?>
                          
                      <a class="dropdown-item" href="data_penyeleksi?id=<?php echo $row['id_acc']?>&del=delete" onClick="return confirm('Yakin ingin menghapus penyeleksi, <?php echo htmlentities($row['username']);?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Hapus Akun</a>
                    </div>
                  </div>
                </td>
                <!-- <td class="table-actions">
                  <a href="#!" class="table-action" data-toggle="tooltip" data-original-title="Edit product">
                    <i class="fas fa-user-edit"></i>
                  </a>
                  <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Delete product">
                    <i class="fas fa-trash"></i>
                  </a>
                </td> -->
              </tr>
              <?php $cnt=$cnt+1; } ?>
            </tbody>
          </table>
        </div>
      </div>

      






        </div>
      </div>




      



<?php
    include("include/footer.php"); //Edit topnav on this page
    ?>
<script> 
function  toggle_select(id) {
    var X = document.getElementById(id);
    if (X.checked == true) {
     X.value = "1";
    } else {
    X.value = "0";
    }
//var sql="update clients set calendar='" + X.value + "' where cli_ID='" + X.id + "' limit 1";
var who=X.id;
var chk=X.value
//alert("Joe is still debugging: (function incomplete/database record was not updated)\n"+ sql);
  $.ajax({
//this was the confusing part...did not know how to pass the data to the script
      url: 'as_status_penyeleksi.php',
      type: 'post',
      data: 'who='+who+'&chk='+chk,
      success: function(output) 
      { alert('success, server says '+output);
      },
      error: function()
      { alert('something went wrong, save failed');
      }
   });
}
</script>
<script type="text/javascript">
    document.getElementById("close_direct").onclick = function () {
        location.href = "data_penyeleksi";
    };
</script>


        </div>
      </div>

</body>

</html>
<?php }?>