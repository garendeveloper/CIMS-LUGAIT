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
   <!-- Preloader -->
   <div id = "pageloader" class="preloader flex-column justify-content-center align-items-center" style = "display: none">
    <img class="animation__shake" src="{{ asset('dist/img/loader.gif')}}" alt="AdminLTELogo" height="60" width="60">
    <p>Please wait ... </p>
  </div>
   
  <!-- Navbar -->
  @include('layouts.header')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

  <style>
    select,option,input{
        text-transform: uppercase;
    }
    .modal{
        background: url("/dist/img/cemetery.jpg") no-repeat center fixed;
        background-size: cover;
      
    }
    
  </style>
  <style>
    input[type=text]:focus {
        border: 3px solid #17a2b8;
        color: black;
    }
    select:focus {
        border: 3px solid #17a2b8;
        color: black;
    }
    input[type=number]:focus {
        border: 3px solid #17a2b8;
    }
    input[type=text]{
        border-color: 3px solid #17a2b8;
    }
    input[type=date]{
        font-family: 'Segoe UI' 
    }
    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        .noPrint{
            display: none;
        }
        body * {
            visibility:hidden;
            -webkit-print-color-adjust: exact;
        }
        #tbl_deceasedinfo tbody tr{
            color: 'black';
        }
        #tbl_contactinfo tr{
            color: 'black';
            print-color-adjust: exact; 
        }
    }
  </style>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4>Deceased Nearing Maturity  <span class = "badge badge-sm badge-success" id = "no_ofrecords">0</span></h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('managers.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Deceased for Approval</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class = "form-control is-primary" style ="text-transform: uppercase" placeholder = "Search Record Here" id = "search">
                        </div>
                    </div>
                </div>
              </div>
              <style>
                table, td, th{
                    border: 1px solid #170036;
                }
              </style>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_deceaseds"  class="table table-stripped table-hovered">
                  <thead style = "background-color: #170036; color: white">
                    <tr style = "text-align: center">
                        <th>Full Name (L,M,F)</th>
                        <th>Date of Burial</th>
                        <th>Block Assigned</th>
                        <th>Expiration</th>
                    </tr>
                  </thead>
                  <tbody >
                 
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token':$("input[name=_token").val()
        }
    }) 

    $("#s_nearingMaturity").addClass('active')
    $("#search").addClass('active');
    show_allData();
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbl_deceaseds tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    var _token = $('input[name="_token"]').val();
    function calculateCoffinYears(dateofburial, validity)
    {
        var dob = new Date(dateofburial);
        var val = new Date();
        var count = Math.floor((val-dob) / (365.25 * 24 * 60 * 60 * 1000));
        return count;
    }
    function show_allData()
    {
        $.ajax({
            type: 'get',
            url: "{{ route('deceaseds.get_allMaturity') }}",
            dataType: 'json',
            success:function(data)
            {
                var row = "";
                
                var total = 0;
                if(data.length > 0)
                {
                    for(var i = 0; i<data.length; i++)
                    {
                        row += '<tr data-id = '+data[i].deceased_id+' style = "text-transform: uppercase">';
                          row += '<td>'+data[i].lastname+", "+data[i].middlename+", "+data[i].firstname+'</td>';
                          row += '<td align="center">'+formatDate(data[i].dateof_burial)+'</td>';
                          row += '<td align="center">'+data[i].section_name+'</td>';
                          var count = calculateCoffinYears(data[i].dateof_burial, data[i].validity);
                          if(count < data[i].validity)
                          {
                            row += '<td align = "center"><span class="badge badge-primary">'+calculateCoffinYears(data[i].dateof_burial, data[i].validity)+' Remaining Years</span></td>';
                          }
                          else 
                          {
                            row += '<td style = "color: red" align = "center"><span class="badge badge-danger">EXPIRED</span></td>';
                          }
                          // row += '<td align = "center">';
                          // row += '<button data-id = '+data[i].deceased_id+' id = "btn_approve" type="button" class="btn btn-primary btn-sm btn-flat">';
                          // row += '<i class = "fa fas fa-approve"></i>&nbsp;&nbsp;APPROVE';
                          // row += '</button>';
                          // row += "</td>";
                        row += '</tr>';
                        total += 1;
                    }
                }
                else
                {
                    row += '<tr style = "text-transform: uppercase"><td colspan = "6">No data available</td></tr>';
                }
                $("#no_ofrecords").text(total + " Records");
                $("#tbl_deceaseds tbody").html(row);
            },
            error: function()
            {
                alert("System cannot process request.")
            }
        })
    }
    function formatDate(userdate)
    {
        var month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        var date    = new Date(userdate);
        return month[date.getMonth()] + " "+date.getDate() + ", "+date.getFullYear();
    }
  })
</script>
</body>
</html>
