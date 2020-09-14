<!-- Footer -->
<footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center text-lg-left text-muted">
              &copy; 2020 <a href="https://www.ukdw.ac.id" class="font-weight-bold ml-1" target="_blank">UKDW</a>
            </div>
          </div>
          <div class="col-lg-6"> 
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
            <div class="copyright text-center text-lg-left text-muted">
            Made with <i  style="color: #e25555;" class="fas fa-heart"></i> by<a href="https://ivanhectors.me/" class="font-weight-bold ml-1" target="_blank">Ivan Hectors</a>
            </div>
            
            </ul>
          </div>
        </div>
      </footer>

  
<!-- Argon Scripts -->
  <!-- Core -->
  <script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="../assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="../assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="../assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="../assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <script src="../assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
  <!-- Optional JS -->
  <script src="../assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
  <script src="../assets/vendor/datatables.net-buttons/js/jszip.min.js"></script>
  <script src="../assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="../assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="../assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
  <script src="../assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="../assets/select/js/select2.min.js"></script>   
  <script src="../assets/select/js/i18n/id.js"></script> 
  <!-- Calender JS -->
  <script src="../assets/vendor/moment/min/moment.min.js"></script>
  <script src="../assets/vendor/fullcalendar/dist/fullcalendar.min.js"></script>
  <script src="../assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
 <!-- quill -->
 <script src="../assets/vendor/ckeditor/ckeditor.js"></script>

  <!-- Argon JS -->
  <script src="../assets/js/argon.js?v=1.1.0"></script>
  <!-- Demo JS - remove this in your project --> 
  <script src="../assets/js/demo.min.js"></script>

  <script>
function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").className = "dropdown-menu dropdown-menu-left dropdown-menu-arrow";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").className = "dropdown-menu dropdown-menu-left dropdown-menu-arrow show";
      document.getElementById("livesearch").style.position="absolute";
    document.getElementById("livesearch").style.transform="translate3d(-160px, -123px, 0px)"; 
    document.getElementById("livesearch").style.top="100%";
    document.getElementById("livesearch").style.zIndex="1000";
    document.getElementById("livesearch").style.left="3%";
    document.getElementById("livesearch").style.willChange="transform";
    document.getElementById("livesearch").style.boxSizing="border-box";
    document.getElementById("livesearch").style.minWidth="23rem";

    }
  }
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
}
</script>
 
  
