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

  <style>
    input[type=text]:focus {
        border: 3px solid #555;
        color: black;
    }
    input[type=number]:focus {
        border: 3px solid #555;
    }
    input[type=text]{
        border-color: 3px solid #555;
    }
  </style>
  @if(Session::get('NotFound'))
    <script>
        alert({{ Session::get('NotFound') }});
    </script>
  @endif
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4>Space Areas <span class = "badge badge-success" id = "no_ofrecords">1</span></h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Space Areas</li>
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
                    <div class="col-sm-6">
                        <button class = "btn btn-danger" id = "btn_openform"><i class = "fas fa fa-plus-square"></i> Add Block</button>
                    </div>
                    <label for="" class = "col-sm-2 col-form-label">Search Block</label>
                    <div class="col-sm-4">
                        <input type="text" class = "form-control is-warning" id = "search">
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
                <table id="tbl_spaceAreas" class="table responsive">
                  <thead style = "background-color: #170036; color: white">
                  <tr align = "center">
                    <th>Image</th>
                    <th>Section Name</th>
                    <th>Slot / Vacancy</th>
                    <th>Section Cost</th>
                    <th style = "text-align: center">Action</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style = "background-color: #170036; color: white">
                <h4 class="modal-title"> 
                <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 50px; height: 50px" alt="">    
                 Space Area Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id = "block_form" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}    
                <div class="modal-body">
                    <input type="text" style = "display: none" name="type" id = "type" value = "">
                    <div class="row" >
                        <input type="hidden" name = "block_id" id = "block_id" value = "">
                        <div class="col-md-6">
                            <label for="">Section Name <span style="color:red">*</span></label>
                            <input type="text" style = "text-transform: uppercase" name="section_name" id="section_name" class="form-control form-control-border border-width-3" autocomplete = "off">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_sectionname"></span>
                        </div>
                        <div class="col-md-6" >
                            <label for="">Slot / Vacancy<span style="color:red">*</span></label>
                            <input type="number" style = "text-transform: uppercase" name="slot" id="slot" class="form-control form-control-border border-width-3" autocomplete = "off">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_blocknumber"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Section Cost <span style="color:red">*</span></label>
                            <input type="number" style = "font-size: 25px; text-transform: uppercase; text-align: right;" name="block_cost" id="block_cost" class="form-control form-control-border border-width-3" autocomplete = "off">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_blockcost"></span>
                        </div>  
                        <div class="col-md-6">
                            <label for="">Image<span style="color:red"></span></label>
                            <img  style = "width: 200px; height: 200px; border: 1px solid;" src="" alt="preview_image" id = "preview_image">
                             <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_image"></span>
                             <input type="file" value = "" name="image" id="image" class="form-control">
                             
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    <!-- /.modal -->

<div class="modal fade" id="slot_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style = "background-color: #170036; color: white;">
                <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 50px; height: 50px" alt="">    
                <h6 class="modal-title" style = "font-weight: bold"> 
                 ADJUST SECTION SLOT</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id = "slot_form" method="post">
                <div class="modal-body">
                    <div class="row" >
                        <input type="hidden" name = "_block_id" id = "_block_id" value = "">
                        <h5 style = "font-size: 12px; color: green">Note: <i> Just put a negative sign to decrease the slot</i></h5>
                        <div class="col-md-12">
                            <label for="">ADJUST (<span style = "color: green; font-size: 15px;">+</span> <span style = "color: red; font-size: 15px;">-</span>)</label>
                            <input type="number" value = "0" style = "font-size: 25px; text-transform: uppercase; text-align: right;"    
                            name="_slot" id="_slot" class="form-control form-control-border border-width-3" autocomplete = "off">
                            <span style ="color:red; font-size: 12px" id = "errmsg_slot"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-block btn-sm">Save changes</button>
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
@include('references.scripts')
<script>
  $(function () {
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
            $("#tbl_spaceAreas tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $("#s_spaceareas").addClass('active');
        $("#_slot").on('change', function(){
           $(this).number(true, 2);
        })
        $("#btn_openform").on('click', function(){
            $("#slot").prop('readonly', false);
            $("#block_form")[0].reset();
            $("#block_id").val("");
            $("#preview_image").attr('src', '{{asset("dist/img/rip.jpg")}}');
            $(".span_error").html("");
            $("input").removeClass('is-invalid')
            $("#modal_form").modal({
                'backdrop': 'static',
                'keyboard': false
            });
        })
        $("#tbl_spaceAreas tbody").on('click', "#btn_slot", function(){
            var id = $(this).data('id');
            $.ajax({
                type: 'get',
                url: '/spaceAreas/show/'+id,
                dataType: 'json',
                success: function(data)
                {
                    $("#slot_form").trigger('reset');
                    $("#slot_modal").modal({
                        'backdrop': 'static',
                        'keyboard': false,
                    });
                    $("#_block_id").val(data.id);
                    $("#slot_modal").find('.modal-title').text("ADJUST VACANCY FOR "+data.section_name+"")
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
        // apply the currencyFormat behaviour to elements with 'currency' as their class
    
        show_allData();
        function show_allData()
        {
          $.ajax({
            type: 'get',
            url: "{{ route('spaceareas.get_allBlocks') }}",
            dataType: 'json',
            success:function(data)
            {
                var row = "";
                $("#no_ofrecords").text(data.length + " Records");
                if(data.length > 0)
                {
                    for(var i = 0; i<data.length; i++)
                    {
                        row += '<tr data-id = '+data[i].id+' style = "text-transform: uppercase;">';
                        if(data[i].image != "" && data[i].image != null) 
                        { 
                            row += '<td align = "center" data-id = '+data[i].id+'><img class = "img-responsive" src = "/upload_images/'+data[i].image+'" style = "height: 100px; width: 100px" ></td>';    
                        }
                        else {
                             row += '<td align = "center" data-id = '+data[i].id+'><img src= "{{ asset("dist/img/rip.jpg") }}" class = "img-responsive" style = "width: 100px; height: 100px"></td>';   
                        } 
                        row += '<td data-id = '+data[i].id+'>'+data[i].section_name+'</td>';    
                        row += '<td  data-id = '+data[i].id+' style = "font-size: 20px; text-align: center; font-family: Times New Roman; font-weight: bold; color: red">'+data[i].slot+'</td>';
                        row += '<td data-id = '+data[i].id+' style = "font-size: 20px; text-align: right; font-family: Times New Roman; "> P '+$.number(data[i].block_cost, 2)+'</td>';
                        row += '<td align = "center">';
                        row += '<button data-id = '+data[i].id+' id = "btn_edit" type="button" class="btn btn-success btn-sm btn-flat">';
                        row += '<i class = "fa fa-edit"></i>';
                        row += '</button>';
                        row += '<button data-id = '+data[i].id+' id = "btn_slot" type="button" class="btn btn-primary btn-sm btn-flat">';
                        row += '<i class = "fa fa-laptop"></i>';
                        row += '</button></td>';
                        row += '</tr>';
                    }
                }
                else
                {
                    row += '<tr style = "text-transform: uppercase"><td colspan = "4">No data available</td></tr>';
                }
                $("#tbl_spaceAreas tbody").html(row);
            },
            error: function()
            {
                alert("System cannot process request.")
            }
          })
        }
        $("#slot_form").on('submit', function(e){
            e.preventDefault();
            if($("#_slot").val() == 0)
            {
                alert("No adjustment.");
            }
            else
            {
                if(confirm("Are you sure you want to expand this section?"))
                {
                    $.ajax({
                        type: 'put',
                        url: "{{ route('spaceareas.update', 'id') }}",
                        data: {
                            type: 'update_slot',
                            _slot: $("#_slot").val(),
                            _block_id: $("#_block_id").val()
                        },
                        dataType: 'json',
                        success: function(response)
                        {
                            if(response.status == 1)
                            {
                                show_allData();
                                $("#slot_modal").modal('hide');
                                $("#slot_form").trigger('reset');
                                $("input").removeClass('is-invalid');
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
                                $("#slot_form").trigger('reset');
                                $("input").removeClass('is-invalid');
                                $.each(response.message, function(key,value) {
                                    
                                    if(key == "_slot")
                                    {
                                        $("#errmsg_slot").text(value);
                                        $("input[name='slot']").addClass('is-invalid');
                                    }
                                }); 
                            }
                            else
                            {
                                alert(response.message);
                            }
                        },
                        error: function(error)
                        {
                            alert("Cannot process the request.");
                        }
                    })   
                }
            }
        })
        let block_image = null;
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview_image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function(e){
            block_image = e.target.files[0];
            readURL(this);
        });
        $("#block_form").on('submit', function(e){
            e.preventDefault();
            var slot = $("input[name='slot']").val().toUpperCase();
            var section_name = $("input[name='section_name']").val().toUpperCase();
            var block_cost = $("input[name='block_cost']").val();
            var block_id = $("#block_id").val();

            if(block_id != "")
            {
                var data = new FormData(this);
                data.append('type', 'update_block');   
                $.ajax({
                    url: "/spaceareas/updatewithimage",
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response)
                    {
                        if(response.status == 1)
                        {
                            show_allData();
                            $("#modal_form").modal('hide');
                            $("#block_form").trigger('reset');
                            $("input[type='text']").removeClass('is-invalid');
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
                            $("input[type='text']").removeClass('is-invalid');
                            $("input[type='number']").removeClass('is-invalid');
                            $("#errmsg_blockcost").html("");
                            $("#errmsg_blocknumber").html("");
                            $("#errmsg_sectionname").html("");
                            $.each(response.message, function(key,value) {
                                
                                if(key == "block_cost")
                                {
                                    $("#errmsg_blockcost").text(value);
                                    $("input[name='block_cost']").addClass('is-invalid');
                                }
                                if(key == "section_name")
                                {
                                    $("#errmsg_sectionname").text(value);
                                    $("input[name='section_name']").addClass('is-invalid');
                                }
                                if(key == "slot")
                                {
                                    $("#errmsg_blocknumber").text(value);
                                    $("input[name='slot']").addClass('is-invalid');
                                }
                                if(key == "image")
                                {
                                    $("#errmsg_image").text(value);
                                    $("input[name='image']").addClass('is-invalid');
                                }
                            }); 
                        }
                        else
                        {
                            alert(response.message);
                        }
                    },
                    error: function(error)
                    {
                        alert("Cannot process the request.");
                    }
                })
            }
            else
            {
                $.ajax({
                    type: 'post',
                    url: "{{ route('spaceareas.store') }}",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response)
                    {
                        if(response.status == 1)
                        {
                            show_allData();
                            $("#modal_form").modal('hide');
                            $("#block_form").trigger('reset');
                            $("input[type='text']").removeClass('is-invalid');
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
                            $("input[type='text']").removeClass('is-invalid');
                            $("input[type='number']").removeClass('is-invalid');
                            $("#errmsg_blockcost").html("");
                            $("#errmsg_blocknumber").html("");
                            $("#errmsg_sectionname").html("");
                            $.each(response.message, function(key,value) {
                                
                                if(key == "block_cost")
                                {
                                    $("#errmsg_blockcost").text(value);
                                    $("input[name='block_cost']").addClass('is-invalid');
                                }
                                if(key == "section_name")
                                {
                                    $("#errmsg_sectionname").text(value);
                                    $("input[name='section_name']").addClass('is-invalid');
                                }
                                if(key == "slot")
                                {
                                    $("#errmsg_blocknumber").text(value);
                                    $("input[name='slot']").addClass('is-invalid');
                                }
                                if(key == "image")
                                {
                                    $("#errmsg_image").text(value);
                                    $("input[name='image']").addClass('is-invalid');
                                }
                            }); 
                        }
                        else
                        {
                            alert(response.message);
                        }
                    },
                    error: function(error)
                    {
                        alert("Cannot process the request.");
                    }
                })
            }
        })
        
        $("#tbl_spaceAreas tbody").on('click', '#btn_edit', function(){
            $("#slot").prop('readonly', true);
            var id = $(this).data('id');
            $.ajax({
                type: 'get',
                url: '/spaceAreas/show/'+id,
                dataType: 'json',
                success: function(data)
                {
                    $("#block_id").val(data.id);
                    $("#slot").val(data.slot.toUpperCase());
                    $("#section_name").val(data.section_name.toUpperCase());
                    $("#block_cost").val(data.block_cost);
                    if(data.image != "")
                    {
                        $("#preview_image").attr('src', '/upload_images/'+data.image)
                    }
                    else
                    {
                        $("#preview_image").attr('src', '{{asset("dist/img/rip.jpg")}}');
                    }
                    $("#modal_form").modal({
                        'backdrop': 'static',
                        'keyboard': false,
                    })
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
        
        $("#tbl_spaceAreas tbody").on('click', '#btn_remove', function(){
            var id = $(this).data('id');
            if(confirm("Are you sure you want to deactivate this section? \nCannot be undone."))
            {
                $.ajax({
                    type: 'get',
                    url: '/spaceAreas/delete/'+id,
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
                        show_allData();
                        $("#block_form").trigger('reset');
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
