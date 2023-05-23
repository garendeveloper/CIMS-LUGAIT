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
            <h1>Services</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Services</li>
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
                    <label for="" class = "col-sm-4 col-form-label">Service Name</label>
                    <div class="col-sm-4">
                        <input type="hidden" value = "" id = "service_id" name = "id">
                        <input type="text" style ="text-transform: uppercase" name = "service_name" class = "form-control " id = "service_name">
                    </div>
                    <div class="col-sm-2">
                        <button class = "btn btn-primary btn-sm" type = "button" id = "btn_add" ><i class = "fa fa-plus-square"></i> </button>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class = "form-control" id = "search">
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_services" class="table table-bordered table-striped">
                  <thead style = "background-color: #170036; color: white">
                  <tr>
                    <th>Service Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
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
  $(function () {
    // $("#tbl_services").DataTable({
    //   "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    // $('#tbl_services').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
  });
</script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token':$("input[name=_token").val()
            }
        })
        var _token = $('input[name="_token"]').val();
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tbl_services tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $("#s_services").addClass('active');
        show_allData();
        function show_allData()
        {
          $.ajax({
            type: 'get',
            url: "{{ route('get_allServices') }}",
            dataType: 'json',
            success:function(data)
            {
                var row = "";
                if(data.length > 0)
                {
                    for(var i = 0; i<data.length; i++)
                    {
                        row += '<tr data-id = '+data[i].id+' style = "text-transform: uppercase">';
                        row += '<td data-column_name  = "service_name" data-id = '+data[i].id+'>'+data[i].service_name+'</td>';
                        row += '<td data-id = '+data[i].id+'>'+data[i].created_at+'</td>';    
                        row += '<td data-id = '+data[i].id+'>'+data[i].updated_at+'</td>';
                        row += '<td align = "center">';
                        row += '<button data-id = '+data[i].id+' id = "btn_edit" type="button" class="btn btn-success btn-sm btn-flat">';
                        row += '<i class = "fa fa-edit"></i>';
                        row += '</button>';
                        row += '<button data-id = '+data[i].id+' id = "btn_remove" type="button" class="btn btn-danger btn-sm btn-flat">';
                        row += '<i class = "fas fa fa-trash"></i>';
                        row += '</button></td>';
                        row += '</tr>';
                    }
                }
                else
                {
                    row += '<tr style = "text-transform: uppercase"><td colspan = "4">No data available</td></tr>';
                }
                $("#tbl_services tbody").html(row);
            },
            error: function()
            {
                alert("System cannot process request.")
            }
          })
        }
        $("#btn_add").on('click', function(){
            var service_name = $("#service_name").val();
            var id = $("#service_id").val();
            if(id != "")
            {
                if(service_name != "")
                {
                    $.ajax({
                        type: 'put',
                        url: "{{ route('services.update', 'id') }}",
                        data: {
                            service_name: service_name,
                            service_id: id,
                        },
                        dataType: 'json',
                        success: function(response)
                        {
                            if(response.status == 1)
                            {
                                $("#service_name").removeClass('is-invalid');
                                $("#service_name").val("");
                                show_allData();
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            }
                            else if(response.status == 2)
                            {
                                $("#service_name").addClass('is-invalid');
                                $.each(response.message, function(key,value) {
                                    $(document).Toasts('create', {
                                        class: 'bg-danger',
                                        title: 'Responses',
                                        autohide: true,
                                        delay: 3000,
                                        body: value,
                                    })
                                }); 
                            }
                            else
                            {
                                $(document).Toasts('create', {
                                    class: 'bg-danger',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            }
                        },
                        error: function(error)
                        {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Responses',
                                autohide: true,
                                delay: 3000,
                                body: "Cannot process the request.",
                            })
                        }
                    })
                }
                else
                {
                    $("#service_name").addClass('is-invalid')
                }
            }
            else
            {
                if(service_name != "")
                {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('services.store') }}",
                        data: {
                            service_name: service_name,
                        },
                        dataType: 'json',
                        success: function(response)
                        {
                            if(response.status == 1)
                            {
                                $("#service_name").removeClass('is-invalid');
                                $("#service_name").val("");
                                $("#service_id").val("");
                                show_allData();
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            }
                            else if(response.status == 2)
                            {
                                $("#service_name").addClass('is-invalid');
                                $.each(response.message, function(key,value) {
                                    $(document).Toasts('create', {
                                        class: 'bg-danger',
                                        title: 'Responses',
                                        autohide: true,
                                        delay: 3000,
                                        body: value,
                                    })
                                }); 
                            }
                            else
                            {
                                $(document).Toasts('create', {
                                    class: 'bg-danger',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            }
                        },
                        error: function(error)
                        {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Responses',
                                autohide: true,
                                delay: 3000,
                                body: "Cannot process the request.",
                            })
                        }
                    })
                }
                else
                {
                    $("#service_name").addClass('is-invalid')
                }
            }
        })
        $("#tbl_services tbody").on('click', '#btn_edit', function(){
            var id = $(this).data('id');
            $.ajax({
                type: 'get',
                url: '/services/show/'+id,
                dataType: 'json',
                success: function(data)
                {
                    $("#service_id").val(data.id);
                    $("#service_name").val(data.service_name.toUpperCase());
                },
                error: function(error)
                {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Responses',
                        autohide: true,
                        delay: 3000,
                        body: "Cannot process the request.",
                    })
                }
            })
        })
        $("#tbl_services tbody").on('click', '#btn_remove', function(){
            var id = $(this).data('id');
            if(confirm("Are you sure you want to delete this record? \nCannot be undone."))
            {
                $.ajax({
                    type: 'get',
                    url: '/services/delete/'+id,
                    dataType: 'json',
                    success: function(data)
                    {
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Responses',
                            autohide: true,
                            delay: 3000,
                            body: data.message,
                        })
                        $("#service_id").val("");
                        show_allData();
                    },
                    error: function(error)
                    {
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Responses',
                            autohide: true,
                            delay: 3000,
                            body: "Cannot process the request.",
                        })
                    }
                })
            }
        })
    })
</script>
</body>
</html>
