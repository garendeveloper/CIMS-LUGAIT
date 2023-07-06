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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
@include('references.scripts')

<script>
   $(document).ready(function() {
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
                    {data: 'action', name: 'action'}
                ]
            });
         }
    
        $("#users").on('click', '#btn_del', function(){
            var id = $(this).data('rowid');
            alert(id);
            setTimeout(function() {
                AutoReload();
            }, 30000);
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

            setTimeout(function() {
                AutoReload();
            }, 30000);
        }
        show_datatable();
        setTimeout(function() {
            AutoReload();
        }, 30000);
    })
</script>
</body>
</html>
