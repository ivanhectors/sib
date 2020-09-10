<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['mhslogin']) == 0) {
  header('location:../403');
} else {
  date_default_timezone_set('Asia/Jakarta'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());
  $today = date("Y-m-d");

  $page = "kalender";

  require_once('proses_kalender/bdd.php');
  $sql = "SELECT id, title, start, end, color FROM events ";
  $req = $bdd->prepare($sql);
  $req->execute();
  $events = $req->fetchAll();

  $sql2 = "SELECT * FROM beasiswa where tampilkan='1'";
  $req2 = $bdd->prepare($sql2);
  $req2->execute();
  $events2 = $req2->fetchAll();
?>


  <?php
  include("include/header.php");
  ?>


  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
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
                  <li class="breadcrumb-item"><a href="../mhs?id">Dashboard</a></li>
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

            editable: false,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            selectHelper: false,
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
            eventResize: function(event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

              edit(event);

            },
            events: [
              <?php foreach ($events as $event) :

                $start = $event['start'];
                $end = $event['end'];

              ?> {
                  id: '<?php echo $event['id']; ?>',
                  title: '<?php echo $event['title']; ?>',
                  start: '<?php echo $start; ?>',
                  end: '<?php echo $end; ?>',
                  color: '<?php echo $event['color']; ?>',
                },
              <?php endforeach; ?>

              <?php foreach ($events2 as $event) :

                $start = $event['tgl_buka'];
                $end = $event['tgl_tutup'];

              ?> {
                  id: '<?php echo $event['id_bsw']; ?>',
                  title: '<?php echo $event['nama_bsw']; ?>',
                  start: '<?php echo $start; ?>',
                  end: '<?php echo $end; ?>',
                  color: '#f5365c',
                },
              <?php endforeach; ?>


            ]
          });




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
<?php } ?>