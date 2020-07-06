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

 ?>
<?php
include("include/header.php");
 ?>

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
                  <span data-notify="message">Data Admin baru berhasil ditambahkan.</span>
                </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } else {?> 
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan saat menambah Data Admin baru. Coba sesaat lagi.</span>
                </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
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
                  <li class="breadcrumb-item active" aria-current="page">Riwayat Login User</li>
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

    



<!-- Page content -->
<div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">

          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0">Data Riwayat Login User</h3>
              <p class="text-sm mb-0">
                Tabel ini merupakan detail riwayat login hingga logout user mulai dari Admin, Penyeleksi & Mahasiswa. Tabel ini berguna untuk melacak 
                jejak login user pada sistem. Riwayat yang di tampilkan pada tabel hanya data login terbaru <strong>6 bulan terakhir</strong> saja.
              </p>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="datatable-buttons">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>User IP</th>
                    <th>Waktu Login</th>
                    <th>Waktu Logout</th>
                    <th>Status Login</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>User IP</th>
                    <th>Waktu Login</th>
                    <th>Waktu Logout</th>
                    <th>Status Login</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php $query=mysqli_query($con,"select * from userlog order by loginTime DESC");
                      $cnt=1;
                      while($row=mysqli_fetch_array($query))
                      {
                ?>
                  <tr>
                    <td><?php echo htmlentities($cnt);?></td>
                    <td><?php echo htmlentities($row['username']);?></td>
                    <td><?php echo htmlentities($row['userip']);?></td>
                    <td><?php echo htmlentities($row['loginTime']);?></td>
                    <td><?php echo htmlentities($row['logout']); ?></td>
                    <td><center><?php $st=$row['status'];

if($st==1)
{
	echo "<p class='btn btn-success btn-sm'>Sukses</p>";
}
else
{
	echo "<p class='btn btn-danger btn-sm'>Gagal</p>";
}
										 ?></td>
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
        </div>
      </div>

</body>

</html>
<?php }?>