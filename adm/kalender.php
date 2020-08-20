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
$today = date("Y-m-d");

$page = "kalender";

require_once('proses_kalender/bdd.php');
$sql = "SELECT id, title, start, end, color FROM events ";
$req = $bdd->prepare($sql);
$req->execute();
$events = $req->fetchAll();
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
    
    <!-- Header -->
    <!-- Header -->
    <div class="header header-dark bg-primary pb-6 content__title content__title--calendar">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6">
              <h6 class="fullcalendar-title h2 text-white d-inline-block mb-0">Kalender</h6>
              <nav aria-label="breadcrumb" class="d-none d-lg-inline-block ml-lg-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li> 
                  <li class="breadcrumb-item" ><a href="#">Pilihan <i class="ni ni-ungroup"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Kalender</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 mt-3 mt-lg-0 text-lg-right">
              <a href="#" class="fullcalendar-btn-prev btn btn-sm btn-neutral">
                <i class="fas fa-angle-left"></i>
              </a>
              <a href="#" class="fullcalendar-btn-next btn btn-sm btn-neutral">
                <i class="fas fa-angle-right"></i>
              </a>
              <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="month">Bulan</a>
              <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicWeek">Minggu</a>
              <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicDay">Hari</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content --> 
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <!-- Fullcalendar -->
          <div class="card card-calendar">
            <!-- Card header -->
            <div class="card-header">
              <!-- Title -->
              <h5 class="h3 mb-0">Kalender</h5>
            </div>
            
            <!-- Card body -->
            <div class="card-body p-0">
              <div id="calendar" class="calendar"></div>
            </div>
          </div>
          <!-- Modal - Add new event -->
          <!--* Modal header *-->
          <!--* Modal body *-->
          <!--* Modal footer *-->
          <!--* Modal init *-->
          <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
      <div class="modal-body">
			<form class="form-horizontal" method="POST" action="proses_kalender/addEvent.php">
				  <div class="form-group">
          <label class="form-control-label">Judul Event</label>
					  <input type="text" name="title" class="form-control" id="title" placeholder="Masukkan Judul Event" oninvalid="this.setCustomValidity('Selahkan masukkan Judul Event baru.')" oninput="setCustomValidity('')" required>
				  </div>
				  <div class="form-group mb-0">
          <label class="form-control-label d-block mb-3">Warna</label>
            <div class="btn-group btn-group-toggle btn-group-colors event-tag mb-0" data-toggle="buttons">
                        <label class="btn bg-info active"><input type="radio" name="color" id="color" value="#11cdef" autocomplete="off" checked></label>
                        <label class="btn bg-warning"><input type="radio" name="color" id="color" value="#fb6340" autocomplete="off"></label>
                        <label class="btn bg-danger"><input type="radio" name="color" id="color" value="#f5365c" autocomplete="off"></label>
                        <label class="btn bg-success"><input type="radio" name="color" id="color" value="#2dce89" autocomplete="off"></label>
                        <label class="btn bg-default"><input type="radio" name="color" id="color" value="#172b4d" autocomplete="off"></label>
                        <label class="btn bg-primary"><input type="radio" name="color" id="color" value="#5e72e4" autocomplete="off"></label>
                      </div>
				  </div>
				  <div class="form-group">
            <input type="hidden" name="start" class="form-control" id="start" readonly>
            <input type="hidden" name="end" class="form-control" id="end" readonly>
				  </div>
			  </div>
			  <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan Event</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

			  </div>

      </div>
      </form>
		  </div>
		</div>
          <!-- Modal - Edit event -->
          <!--* Modal body *-->
          <!--* Modal footer *-->
          <!--* Modal init *-->
          <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="proses_kalender/editEventTitle.php">
			  <div class="modal-body">
				  <div class="form-group">
					<label for="title" class="form-control-label">Judul Event</label>
					  <input type="text" name="title" class="form-control" id="title" placeholder="Masukkan Judul Event" oninvalid="this.setCustomValidity('Judul Event tidak boleh kosong.')" oninput="setCustomValidity('')" required>
				  </div>
				  <div class="form-group mb-0">
					<label for="color" class="form-control-label">Warna</label>
          <select name="color" class="form-control" id="color">
						  <option value="">Pilih Warna</option>
						  <option style="color:#11cdef;" value="#11cdef"> Light blue</option>
						  <option style="color:#fb6340;" value="#fb6340"> Orange</option>
						  <option style="color:#f5365c;" value="#f5365c"> Red</option>						  
						  <option style="color:#2dce89;" value="#2dce89"> Green</option>
						  <option style="color:#172b4d;" value="#172b4d"> Dark Blue</option>
						  <option style="color:#5e72e4;" value="#5e72e4"> Blue</option>						  
						</select>
          
				  </div>
				    <div class="form-group"> 
				    <div>
              <br>
            <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" name="delete" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Hapus Event</span>
                  </label>
                </div>
				    </div>
					</div>			  
				  <input type="hidden" name="id" class="form-control" id="id">
			  </div>
			  <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

			  </div>
			</form>
			</div>
		  </div>
		</div>
        </div>
      </div>

      <?php
    include("include/footer.php"); //Edit topnav on this page
    ?>

  <script src="../assets/vendor/fullcalendar/dist/locale/id.js"></script>
  <script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
      lang: 'id',
			header: {
				left: '',
				center: '',
				right: '' 
			},

      buttonIcons: {
      prev: 'calendar--prev',
      next: 'calendar--next'
    },
    theme: false,
			
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD '));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD '));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
        element.prop('title', event.title);
				element.bind('click', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
				});
			},

      viewRender: function(view) {
      var calendarDate = $('#calendar').fullCalendar('getDate');
      var calendarMonth = calendarDate.month();

      //Set data attribute for header. This is used to switch header images using css
      // $this.find('.fc-toolbar').attr('data-calendar-month', calendarMonth);

      //Set title in page header
      $('.fullcalendar-title').html(view.title);
    },

			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [
			<?php foreach($events as $event): 
			
				$start = $event['start'];
				$end = $event['end'];

			?>
				{
					id: '<?php echo $event['id']; ?>',
					title: '<?php echo $event['title']; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					color: '<?php echo $event['color']; ?>',
				},
      <?php endforeach; ?>
      
      
			]
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'proses_kalender/editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Perubahan Baru telah disimpan.');
					}else{
						alert('Gagal menyimpan. Coba beberapa saat lagi.'); 
					}
				}
			});
		}
		
    
  //Calendar views switch
  $('body').on('click', '[data-calendar-view]', function(e) {
    e.preventDefault();

    $('[data-calendar-view]').removeClass('active');
    $(this).addClass('active');

    var calendarView = $(this).attr('data-calendar-view');
    $('#calendar').fullCalendar('changeView', calendarView);
  });


  //Calendar Next
  $('body').on('click', '.fullcalendar-btn-next', function(e) {
    e.preventDefault();
    $('#calendar').fullCalendar('next');
  });


  //Calendar Prev
  $('body').on('click', '.fullcalendar-btn-prev', function(e) {
    e.preventDefault();
    $('#calendar').fullCalendar('prev');
  });

//Display Current Date as Calendar widget header
var mYear = moment().format('YYYY');
    var mDay = moment().format('dddd, MMM D');
    $('.widget-calendar-year').html(mYear);
    $('.widget-calendar-day').html(mDay);
	});

</script>
<script>
  $(document).ready(function() {
 $('#pilihan').click(function() {

      $('.pilihan-menu').slideToggle();
  });
 });
  </script>
  





        </div>
      </div>

</body>

</html>
<?php }?> 