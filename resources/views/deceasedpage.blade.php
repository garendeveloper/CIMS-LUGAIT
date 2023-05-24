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

  <!-- Navbar -->
  @include('layouts.header')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Deceaseds</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('managers.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Manage Deceaseds</li>
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
                    {{ csrf_field() }}
                    <div class="col-md-4">
                        <button class = "btn btn-primary" id = "btn_add"><i class = "fa fa-plus-square"></i></button>
                    </div>
                    <div class="col-md-6">
                        <input type="hidden" value = "" id = "service_id" name = "id">
                        <input type="text" style ="text-transform: uppercase" name = "service_name" class = "form-control " id = "service_name">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class = "form-control" id = "search">
                    </div>
                </div>
              </div>
              <style>
                table, td, th{
                    border: 1px solid #170036;
                }
                table{
                    border-collapse: collapse;
                    width: 100%;
                }
                th{
                    height: 30px;
                }
              </style>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_deceased" style = "font-size: 12px;" class="">
                  <thead style = "background-color: #170036; color: white">
                  <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middlename</th>
                    <th>Address</th>
                    <th>Date of death</th>
                    <th>Service</th>
                    <th>Nationality</th>
                    <th>Status</th>
                    <th>Action</th>
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

  <div class="modal fade" id="modal_form">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header" style = "background-color: #170036; color: white">
            <h4 class="modal-title"> 
            <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 50px; height: 50px" alt="">    
            Cemetery Form</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
     
        <div class="modal-body">
            <form action="" method="post">
                <div class="row" >
                    <div class="col-md-3" >
                        <label for="">Last Name</label>
                        <input type="text" name="lastname" id="lastname" class="form-control form-control-border">
                    </div>
                    <div class="col-md-3">
                        <label for="">First Name</label>
                        <input type="text" name="firstname" id="firstname" class="form-control form-control-border">
                    </div>
                    <div class="col-md-3">
                        <label for="">Middle Name</label>
                        <input type="text" name="middlename" id="middlename" class="form-control form-control-border">
                    </div>
                    <div class="col-md-3">
                        <label for="">Date of Death</label>
                        <input type="date" name="dateof_death" id="dateof_death" class="form-control form-control-border">
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Date of Birth</label>
                        <input type="date" name="dateofbirth" id="dateofbirth" class="form-control form-control-border">
                    </div>
                    <div class="col-md-4">
                        <label for="">Civil Status</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="civilstatus">
                                <label for="radioPrimary1">
                                    Single
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" id="radioPrimary2" name="civilstatus">
                                <label for="radioPrimary2">
                                    Married
                                </label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input type="radio" id="radioPrimary3" name="civilstatus">
                                <label for="radioPrimary3">
                                    Widowed
                                </label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input type="radio" id="radioPrimary4" name="civilstatus">
                                <label for="radioPrimary4">
                                    Divorced
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="">Date of Burial</label>
                        <input type="date" name="dateof_burial" id="dateof_burial" class="form-control form-control-border">
                    </div>
                    <div class="col-md-2">
                        <label for="">Time</label>
                        <input type="time" name="time" id="time" class ="form-control form-control-border">
                    </div>
                    <div class="col-md-2">
                        <label for="">Sex</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary5" name="sex">
                                <label for="radioPrimary5">
                                    Male
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" id="radioPrimary6" name="sex">
                                <label for="radioPrimary6">
                                    Female
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <label for="">Country</label>
                            <input type="text" name="address" id="address" class="form-control form-control-border">
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-md-6">
                        <label for=""><u>Space Area</u></label>
                        <div class="form-group clearfix">
                            <div class="form-group ">
                                <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option selected="selected">Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for=""><u>Other Services</u> </label>
                        <div class="form-group ">
                            <select class="form-control select2 select2-info" data-dropdown-css-class="select2-info" style="width: 100%;">
                                <option selected="selected">Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('references.scripts')

<script>
  $(document).ready(function(){
    $("#s_deceaseds").addClass('active');
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#btn_add").on('click', function(){
        $("#modal_form").modal({backdrop:'static', keyboard: false});
    })
  })
</script>
</body>
</html>
