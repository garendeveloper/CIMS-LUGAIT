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
    select,option,input{
        text-transform: uppercase;
    }
  </style>
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
                  
                    <div class="col-md-4">
                        <button class = "btn btn-primary" id = "btn_add"><i class = "fa fa-plus-square"></i></button>
                    </div>
                    <div class="col-md-2">
                        <input type="text" autocomplete = "off" class = "form-control" id = "search">
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
                Lugait Public Cemetery Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id = "cemetery_form" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row" >
                        <div class="col-md-3" >
                            <label for="">Last Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" 
                                onkeydown="return /[a-zA-Z]/i.test(event.key)"
                                name="lastname" id="lastname" class="form-control form-control-border">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="">First Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" onkeydown="return /[a-zA-Z]/i.test(event.key)" name="firstname" id="firstname" class="form-control form-control-border">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="">Middle Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" onkeydown="return /[a-zA-Z]/i.test(event.key)" name="middlename" id="middlename" class="form-control form-control-border">
                            </div>
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
                                    <input type="radio" id="radioPrimary1" value = "S" name="civilstatus">
                                    <label for="radioPrimary1">
                                        Single
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="radioPrimary2"  value = "M" name="civilstatus">
                                    <label for="radioPrimary2">
                                        Married
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="radioPrimary3" value = "W" name="civilstatus">
                                    <label for="radioPrimary3">
                                        Widowed
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="radioPrimary4" value = "D" name="civilstatus">
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
                            <input type="time" name="burial_time" id="burial_time" class ="form-control form-control-border">
                        </div>
                        <div class="col-md-2">
                            <label for="">Sex</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary5" value = "M" name="sex">
                                    <label for="radioPrimary5">
                                        Male
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="radioPrimary6" value = "F" name="sex">
                                    <label for="radioPrimary6">
                                        Female
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "region" name = "region" style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "province" name = "province" style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">City</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "city" name = "city" style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "barangay" name = "barangay" style="width: 100%;">
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <label for=""><u>Cause of Death</u></label>
                            <div class="form-group clearfix">
                                <div class="form-group ">
                                    <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "causeofdeath" name = "causeofdeath" style="width: 100%;">
                                        <option value="N">NATURAL</option>
                                        <option value="A">ACCIDENT</option>
                                        <option value="H">HOMICIDE</option>
                                        <option value="S">SUICIDE</option>
                                        <option value="U">UNDETERMINED</option>
                                        <option value="O">OTHER</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for=""><u>Other Services</u> </label>
                            <div class="form-group ">
                                <select class="form-control form-control-border  select2-info" data-dropdown-css-class="select2-info" id = "service_id" name = "service_id" style="width: 100%;">
                                
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4" >
                            <label for="">Contact Person</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" onkeydown="return /[a-zA-Z]/i.test(event.key)" name="contactperson" id="contactperson" class="form-control form-control-border">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Relationship</label>
                            <select  class="form-control form-control-border select2-primary"  data-dropdown-css-class="select2-primary" id = "relationship" name = "relationship" style="width: 100%;">
                                <option value="1">SIBLING</option>
                                <option value="2">COUSIN</option>
                                <option value="3">PARENT</option>
                                <option value="4">CHILDREN</option>
                                <option value="5">SPOUSE</option>
                                <option value="6">OTHER</option>
                            </select>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Contact Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="number" name = "contactnumber" class="form-control form-control-border" >
                            </div>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary22" value = "1" name = "sameaddress">
                                        <label for="checkboxPrimary22">Same as above address ?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p></p>
                    <div class="row" id= "contactperson_address">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "region1" name = "region1" style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "province1" name = "province1" style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">City</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "city1" name = "city1" style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "barangay1" name = "barangay1" style="width: 100%;">
                            </select>
                        </div>
                    </div>
                    <p></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id = "btn_save" class="btn btn-primary">Save changes</button>
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
<script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
<script type="text/javascript">
            
    var my_handlers = {

        fill_provinces:  function(){

            var region_code = $(this).val();
            $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);
            
        },

        fill_cities: function(){

            var province_code = $(this).val();
            $('#city').ph_locations( 'fetch_list', [{"province_code": province_code}]);
        },


        fill_barangays: function(){

            var city_code = $(this).val();
            $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
        }
    };

    var my_handlers1 = {

        fill_provinces:  function(){

            var region_code = $(this).val();
            $('#province1').ph_locations('fetch_list', [{"region_code": region_code}]);
            
        },

        fill_cities: function(){

            var province_code = $(this).val();
            $('#city1').ph_locations( 'fetch_list', [{"province_code": province_code}]);
        },


        fill_barangays: function(){

            var city_code = $(this).val();
            $('#barangay1').ph_locations('fetch_list', [{"city_code": city_code}]);
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

        // Contact person address
        $('#region1').on('change', my_handlers1.fill_provinces);
        $('#province1').on('change', my_handlers1.fill_cities);
        $('#city1').on('change', my_handlers1.fill_barangays);

        $('#region1').ph_locations({'location_type': 'regions'});
        $('#province1').ph_locations({'location_type': 'provinces'});
        $('#city1').ph_locations({'location_type': 'cities'});
        $('#barangay1').ph_locations({'location_type': 'barangays'});

        $('#region1').ph_locations('fetch_list');
    });
</script>
<script>
  $(document).ready(function(){


        //Money Euro
    $('[data-mask]').inputmask()
    $("#s_deceaseds").addClass('active');
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    
    $("input[name='sameaddress']").on('click', function(){
        if($(this).prop('checked') == true)
        {
           $("#contactperson_address").hide();
        }
        else
        {
            $("#contactperson_address").show();
        }
    })
    show_allServices();
    show_allBlocks();
    $("#btn_add").on('click', function(){
        $("#modal_form").modal({backdrop:'static', keyboard: false});
    })
   
    function show_allServices()
    {
        $.ajax({
            type: 'get',
            url: "{{ route('get_allServices') }}",
            dataType: 'json',
            success:function(data)
            {
                var row = "<option></option>";
                if(data.length > 0)
                {
                    for(var i = 0; i<data.length; i++)
                    {
                        row += "<option value = "+data[i].id+">"+data[i].service_name.toUpperCase()+"</option>";
                    }
                }
                else
                {
                    row += '<option>No data available.</option>';
                }
                $(".select2-info").html(row);
            },
            error: function()
            {
                alert("System cannot process request.")
            }
        })
    }
    function show_allBlocks()
    {
        $.ajax({
            type: 'get',
            url: "{{ route('spaceareas.get_allBlocks') }}",
            dataType: 'json',
            success:function(data)
            {
                var row = "<option></option>";
                if(data.length > 0)
                {
                    for(var i = 0; i<data.length; i++)
                    {
                        row += "<option value = "+data[i].id+">"+data[i].block_number+" - "+data[i].section_name+"</option>";
                    }
                }
                else
                {
                    row += '<option>No data available.</option>';
                }
                $(".block_id").html(row);
            },
            error: function()
            {
                alert("System cannot process request.")
            }
        })
    }
    $("#cemetery_form").on('submit', function(e){
        e.preventDefault();

        var data = $(this).serializeArray();
        var region_text = $("#region option:selected").text();
        var province_text = $("#province option:selected").text();
        var city_text = $("#city option:selected").text();
        var barangay_text = $("#barangay option:selected").text();

        var region1_text = $("#region1 option:selected").text();
        var province1_text = $("#province1 option:selected").text();
        var city1_text = $("#city1 option:selected").text();
        var barangay1_text = $("#barangay1 option:selected").text();
        console.log(data);
    });
  })
</script>
</body>
</html>
