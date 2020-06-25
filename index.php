 <?php
include("include/header.php");
include("include/config.php");
 ?>

 
   <!-- Main content -->
   <div class="main-content"> 

     <!-- Header -->
     <!-- <div class="header bg-primary pt-5 pb-7">
       <div class="container">
         <div class="header-body">
           <div class="row align-items-center"> -->
             <!-- <div class="col-lg-6">
               <div class="pr-5">
                 <h1 class="display-2 text-white font-weight-bold mb-0">Argon Dashboard PRO</h1>
                 <h2 class="display-4 text-white font-weight-light">A beautiful premium dashboard for Bootstrap 4.</h2>
                 <p class="text-white mt-4">Argon perfectly combines reusable HTML and modular CSS with a modern styling and beautiful markup throughout each HTML template in the pack.</p>
                 <div class="mt-5">
                   <a href="./pages/dashboards/dashboard.html" class="btn btn-neutral my-2">Explore Dashboard</a>
                   <a href="https://www.creative-tim.com/product/argon-dashboard-pro" class="btn btn-default my-2">Purchase now</a>
                 </div>
               </div>
             </div> -->
             <!-- <div class="col-lg-6">
               <div class="row pt-5">
                 <div class="col-md-6">
                   <div class="card">
                     <div class="card-body">
                       <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow mb-4">
                         <i class="ni ni-active-40"></i>
                       </div>
                       <h5 class="h3">Components</h5>
                       <p>Argon comes with over 70 handcrafted components.</p>
                     </div>
                   </div>
                   <div class="card">
                     <div class="card-body">
                       <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow mb-4">
                         <i class="ni ni-active-40"></i>
                       </div>
                       <h5 class="h3">Plugins</h5>
                       <p>Fully integrated and extendable third-party plugins that you will love.</p>
                     </div>
                   </div>
                 </div>
                 <div class="col-md-6 pt-lg-5 pt-4">
                   <div class="card mb-4">
                     <div class="card-body">
                       <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow mb-4">
                         <i class="ni ni-active-40"></i>
                       </div>
                       <h5 class="h3">Pages</h5>
                       <p>From simple to complex, you get a beautiful set of 15+ page examples.</p>
                     </div>
                   </div>
                   <div class="card mb-4">
                     <div class="card-body">
                       <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow mb-4">
                         <i class="ni ni-active-40"></i>
                       </div>
                       <h5 class="h3">Documentation</h5>
                       <p>You will love how easy is to to work with Argon.</p>
                     </div>
                   </div> -->
                 <!-- </div>
               </div>
             </div>
           </div>
         </div>
       </div>
       <div class="separator separator-bottom separator-skew zindex-100">
         <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
           <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
         </svg>
       </div>
     </div> -->

     <section class="pb-9 bg-default">
     <!-- <div id="demo" class="carousel slide" data-ride="carousel"> -->

<!-- Indicators -->
<!-- <ul class="carousel-indicators">
  <li data-target="#demo" data-slide-to="0" class="active"></li>
  <li data-target="#demo" data-slide-to="1"></li>
  <li data-target="#demo" data-slide-to="2"></li>
</ul> -->

<!-- The slideshow -->
<!-- <div class="carousel-inner">
  <div class="carousel-item active">
    <img src="https://www.ukdw.ac.id/wp-content/uploads/2019/01/WEB-SLIDE-AKRED-A.jpg" alt="Los Angeles" width="800" height="400">
  </div>
  <div class="carousel-item">
    <img src="https://www.ukdw.ac.id/wp-content/uploads/2019/01/SLIDER-CORE-SML.jpg" alt="Chicago" width="800" height="400">
  </div>
  <div class="carousel-item">
    <img src="https://www.ukdw.ac.id/wp-content/uploads/2019/01/SLIDER-SOSMED.jpg" alt="New York" width="800" height="400">
  </div>
</div> -->

<!-- Left and right controls -->
<!-- <a class="carousel-control-prev" href="#demo" data-slide="prev">
  <span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#demo" data-slide="next">
  <span class="carousel-control-next-icon"></span>
</a>
</div> -->
       <!-- <div class="row justify-content-center text-center">
         <div class="col-md-6">
           <h3 class="display-3 text-white">Pengumuman</h3>
             <p class="lead text-white">
               Argon is a completly new product built on our newest re-built from scratch framework structure that is meant to make our products more intuitive,
               more adaptive and, needless to say, so much easier to customize. Let Argon amaze you with its cool features and build tools and get your project to a whole new level.
             </p>
         </div> -->
       </div>
     </section>
     <section class="section section-lg pt-lg-0 mt--7">
       <div class="container">
         <div class="row justify-content-center">

              <!-- batas pengumuman -->
              <?php

                $status='1';                   
                $rt = mysqli_query($con,"SELECT * FROM informasi where status='$status'");
                $cnt=1;
                $many_rows = mysqli_num_rows($rt);
                $val = mysqli_fetch_array($rt);
                {?><?php 
                  $rows=htmlentities($many_rows);
                  $jdl_info=htmlentities ($val['jdl_info']);
                  $detail_info=htmlentities ($val['detail_info']);
                  if($rows > "0"){

                  echo  "
                  <div class='col-lg-12'>
                  <div class='row'>
                        <div class='col-lg-12' id='pengumuman'>
                          <div class='card card-lift--hover shadow border-0'>
                            <div class='card-body py-5'>
                              <div class='icon icon-shape bg-gradient-primary text-white rounded-circle mb-4'>
                              <i class='fas fa-newspaper'></i> 
                              </div> 

                              <h4 class='h3 text-primary text-uppercase' >".$jdl_info."</h4>
                              <p class='description mt-3'>".$detail_info."</p>

                            </div>

                          </div>
                        </div>";
                  }
                    else { }
            
                }?>


               <!-- informasi beasiswa dan pinjaman -->
               <div class="col-lg-6">
                 <div class="card card-lift--hover shadow border-0">
                   <div class="card-body py-5">
                     <div class="icon icon-shape bg-gradient-success text-white rounded-circle mb-4">
                     <i class="fas fa-graduation-cap"></i>
                     </div>
                     <h4 class="h3 text-success text-uppercase">Beasiswa Kebutuhan UKDW</h4>
                     <p class="description mt-3">Ditawarkan kepada mahasiswa minimal telah duduk di semester II yang mengalami kesulitan finansial.</p>
                     <div>
                     <p class="description mt-3"><i class="fas fa-clock"></i> </i> Deadline Registrasi : 20 Agustus 2020 <span class="badge badge-pill badge-success">DIBUKA</span></p>
                     </div>
                   </div>
                 </div>
               </div>
               <div class="col-lg-6">
                 <div class="card card-lift--hover shadow border-0">
                   <div class="card-body py-5">
                     <div class="icon icon-shape bg-gradient-danger text-white rounded-circle mb-4">
                     <i class="fas fa-hand-holding-usd"></i>
                     </div>
                     <h4 class="h3 text-danger text-uppercase">Pinjaman Registrasi UKDW</h4>
                     <p class="description mt-3">Ditawarkan kepada mahasiswa minimal telah duduk di semester II yang mengalami kesulitan finansial.</p>
                     <div>
                     <p class="description mt-3"><i class="fas fa-clock"></i> </i> Deadline Registrasi : 20 Agustus 2020 <span class="badge badge-pill badge-danger">DITUTUP</span></p>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </section>
     <!-- <section class="py-6">
       <div class="container">
         <div class="row row-grid align-items-center">
           <div class="col-md-6 order-md-2">
             <img src="./assets/img/theme/landing-1.png" class="img-fluid">
           </div>
           <div class="col-md-6 order-md-1">
             <div class="pr-md-5">
               <h1>Awesome features</h1>
               <p>This dashboard comes with super cool features that are meant to help in the process. Handcrafted components, page examples and functional widgets are just a few things you will see and love at first sight.</p>
               <ul class="list-unstyled mt-5">
                 <li class="py-2">
                   <div class="d-flex align-items-center">
                     <div>
                       <div class="badge badge-circle badge-success mr-3">
                         <i class="ni ni-settings-gear-65"></i>
                       </div>
                     </div>
                     <div>
                       <h4 class="mb-0">Carefully crafted components</h4>
                     </div>
                   </div>
                 </li>
                 <li class="py-2">
                   <div class="d-flex align-items-center">
                     <div>
                       <div class="badge badge-circle badge-success mr-3">
                         <i class="ni ni-html5"></i>
                       </div>
                     </div>
                     <div>
                       <h4 class="mb-0">Amazing page examples</h4>
                     </div>
                   </div>
                 </li>
                 <li class="py-2">
                   <div class="d-flex align-items-center">
                     <div>
                       <div class="badge badge-circle badge-success mr-3">
                         <i class="ni ni-satisfied"></i>
                       </div>
                     </div>
                     <div>
                       <h4 class="mb-0">Super friendly support team</h4>
                     </div>
                   </div>
                 </li>
               </ul>
             </div>
           </div>
         </div>
       </div>
     </section> -->
     <!-- <section class="py-6">
       <div class="container">
         <div class="row row-grid align-items-center">
           <div class="col-md-6">
             <img src="./assets/img/theme/landing-2.png" class="img-fluid">
           </div>
           <div class="col-md-6">
             <div class="pr-md-5">
               <h1>Example pages</h1>
               <p>If you want to get inspiration or just show something directly to your clients, you can jump start your development with our pre-built example pages.</p>
               <a href="./pages/examples/profile.html" class="font-weight-bold text-warning mt-5">Explore pages</a>
             </div>
           </div>
         </div>
       </div>
     </section> -->
      <!-- <section class="py-6">
       <div class="container">
         <div class="row row-grid align-items-center">
           <div class="col-md-6 order-md-2">
             <img src="./assets/img/theme/landing-3.png" class="img-fluid">
           </div>
           <div class="col-md-6 order-md-1">
             <div class="pr-md-5">
               <h1>Lovable widgets and cards</h1>
               <p>We love cards and everybody on the web seems to. We have gone above and beyond with options for you to organise your information. From cards designed for content, to pricing cards or user profiles, you will have many options to choose from.</p>
               <a href="./pages/widgets.html" class="font-weight-bold text-info mt-5">Explore widgets</a>
             </div>
           </div>
         </div>
       </div>
     </section> -->
     <!-- <section class="py-7 section-nucleo-icons bg-white overflow-hidden">
       <div class="container">
         <div class="row justify-content-center">
           <div class="col-lg-8 text-center">
             <h2 class="display-3">Nucleo Icons</h2>
             <p class="lead">
               The official package contains over 21.000 icons which are looking great in combination with Argon Design System. Make sure you check all of them and use those that you like the most.
             </p>
             <div class="btn-wrapper">
               <a href="./docs/foundation/icons.html" class="btn btn-primary">View demo icons</a>
               <a href="https://nucleoapp.com/?ref=1712" target="_blank" class="btn btn-default mt-3 mt-md-0">View all icons</a>
             </div>
           </div>
         </div>
         <div class="blur--hover">
           <a href="./docs/foundation/icons.html">
             <div class="icons-container blur-item mt-5"> -->

     <!-- <section class="py-7">
       <div class="container">
         <div class="row row-grid justify-content-center">
           <div class="col-lg-8 text-center">
             <h2 class="display-3">Do you love this awesome <span class="text-success">Dashboard for Bootstrap 4?</span></h2>
             <p class="lead">Cause if you do, it can be yours now. Hit the button below to navigate to get the free version or purchase a license for your next project. Build a new web app or give an old Bootstrap project a new look!</p>
             <div class="btn-wrapper">
               <a href="https://www.creative-tim.com/product/argon-dashboard" class="btn btn-neutral mb-3 mb-sm-0" target="_blank">
                 <span class="btn-inner--text">Get FREE version</span>
               </a>
               <a href="https://www.creative-tim.com/product/argon-dashboard-pro" class="btn btn-primary btn-icon mb-3 mb-sm-0">
                 <span class="btn-inner--icon"><i class="ni ni-basket"></i></span>
                 <span class="btn-inner--text">Purchase now</span>
                 <span class="badge badge-md badge-pill badge-floating badge-danger border-white">$79</span>
               </a>
             </div>
             <div class="text-center">
               <h4 class="display-4 mb-5 mt-5">Available on these technologies</h4>
               <div class="row justify-content-center">
                 <div class="w-10 mx-2 mb-2">
                   <a href="https://www.creative-tim.com/product/argon-dashboard" target="_blank" data-toggle="tooltip" data-original-title="Bootstrap 4 - Most popular front-end component library">
                     <img src="https://s3.amazonaws.com/creativetim_bucket/tim_static_images/presentation-page/bootstrap.jpg" class="img-fluid rounded-circle shadow shadow-lg--hover">
                   </a>
                 </div>
                 <div class="w-10 mx-2 mb-2">
                   <a href=" https://www.creative-tim.com/product/vue-argon-dashboard" target="_blank" data-toggle="tooltip" data-original-title="Vue.js - The progressive javascript framework">
                     <img src="https://s3.amazonaws.com/creativetim_bucket/tim_static_images/presentation-page/vue.jpg" class="img-fluid rounded-circle">
                   </a>
                 </div>
                 <div class="w-10 mx-2 mb-2">
                   <a href=" https://www.creative-tim.com/product/argon-dashboard" target="_blank" data-toggle="tooltip" data-original-title="Sketch - Digital design toolkit">
                     <img src="https://s3.amazonaws.com/creativetim_bucket/tim_static_images/presentation-page/sketch.jpg" class="img-fluid rounded-circle">
                   </a>
                 </div>
                 <div class="w-10 mx-2 mb-2">
                   <a href=" https://www.creative-tim.com/product/argon-dashboard-angular" target="_blank" data-toggle="tooltip" data-original-title="Angular - One framework. Mobile &amp; desktop">
                     <img src="https://s3.amazonaws.com/creativetim_bucket/tim_static_images/presentation-page/angular.jpg" class="img-fluid rounded-circle">
                   </a>
                 </div>
                 <div class="w-10 mx-2 mb-2">
                   <a href=" https://www.creative-tim.com/product/argon-dashboard-react" target="_blank" data-toggle="tooltip" data-original-title="React - A JavaScript library for building user interfaces">
                     <img src="https://s3.amazonaws.com/creativetim_bucket/tim_static_images/presentation-page/react.jpg" class="img-fluid rounded-circle">
                   </a>
                 </div>
                 <div class="w-10 mx-2 mb-2">
                   <a href=" https://www.creative-tim.com/product/argon-dashboard-laravel" target="_blank" data-toggle="tooltip" data-original-title="Laravel - The PHP Framework For Web Artisans">
                     <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/logos/laravel_logo.png" class="img-fluid rounded-circle">
                   </a>
                 </div>
                 <div class="w-10 mx-2 mb-2">
                   <a href=" https://www.creative-tim.com/product/argon-dashboard-nodejs" target="_blank" data-toggle="tooltip" data-original-title="Node.js - a JavaScript runtime built on Chrome's V8 JavaScript engine">
                     <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/logos/nodejs-logo.jpg" class="img-fluid rounded-circle">
                   </a>
                 </div>
                 <div class="w-10 mx-2 mb-2">
                   <a href=" https://www.adobe.com/products/photoshop.html" target="_blank" data-toggle="tooltip" data-original-title="[Coming Soon] Adobe Photoshop - Software for digital images manipulation">
                     <img src="https://s3.amazonaws.com/creativetim_bucket/tim_static_images/presentation-page/ps.jpg" class="img-fluid rounded-circle opacity-3">
                   </a>
                 </div>
               </div>
               <div class="spinner-border" role="status">
                 <span class="sr-only">Loading...</span>
               </div>
             </div>
           </div>
         </div>
       </div>
     </section> -->
   </div>
   <?php
include("include/footer.php");
 ?>