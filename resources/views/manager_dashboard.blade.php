<!DOCTYPE html>
<html lang="en">
<head>
  @include('references.links')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->
  <div class="preloader flex-column justify-content-center align-items-center" >
    <img class="animation__shake" src="{{ asset('dist/img/loader.gif')}}" alt="AdminLTELogo" height="60" width="60">
    <p>Please wait ... </p>
  </div>
  <!-- Navbar -->
  @include('layouts.header')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2" style = " background-color: #170036; color: white; ">
          <div class="col-sm-12">
            <div class="card-header" >
                <div style="text-align: center" >
                  <h1 style ="font-family: monospace; font-weight: bold; text-transform: uppercase">Welcome to Lugait Cemetery Electronic Information Management System</h1>
                </div>
              </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0" style = "background-color: darkred; color: white">
                <div class="d-flex justify-content-between" >
                  <h3 class="card-title">Death by Year</h3>
                  <a href="{{route('deceaseds.index')}}" class = "btn btn-sm btn-default"><i class="fas fa fa-arrow-right"></i>&nbsp;&nbsp; View Deceaseds</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">{{ $no_ofdeceaseds}}</span>
                    <span>Total No. of Deceaseds</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="deathbyyears_chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Year deceased died
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0" style = "background-color: darkred; color: white">
                <div class="d-flex justify-content-between" >
                  <h3 class="card-title">Deceased by Age</h3>
                  <a href="{{route('deceaseds.index')}}" class = "btn btn-sm btn-default"><i class="fas fa fa-arrow-right"></i>&nbsp;&nbsp; View Deceaseds</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">{{ $no_ofdeceaseds}}</span>
                    <span>Total No. of Deceaseds</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="ageofdeceased_chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Age of deceased
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-lg-12">
            <div class="card card-warning">
              <div class="card-header">
                <h5>Deceased for Approval</h5>
              </div>
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('references.scripts')

<script>
  $(document).ready(function(){
    'use strict'
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold',
    }

    var mode = 'index'
    var intersect = true
    var years_ofdeads = {{Js::From($deaths_label)}};
    var deaths_values = {{Js::From($deaths_values)}};
    var salesChart = $('#deathbyyears_chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart(salesChart, {
      type: 'bar',
      data: {
        labels: years_ofdeads,
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: deaths_values,
          },
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            display: true,
            gridLines: {
              display: true,
              // lineWidth: '4px',
              // color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += ''
                }

                return value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  })
</script>
<!-- Age of deceased chart presentation-->
<script>
  $(document).ready(function(){
    'use strict'
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold',
    }

    var mode = 'index'
    var intersect = true
    var dateofbirth_label = {{Js::From($dateofbirth_label)}};
    var dateofbirth_values = {{Js::From($dateofbirth_values)}};
    var salesChart = $('#ageofdeceased_chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart(salesChart, {
      type: 'bar',
      data: {
        labels: dateofbirth_label,
        datasets: [
          {
            backgroundColor: 'darkred',
            borderColor: '#007bff',
            data: dateofbirth_values,
          },
        ] 
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            display: true,
            gridLines: {
              display: true,
              // lineWidth: '4px',
              // color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += ''
                }

                return value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  })
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#s_dashboard").addClass('active');
  })
</script>
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }


    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;

    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------
    var schedules_data = {{Js::From($schedules_data)}};
    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'bootstrap',
      //Random default events
      events: schedules_data,
      editable  : false,
      droppable :false, // this allows things to be dropped onto the calendar !!!
    });

    calendar.render();
    // $('#calendar').fullCalendar()
  })
</script>
</body>
</html>
