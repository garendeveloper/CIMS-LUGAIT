<!DOCTYPE html>
<html lang="en">
<head>
  @include('references.links')
  <link href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <style>
    table, tbody, tr, td{
        text-align: center;
    }

  </style>
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
            <h4>Users</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                    <div class="col-sm-6">
                        <button class = "btn btn-default btn-flat" id = "btn_openform"><i class = "fas fa fa-user-plus"></i>&nbsp;&nbsp; Create User</button>
                    </div>
                </div>
              </div>
             
              <!-- /.card-header -->
              <div class="card-body">
                <table id="users" class="table  table-stripped table-bordered table-hovered">

                <thead style = "background-color: #170036; color: white">
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Role</th>
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
                 Create New User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id = "user_form" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}    
                <div class="modal-body">
                    <input type="text" style = "display: none" name="type" id = "type" value = "">
                    <div class="row" >
                        <input type="hidden" name = "user_id" id = "user_id" value = "">
                        <div class="col-md-4">
                            <label for="">Name<span style="color:red">*</span></label>
                            <input type="text" style = "text-transform: uppercase" name="name" id="name" class="form-control form-control-border border-width-3" autocomplete = "off" 
                                onkeydown="return /[a-zA-Z ]/i.test(event.key)" oninput="return $('#sp_lastname').html(''), $(this).removeClass('is-invalid')">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_sectionname"></span>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Email<span style="color:red">*</span></label>
                            <input type="email" style = "text-transform: uppercase" name="slot" id="slot" class="form-control form-control-border border-width-3" autocomplete = "off">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_usernumber"></span>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Contact Number (<i>Ex. 9303087678</i>)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i>&nbsp; +63</span>
                                </div>
                                <input type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" oninput="return $('#sp_contactnumber1').html(''), $(this).removeClass('is-invalid')" id = "contactnumber1" name = "contactnumber1" class="form-control form-control-border" >
                            </div>
                            <span style = "color: red" class = "span" id = "sp_contactnumber1"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_region').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "region" name = "region" style="width: 100%;">
                                
                            </select>
                            <span style = "color: red" class = "span" id = "sp_region"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_province').html(''), $(this).removeClass('is-invalid')"data-dropdown-css-class="select2-primary" id = "province" name = "province" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_province"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">City / Municipality</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_city').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "city" name = "city" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_city"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_barangay').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "barangay" name = "barangay" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_barangay"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-flat ">Save changes</button>
                    <button type="button" class="btn btn-danger btn-flat " data-dismiss="modal">X Close</button>
                </div>
            </form>
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
  @include('layouts.footer')

</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

@include('references.scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
   $(document).ready(function() {
      $("#s_users").addClass('active');
        $.noConflict();
         //DUGAY KAAYO NI GIGANA ABTAN TAG PILA KA ORAS ANI HAHAHA
         function show_datatable()
         {
            $('#users').DataTable({
                ajax: {
                    type: 'get',
                    url: 'api/users',
                    dataType: 'json',
                },
                serverSide: true,
                processing: true,
                columns: [
                    {data: "id", name: "id"},
                    {data: "name", name: "name"},
                    {data: 'contactnumber', name: 'contactnumber'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
                    {data: 'action', name: 'action'}
                ]
            });
         }
    
        $("#users").on('click', '#btn_del', function(){
            var id = $(this).data('rowid');
            alert(id);
        })  

        function RefreshTable(tableId, urlData) {
            $.getJSON(urlData, null, function(json) {
                table = $(tableId).dataTable();
                oSettings = table.fnSettings();

                table.fnClearTable(this);

                for (var i = 0; i < json.aaData.length; i++) {
                    table.oApi._fnAddData(oSettings, json.aaData[i]);
                }

                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                table.fnDraw();
            });
        }
        function AutoReload() 
        {
            RefreshTable('#users', 'api/users');
        }
        show_datatable();
    })
</script>
<script>
  $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token':$("input[name=_token").val()
        }
    })
    $("#btn_openform").on('click', function(){
      $("#modal_form").modal({
          'backdrop': 'static',
          'keyboard': false
      });
    })
  })
</script>
</body>
</html>
