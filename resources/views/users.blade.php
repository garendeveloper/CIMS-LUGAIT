<!DOCTYPE html>
<html lang="en">
<head>
  @include('references.links')
  <style>
    select,option{
      text-transform: uppercase;
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
                        <button class = "btn btn-primary btn-flat" id = "btn_reload"><i class = "fas fa fa-sync"></i>&nbsp;&nbsp; Reload Table</button>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="users" class="table  table-stripped table-bordered table-hovered">

                <thead style = "background-color: #170036; color: white">
                  <tr>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Role</th>
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
                 Create New User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id = "user_form" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}    
                <div class="modal-body">
                    <div class="row" >
                        <input type="hidden"  name = "user_id" id = "user_id" value = "0">
                        <input type="hidden"  name = "role" id = "role"  value  = "0">
                        <input type="hidden"  name = "changepass" id = "changepass"  value  = "0">
                        <input type="hidden"  name = "address_id" id = "address_id"  value  = "">
                        <input type="hidden"  name = "address_id1" id = "address_id1"  value  = "">

                        <div class="col-md-4">
                            <label for="">Name<span style="color:red">*</span></label>
                            <input type="text" style = "text-transform: uppercase" name="name" id="name" class="form-control form-control-border border-width-3" autocomplete = "off" 
                                onkeydown="return /[a-zA-Z ]/i.test(event.key)" oninput="return $('#errmsg_name').html(''), $(this).removeClass('is-invalid')">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_name"></span>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Email<span style="color:red">*</span></label>
                            <input type="email" oninput="return $('#errmsg_email').html(''), $(this).removeClass('is-invalid')" style = "text-transform: uppercase" name="email" id="email" class="form-control form-control-border border-width-3" autocomplete = "off">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_email"></span>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Contact Number (<i>Ex. 9303087678</i>)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i>&nbsp; +63</span>
                                </div>
                                <input type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" oninput="return $('#sp_contactnumber').html(''), $(this).removeClass('is-invalid')" id = "contactnumber" name = "contactnumber" class="form-control form-control-border" >
                            </div>
                            <span style = "color: red" class = "span_error" id = "sp_contactnumber"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                          <button type = "button" class = "button btn btn-sm btn-primary" id = "btn_changeaddress">Change Address</button>
                          <button  style = "display: none" type = "button" class = "button btn btn-sm btn-secondary" id = "btn_unchangeaddress">Unchange Address</button>
                        </div>
                      </div>
                    <p></p>
                    <div class="row" id = "address_area1">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2 select2-primary " disabled data-dropdown-css-class="select2-primary" id = "region1"  style="width: 100%;">
                                
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary " disabled data-dropdown-css-class="select2-primary" id = "province1" style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">City / Municipality</label>
                            <select class="form-control form-control-border select2-primary"  disabled data-dropdown-css-class="select2-primary" id = "city1"  style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" disabled data-dropdown-css-class="select2-primary" id = "barangay1" n style="width: 100%; text-transform: uppercase">
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="row" id = "address_area" style = "display: none">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2 select2-primary" onchange="return $('#sp_region').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "region" name = "region" style="width: 100%;">
                                
                            </select>
                            <span style = "color: red" class = "span_error" id = "sp_region"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary " onchange="return $('#sp_province').html(''), $(this).removeClass('is-invalid')"data-dropdown-css-class="select2-primary" id = "province" name = "province" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span_error" id = "sp_province"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">City / Municipality</label>
                            <select class="form-control form-control-border select2-primary " onchange="return $('#sp_city').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "city" name = "city" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span_error" id = "sp_city"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary " onchange="return $('#sp_barangay').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "barangay" name = "barangay" style="width: 100%; text-transform: uppercase">
                            </select>
                            <span style = "color: red" class = "span_error" id = "sp_barangay"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="login-cred" >
                      <h4>Login Credentials</h4>
                      <div class="row">
                        <div class="col-md-6">
                          <button type = "button" class = "button btn btn-sm btn-primary" id = "btn_changepass">Change Login Credentials</button>
                          <button  style = "display: none" type = "button" class = "button btn btn-sm btn-secondary" id = "btn_unchangepass">Unchange Login Credentials</button>
                        </div>
                      </div>
                      <p></p>
                      <div class="row" id = "creden" style = "display: none">
                          <div class="col-md-4">
                            <label for="">Current Password<span style="color:red">*</span></label>
                            <input class="form-control form-control-border select2-primary" type="password" name="prev_pwd" id="prev_pwd" oninput="return $('#sp_prevpwd').html(''), $(this).removeClass('is-invalid')">
                            <span style = "color: red" class = "span_error" id = "sp_prevpwd"></span>
                          </div>
                          <div class="col-md-4">
                            <label for="">New Password<span style="color:red">*</span></label>
                            <input class="form-control form-control-border select2-primary" type="password" name="new_pwd" id="new_pwd" oninput="return $('#sp_newpwd').html(''), $(this).removeClass('is-invalid')">
                            <span style = "color: red" class = "span_error" id = "sp_newpwd"></span>
                          </div>
                          <div class="col-md-4">
                            <label for="">Confirm Password<span style="color:red">*</span></label>
                            <input class="form-control form-control-border select2-primary" type="password" name="con_pwd" id="con_pwd" oninput="return $('#sp_conpwd').html(''), $(this).removeClass('is-invalid')">
                            <span style = "color: red" class = "span_error" id = "sp_conpwd"></span>
                          </div>
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
<script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
<script type="text/javascript">

    var my_handlers = {

            fill_provinces:  function(){
                $("#city").html("");
                $("#barangay").html("");
                var region_code = $(this).val();
                $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);
                
            },

            fill_cities: function(){
                $("#barangay").html("");
                var province_code = $(this).val();
                $('#city').ph_locations( 'fetch_list', [{"province_code": province_code}]);
            },


            fill_barangays: function(){
                var city_code = $(this).val();
                $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
            }
      };

        $(function(){
            $('#region').on('change', my_handlers.fill_provinces);
            $('#province').on('change', my_handlers.fill_cities);
            $('#city').on('change', my_handlers.fill_barangays);

            $('#region').ph_locations({'location_type': 'regions'});
            $('#province').ph_locations({'location_type': 'provinces'});
            $('#city').ph_locations({'location_type': 'cities'});
            $('#barangay').ph_locations({'location_type': 'barangays'});
            $('#region').ph_locations('fetch_list');
        });

</script>
<script>
   $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-Token':$("input[name=_token").val()
          }
      })
       //Initialize Select2 Elements
    $('.select2').select2()
      $("#s_users").addClass('active');
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
                columnDefs: [{
                    className: "text-center", // Add 'text-center' class to the targeted column
                    targets: [1, 2, 3, 4, 5] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                }],
                columns: [
                    {data: "name", name: "name"},
                    {data: 'contactnumber', name: 'contactnumber'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ]
            });
         }
    
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

        $("#users").on('click', '#btn_deactivate', function(){
            var id = $(this).data('rowid');
            if(confirm("Are you sure you want to deactivate this user?\n\nNote: Upon clicking Ok, User will no longer have access to the system.\nAnd will be currently locked\n\nDo you want to proceed?"))
            {
              $.ajax({
                type:'get',
                url: 'users/deactivate/'+id,
                dataType: 'json',
                success: function(resp){
                  $(document).Toasts('create', {
                      class: 'bg-success',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: resp.message,
                  })
                  AutoReload();
                }
              })
            }
        })  
        $("#users").on('click', '#btn_activate', function(){
            var id = $(this).data('rowid');
            if(confirm("Are you sure you want to activate this user?\n\nNote: Upon clicking Ok, User will have access to the system.\n\nDo you want to proceed?"))
            {
              $.ajax({
                type:'get',
                url: 'users/activate/'+id,
                dataType: 'json',
                success: function(resp){
                  $(document).Toasts('create', {
                      class: 'bg-success',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: resp.message,
                  })
                  AutoReload();
                }
              })
            }
        })  

        $("#btn_reload").on('click', function(){
          AutoReload();
        })
        $("#btn_changepass").on('click', function(){
          $("#changepass").val("1");
          $("#creden").show();
          $("#role").val("1");
          $("#btn_unchangepass").show();
        })
        $("#btn_unchangepass").on('click', function(){
          $("#changepass").val("0");
          $("#creden").hide();
          $("#role").val("1");
          $("#btn_unchangepass").hide();
        })

        $("#btn_openform").on('click', function(){
          $("#user_form")[0].reset();
          $(".login-cred").hide();
          $("#user_id").val("");
          $("#role").val("");
          $("#address_id").val("");
          $("#changepass").val("");
          $("select").val("");

          $("#address_area1").hide();
          $("#address_area").show();
          $("#btn_unchangeaddress").hide();
          $("#btn_changeaddress").hide();
          $("#modal_form").modal({
              'backdrop': 'static',
              'keyboard': false
          });
          $('#region').ph_locations('fetch_list');
        })
        $("#btn_changeaddress").on('click', function(){
          $("#address_area1").hide();
          $("#address_area").show();
          $("#btn_unchangeaddress").show();
          $("#address_id").val("");
          $('#region').ph_locations('fetch_list');
        })
        $("#btn_unchangeaddress").on('click', function(){
          $("#address_area1").show();
          $("#address_area").hide();
          var address1 = $("#address_id1").val();
          $("#address_id").val(address1);
          $("#btn_unchangeaddress").hide();
        })
        $("#users").on('click', '#btn_edit', function(e){
          e.preventDefault();
          var id = $(this).data('rowid');
          $("#user_id").val(id);
          $("#user_form")[0].reset();
          $("select").html("");

          //Remove invalid error messages of inputs.
          $("#name").removeClass('is-invalid');
          $("#email").removeClass('is-invalid');
          $("#contactnumber").removeClass('is-invalid');
          $("#region").removeClass('is-invalid');
          $("#province").removeClass('is-invalid');
          $("#city").removeClass('is-invalid');
          $("#barangay").removeClass('is-invalid');
          $(".span_error").html("");
          //Show address area
          $("#address_area1").show();
          $("#address_area").hide();
          $("#btn_changeaddress").show();
          $("#btn_unchangeaddress").hide();

          $("#creden").hide();
          $("#btn_unchangepass").hide();
          $(".login-cred").hide();
          $.ajax({
            type:'get',
            url: 'users/show/'+id,
            dataType: 'json',
            success: function(user){
              $("#name").val(user[0].name);
              $("#email").val(user[0].email);
              $("#contactnumber").val(user[0].contactnumber.replace("63", ""));
              $("#address_id").val(user[0].address_id);
              $("#address_id1").val(user[0].address_id);
              
              $("#region1").prepend("<option selected='selected' value = "+user[0].region_no+">"+user[0].region+"</option>");
              $("#province1").prepend("<option selected='selected' value = "+user[0].province_no+">"+user[0].province+"</option>");
              $("#city1").prepend("<option selected='selected' value = "+user[0].city_no+">"+user[0].city+"</option>");
              $("#barangay1").prepend("<option selected='selected' value = "+user[0].barangay_no+">"+user[0].barangay+"</option>");
            
              $("#modal_form").modal({
                  'backdrop': 'static',
                  'keyboard': false
              });
             
            },
            error: function(error){
              console.log("Responding error...")
            }
          })
         
        })
        $("#users").on('click', '#myprofile', function(){
          var id = $(this).data('rowid');
          $("#user_id").val(id);
          $("#user_form")[0].reset();
          $("select").html("");
          $(".login-cred").show();
          $("#role").val("1");
          $("#changepass").val("0");

          //Remove invalid error messages of inputs.
          $("#name").removeClass('is-invalid');
          $("#email").removeClass('is-invalid');
          $("#contactnumber").removeClass('is-invalid');
          $("#region").removeClass('is-invalid');
          $("#province").removeClass('is-invalid');
          $("#city").removeClass('is-invalid');
          $("#barangay").removeClass('is-invalid');
          $(".span_error").html("");
          //Show address area
          $("#address_area1").show();
          $("#address_area").hide();
          $("#btn_changeaddress").show();
          $("#btn_unchangeaddress").hide();

          $.ajax({
            type:'get',
            url: 'users/show/'+id,
            dataType: 'json',
            success: function(user){
              $("#name").val(user[0].name);
              $("#email").val(user[0].email);
              $("#contactnumber").val(user[0].contactnumber.replace("63", ""));
              $("#address_id").val(user[0].address_id);
              $("#address_id1").val(user[0].address_id);
              
              $("#region1").prepend("<option selected='selected' value = "+user[0].region_no+">"+user[0].region+"</option>");
              $("#province1").prepend("<option selected='selected' value = "+user[0].province_no+">"+user[0].province+"</option>");
              $("#city1").prepend("<option selected='selected' value = "+user[0].city_no+">"+user[0].city+"</option>");
              $("#barangay1").prepend("<option selected='selected' value = "+user[0].barangay_no+">"+user[0].barangay+"</option>");
             
              $("#modal_form").modal({
                  'backdrop': 'static',
                  'keyboard': false
              });
            }
          })

        })
        $("#user_form").on('submit', function(e){
          e.preventDefault();
          if($("#user_id").val() != "")
          {
            $.ajax({
              type: 'put',
              url: 'users/update/'+$("#user_id").val(),
              data: {
                name: $("#name").val(),
                email: $("#email").val(),
                contactnumber: $("#contactnumber").val(),
                region: $("#region").val(),
                region_text: $("#region option:selected").text(),
                province: $("#province").val(),
                province_text: $("#province option:selected").text(),
                city: $("#city").val(),
                city_text: $("#city option:selected").text(),
                barangay: $("#barangay").val(),
                barangay_text: $("#barangay option:selected").text(),
                changepass: $("#changepass").val(),
                role: $("#role").val(),
                address_id: $("#address_id").val(),
                curr_pwd: $("#prev_pwd").val(),
                new_pwd: $("#new_pwd").val(),
                con_pwd: $("#con_pwd").val(),
              },
              dataType: 'json',
              success: function(resp){
                if(resp.status == 200)
                {
                  $(document).Toasts('create', {
                      class: 'bg-success',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: resp.messages,
                  })
                  $("#modal_form").modal('hide');
                  $("#user_form")[0].reset();
                  $("select").html();
                  $("input").removeClass('is-invalid');
                  AutoReload();
                }
                else
                {
                  $(document).Toasts('create', {
                      class: 'bg-danger',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: "Check your form.",
                  })
                  $.each(resp.messages, function(key, value){
                    if(key == "name")
                    {
                        $("#errmsg_name").text(value);
                        $("#name").addClass('is-invalid');
                    }
                    if(key == "email")
                    {
                        $("#errmsg_email").text(value);
                        $("#email").addClass('is-invalid');
                    }
                    if(key == "contactnumber")
                    {
                        $("#sp_contactnumber").text(value);
                        $("#contactnumber").addClass('is-invalid');
                    }
                    if(key == "region")
                    {
                        $("#sp_region").text(value);
                        $("#region").addClass('is-invalid');
                    }
                    if(key == "province")
                    {
                        $("#sp_province").text(value);
                        $("#province").addClass('is-invalid');
                    }
                    if(key == "city")
                    {
                        $("#sp_city").text(value);
                        $("#city").addClass('is-invalid');
                    }
                    if(key == "barangay")
                    {
                        $("#sp_barangay").text(value);
                        $("#barangay").addClass('is-invalid');
                    }
                    if(key == "curr_pwd")
                    {
                        $("#sp_prevpwd").text(value);
                        $("#prev_pwd").addClass('is-invalid');
                    }
                    if(key == "new_pwd")
                    {
                        $("#sp_newpwd").text(value);
                        $("#new_pwd").addClass('is-invalid');
                    }
                    if(key == "con_pwd")
                    {
                        $("#sp_conpwd").text(value);
                        $("#con_pwd").addClass('is-invalid');
                    }
                  })
                }
              }
          })
          }
          else
          {
            $.ajax({
              type: 'post',
              url: '{{ route("users.store") }}',
              data: {
                address_id: $("#address_id").val(),
                name: $("#name").val(),
                email: $("#email").val(),
                contactnumber: $("#contactnumber").val(),
                region: $("#region").val(),
                region_text: $("#region option:selected").text(),
                province: $("#province").val(),
                province_text: $("#province option:selected").text(),
                city: $("#city").val(),
                city_text: $("#city option:selected").text(),
                barangay: $("#barangay").val(),
                barangay_text: $("#barangay option:selected").text(),
              },
              dataType: 'json',
              success: function(resp){
                if(resp.status == 200)
                {
                  $(document).Toasts('create', {
                      class: 'bg-success',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: resp.messages,
                  })
                  $("#modal_form").modal('hide');
                  $("#user_form")[0].reset();
                  $("select").html();
                  $("input").removeClass('is-invalid');
                  AutoReload();
                }
                else
                {
                  $(document).Toasts('create', {
                      class: 'bg-danger',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: "Check your form.",
                  })
                  $.each(resp.messages, function(key, value){
                    if(key == "name")
                    {
                        $("#errmsg_name").text(value);
                        $("#name").addClass('is-invalid');
                    }
                    if(key == "email")
                    {
                        $("#errmsg_email").text(value);
                        $("#email").addClass('is-invalid');
                    }
                    if(key == "contactnumber")
                    {
                        $("#sp_contactnumber").text(value);
                        $("#contactnumber").addClass('is-invalid');
                    }
                    if(key == "region")
                    {
                        $("#sp_region").text(value);
                        $("#region").addClass('is-invalid');
                    }
                    if(key == "province")
                    {
                        $("#sp_province").text(value);
                        $("#province").addClass('is-invalid');
                    }
                    if(key == "city")
                    {
                        $("#sp_city").text(value);
                        $("#city").addClass('is-invalid');
                    }
                    if(key == "barangay")
                    {
                        $("#sp_barangay").text(value);
                        $("#barangay").addClass('is-invalid');
                    }
                  })
                }
              }
            })
          }
        })
    })
</script>

</body>
</html>
