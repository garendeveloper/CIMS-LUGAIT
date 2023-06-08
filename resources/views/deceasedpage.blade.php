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
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4>Manage Deceaseds <span class = "badge badge-sm badge-success" id = "no_ofrecords">0</span></h4>
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
                        <button class = "btn btn-danger" id = "btn_add"><i class = "fa fa-user-injured"></i> &nbsp;&nbsp;Add New Deceased</button>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class = "form-control" style ="text-transform: uppercase" placeholder = "Search Record Here" id = "search">
                        </div>
                    </div>
                </div>
              </div>
              <style>
                table, td, th{
                    border: 1px solid #170036;
                }
                /* table{
                    border-collapse: collapse;
                    width: 100%;
                }
                th{
                    height: 30px;
                } */
              </style>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_deceaseds"  class="table table-stripped table-bordered">
                  <thead style = "background-color: #170036; color: white">
                    <tr>
                        <th>Full Name (L,M,F)</th>
                        <th>Address</th>
                        <th>Date of Burial</th>
                        <th>Sex</th>
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

  <div class="modal"  id="modal_form">
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
                <input type="hidden" name="cemetery_id" id = "cemetery_id" value = "">
                <div class="modal-body">
                    <h5 style = "color: red;"><b>Deceased Information</b> </h5><p></p>
                    <div class="row" >
                        <div class="col-md-3" >
                            <label for="">Last Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" 
                                onkeydown="return /[a-zA-Z ]/i.test(event.key)"
                                name="lastname" id="lastname" class="form-control form-control-border">
                            </div>
                            <span style = "color: red" class = "span" id = "sp_lastname"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Middle Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" onkeydown="return /[a-zA-Z ]/i.test(event.key)" name="middlename" id="middlename" class="form-control form-control-border">
                            </div>
                            <span style = "color: red" class = "span" id = "sp_middlename"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">First Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" onkeydown="return /[a-zA-Z ]/i.test(event.key)" name="firstname" id="firstname" class="form-control form-control-border">
                            </div>
                            <span style = "color: red" class = "span" id = "sp_firstname"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Suffix</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "suffix" name = "suffix" style="width: 100%;">
                                <option value="">-- Please select here</option>
                                <option value="N">NONE</option>
                                <option value="SR">SR</option>
                                <option value="JR">JR</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="VI">VI</option>
                                <option value="VII">VII</option>
                                <option value="VIII">VIII</option>
                                <option value="IX">IX</option>
                                <option value="X">X</option>
                            </select>
                            <span style = "color: red" class = "span" id = "sp_suffix"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Date of Birth</label>
                            <input type="date" name="dateofbirth" id="dateofbirth" class="form-control form-control-border">
                            <span style = "color: red" class = "span" id = "sp_dateofbirth" ></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Date of Burial</label>
                            <input type="date" name="dateof_burial" id="dateof_burial" class="form-control form-control-border">
                            <span style = "color: red" class = "span" id = "sp_dateofburial"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Time</label>
                            <input type="time" name="burial_time" id="burial_time" class ="form-control form-control-border">
                            <span style = "color: red" class = "span" id = "sp_burialtime"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Sex</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary5" value = "M" id = "sex" name="sex">
                                    <label for="radioPrimary5">
                                        Male
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="radioPrimary6" value = "F" id = "sex" name="sex">
                                    <label for="radioPrimary6">
                                        Female
                                    </label>
                                </div>
                            </div>
                            <span style = "color: red" class = "span" id = "sp_sex"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "region" name = "region" style="width: 100%;">
                                
                            </select>
                            <span style = "color: red" class = "span" id = "sp_region"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "province" name = "province" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_province"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">City / Municipality</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "city" name = "city" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_city"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "barangay" name = "barangay" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_barangay"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-4">
                            <label for=""><u>Cause of Death</u></label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "causeofdeath" name = "causeofdeath" style="width: 100%;">
                                <option value="">-- Please select here</option>
                                <option value="N">NATURAL</option>
                                <option value="A">ACCIDENT</option>
                                <option value="H">HOMICIDE</option>
                                <option value="S">SUICIDE</option>
                                <option value="U">UNDETERMINED</option>
                                <option value="O">OTHER</option>
                            </select>
                            <span style = "color: red" class = "span" id = "sp_causeofdeath"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="">Date of Death</label>
                            <input type="date" name="dateof_death" id="dateof_death" class="form-control form-control-border">
                            <span style = "color: red" class = "span" id = "sp_dateofdeath"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="">Marital Status</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" value = "S" id = "civilstatus" name="civilstatus">
                                    <label for="radioPrimary1">
                                        Single
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="radioPrimary2"  value = "M" id = "civilstatus" name="civilstatus">
                                    <label for="radioPrimary2">
                                        Married
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="radioPrimary3" value = "W" id = "civilstatus" name="civilstatus">
                                    <label for="radioPrimary3">
                                        Widowed
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="radioPrimary4" value = "D" id = "civilstatus" name="civilstatus">
                                    <label for="radioPrimary4">
                                        Divorced
                                    </label>
                                </div>
                            </div>
                            <span style = "color: red" class = "span" id = "sp_civilstatus"></span>
                        </div>
                    </div>
                    <p></p>
                    <h5 style = "color: green"><b>Contact Person Information</b> </h5><p></p>
                    <div class="row" >
                        <div class="col-md-4" >
                            <label for="">Contact Person</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" onkeydown="return /[a-zA-Z, ]/i.test(event.key)" name="contactperson" id="contactperson" class="form-control form-control-border">
                            </div>
                            <span style = "color: red" class = "span" id = "sp_contactperson"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="">Relationship to the Deceased</label>
                            <select  class="form-control form-control-border select2-primary"  data-dropdown-css-class="select2-primary" id = "relationship" name = "relationship" style="width: 100%;">
                                <option value="">-- Please select here</option>
                                <option value="1">SIBLING</option>
                                <option value="2">COUSIN</option>
                                <option value="3">PARENT</option>
                                <option value="4">CHILDREN</option>
                                <option value="5">SPOUSE</option>
                                <option value="6">OTHER</option>
                            </select>
                            <span style = "color: red" class = "span" id = "sp_relationship"></span>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Contact Number (<i>Ex. 9303087678</i>)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i>&nbsp; +63</span>
                                </div>
                                <input type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" id = "contactnumber" name = "contactnumber" class="form-control form-control-border" >
                            </div>
                            <span style = "color: red" class = "span" id = "sp_contactnumber"></span>
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
                                    <input type="hidden" id = "check_sameaddress" name = "check_sameaddress" value = "0">
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
                            <span style = "color: red" class = "span" id = "sp_region1"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "province1" name = "province1" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_province1"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">City</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "city1" name = "city1" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_city1"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "barangay1" name = "barangay1" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_barangay1"></span>
                        </div>
                    </div>
                    <p></p>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary25" value = "1" name = "add_contactperson">
                                        <label for="checkboxPrimary25" style = "color: darkviolet; font-size: 15px">Check to add other contact person.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id = "other_contactperson" style = "display: none">
                        <h5 style = "color: green"><b>Other Contact Person </b> </h5><p></p>
                        <div class="row" >
                            <div class="col-md-4" >
                                <label for="">Contact Person</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" autocomplete = "off" onkeydown="return /[a-zA-Z ]/i.test(event.key)" name="contactperson1" id="contactperson1" class="form-control form-control-border">
                                </div>
                                <span style = "color: red" class = "span" id = "sp_contactperson1"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">Relationship to the Deceased</label>
                                <select  class="form-control form-control-border select2-primary"  data-dropdown-css-class="select2-primary" id = "relationship1" name = "relationship1" style="width: 100%;">
                                    <option value="">-- Please select here</option>
                                    <option value="1">SIBLING</option>
                                    <option value="2">COUSIN</option>
                                    <option value="3">PARENT</option>
                                    <option value="4">CHILDREN</option>
                                    <option value="5">SPOUSE</option>
                                    <option value="6">OTHER</option>
                                </select>
                                <span style = "color: red" class = "span" id = "sp_relationship1"></span>
                            </div>
                            <div class="col-md-4" >
                                <label for="">Contact Number (<i>Ex. 9303087678</i>)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i>&nbsp; +63</span>
                                    </div>
                                    <input type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" id = "contactnumber1" name = "contactnumber1" class="form-control form-control-border" >
                                </div>
                                <span style = "color: red" class = "span" id = "sp_contactnumber1"></span>
                            </div>
                        </div>
                        <p></p>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="checkboxPrimary23" value = "1" name = "sameaddress1">
                                            <label for="checkboxPrimary23">Same as deceased address ?
                                        </label>
                                        <input type="hidden" id = "check_sameaddress1" name = "check_sameaddress1" value = "0">
                                    </div>
                                </div>
                            </div>
                            <p></p>
                            <div class="row" id= "contactperson_address1">
                                <div class="col-md-3">
                                    <label for="">Region</label>
                                    <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "region2" name = "region2" style="width: 100%;">
                                    </select>
                                    <span style = "color: red" class = "span" id = "sp_region2"></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Province</label>
                                    <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "province2" name = "province2" style="width: 100%;">
                                    </select>
                                    <span style = "color: red" class = "span" id = "sp_province2"></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">City</label>
                                    <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "city2" name = "city2" style="width: 100%;">
                                    </select>
                                    <span style = "color: red" class = "span" id = "sp_city2"></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Barangay</label>
                                    <select class="form-control form-control-border select2-primary" data-dropdown-css-class="select2-primary" id = "barangay2" name = "barangay2" style="width: 100%;">
                                    </select>
                                    <span style = "color: red" class = "span" id = "sp_barangay2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="submit" id = "btn_save" class="btn btn-primary btn-block"><i class = "fas fa fa-save"></i> Save changes</button>
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
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
<script type = "text/javascript">
    $(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;    
    $('#dateofbirth').attr('max', maxDate);
    $('#dateof_death').attr('max', maxDate);
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

    var my_handlers1 = {

        fill_provinces:  function(){
            $("#city1").html("");
            $("#barangay1").html("");
            var region_code = $(this).val();
            $('#province1').ph_locations('fetch_list', [{"region_code": region_code}]);
            
        },

        fill_cities: function(){
            $("#barangay1").html("");
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token':$("input[name=_token").val()
        }
    }) 
    show_allData();
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbl_deceaseds tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    var _token = $('input[name="_token"]').val();
        //Money Euro
    $('[data-mask]').inputmask()
    $("#s_deceaseds").addClass('active');
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    var haschecked = 0;
    var haschecked1 = 0;
    $("input[name='sameaddress']").on('click', function(){
       
        if($(this).prop('checked') == true)
        {
            haschecked  = 1;
           $("#contactperson_address").hide();
        }
        else
        {
           haschecked = 0;
            $("#contactperson_address").show();
        }
        $("#check_sameaddress").val(haschecked);
    })
    $("input[name='sameaddress1']").on('click', function(){
       
       if($(this).prop('checked') == true)
       {
           haschecked1  = 1;
          $("#contactperson_address1").hide();
       }
       else
       {
          haschecked1 = 0;
           $("#contactperson_address1").show();
       }
       $("#check_sameaddress1").val(haschecked1);
   })
   var addcontact_person = 0;
   $("input[name='add_contactperson']").on('click', function(){
        if($(this).prop('checked') == true)
        {
            $("#other_contactperson").show();
            addcontactperson = 1;
        }
        else
        {
            $("#other_contactperson").hide();
            addcontactperson = 0;
        }
   })
    show_allServices();
    show_allBlocks();
    $("#btn_add").on('click', function(){
        $("#cemetery_form").trigger('reset');
        $("#cemetery_id").val("");
        $('input[type="radio"]').prop('checked', false);
        $("select").val("");
        $('#region').ph_locations('fetch_list');
        $('#region1').ph_locations('fetch_list');
        $("#modal_form").modal({backdrop:'static', keyboard: false});
    })
    function show_allData()
    {
        $.ajax({
        type: 'get',
        url: "{{ route('deceaseds.get_allData') }}",
        dataType: 'json',
        success:function(data)
        {
            var row = "";
            $("#no_ofrecords").text(data.length + " Records");
            if(data.length > 0)
            {
                for(var i = 0; i<data.length; i++)
                {
                    row += '<tr data-id = '+data[i].deceased_id+' style = "text-transform: uppercase">';
                    row += '<td>'+data[i].lastname+", "+data[i].middlename+", "+data[i].firstname+'</td>';
                    row += '<td>'+data[i].barangay+", "+data[i].city+", "+data[i].province+" "+data[i].region+'</td>';
                    row += '<td>'+data[i].dateof_burial+'</td>';
                    row += '<td>'+data[i].sex+'</td>';
                    row += '<td><span class = "badge badge-danger right"> '+data[i].service_name+'</span></td>';
                    row += '<td align = "center">';
                    row += '<button data-id = '+data[i].deceased_id+' id = "btn_assign" type="button" class="btn btn-primary btn-sm btn-flat">';
                    row += '<i class = "fa fa-building"></i>';
                    row += '</button>';
                    row += '<button data-id = '+data[i].deceased_id+' id = "btn_edit" type="button" class="btn btn-success btn-sm btn-flat">';
                    row += '<i class = "fa fa-edit"></i>';
                    row += '</button>';
                    row += '<button data-id = '+data[i].deceased_id+' id = "btn_info" type="button" class="btn btn-primary btn-sm btn-flat">';
                    row += '<i class = "fa fa-info"></i>';
                    row += '</button>';
                    row += '<button data-id = '+data[i].deceased_id+' id = "btn_remove" type="button" class="btn btn-danger btn-sm btn-flat">';
                    row += '<i class = "fas fa fa-trash"></i>';
                    row += '</button></td>';
                    row += '</tr>';
                }
            }
            else
            {
                row += '<tr style = "text-transform: uppercase"><td colspan = "8">No data available</td></tr>';
            }
            $("#tbl_deceaseds tbody").html(row);
        },
        error: function()
        {
            alert("System cannot process request.")
        }
        })
    }
    $("#tbl_deceaseds tbody").on('click', '#btn_edit', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: "/deceaseds/show/"+id,
            dataType: 'json',
            success:function(data)
            {
                $("#cemetery_id").val(id);
                $("#lastname").val(data[0][0].lastname)
                $("#middlename").val(data[0][0].middlename)
                $("#firstname").val(data[0][0].firstname)
                $("#suffix").val(data[0][0].suffix)
                $("#dateof_death").val(data[0][0].dateof_death)
                $("#dateofbirth").val(data[0][0].dateofbirth)
                $("input[name='civilstatus'][value="+data[0][0].civilstatus+"]").attr('checked', true)
                $("#dateof_burial").val(data[0][0].dateof_burial)
                $("#burial_time").val(data[0][0].burial_time)
                $("input[name='sex'][value="+data[0][0].sex+"]").attr('checked', true)
                
                //PINAHIRAPAN MO AKO
            
                $("#region option").filter(function() {
                    return $(this).val() == data[0][0].region_no;
                }).attr('selected', true);

                $("#province").prepend("<option selected='selected' value = "+data[0][0].province_no+">"+data[0][0].province+"</option>");
                $("#city").prepend("<option selected='selected' value = "+data[0][0].city_no+">"+data[0][0].city+"</option>");
                $("#barangay").prepend("<option selected='selected' value = "+data[0][0].barangay_no+">"+data[0][0].barangay+"</option>");
             
                $("#causeofdeath option").filter(function() {
                    return $(this).val() == data[0][0].causeofdeath;
                }).attr('selected', true);
                $("#contactperson").val(data[2][0].name),
                $("#relationship option").filter(function() {
                    return $(this).val() == data[0][0].relationship;
                }).attr('selected', true);
                $("#contactnumber").val(data[2][0].contactnumber);

                $("#region1 option").filter(function() {
                    return $(this).val() == data[2][0].region_no;
                }).attr('selected', true);

                $("#province1").prepend("<option selected='selected' value = "+data[2][0].province_no+">"+data[2][0].province+"</option>");
                $("#city1").prepend("<option selected='selected' value = "+data[2][0].city_no+">"+data[2][0].city+"</option>");
                $("#barangay1").prepend("<option selected='selected' value = "+data[2][0].barangay_no+">"+data[2][0].barangay+"</option>");
                $("#modal_form").modal({
                    'backdrop': 'static',
                    'keyboard': false
                })
            },
            error: function()
            {
                alert("System cannot process request.")
            }
        })
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
        $("#pageloader").show();
        var data = $(this).serialize();
        var region_text = $("#region option:selected").text();
        var province_text = $("#province option:selected").text();
        var city_text = $("#city option:selected").text();
        var barangay_text = $("#barangay option:selected").text();

        var region_text1 = $("#region1 option:selected").text();
        var province_text1 = $("#province1 option:selected").text();
        var city_text1 = $("#city1 option:selected").text();
        var barangay_text1 = $("#barangay1 option:selected").text();

        var region_text2 = $("#region2 option:selected").text();
        var province_text2 = $("#province2 option:selected").text();
        var city_text2 = $("#city2 option:selected").text();
        var barangay_text2 = $("#barangay2 option:selected").text();
        
        var sameaddress = "";
        $("input[type='text']").removeClass('is-invalid');
        $("input[type='radio']").removeClass('is-invalid');
        $("input[type='checkbox']").removeClass('is-invalid');
        $("input[type='date']").removeClass('is-invalid');
        $("input[type='number']").removeClass('is-invalid');
        $(".select2-primary").removeClass('is-invalid');
        $(".select2-info").removeClass('is-invalid');
        $(".span").html("");

            $.ajax({
                type: 'post',
                url: '{{ route("deceaseds.store") }}',
                data: {
                    lastname: $("#lastname").val(),
                    middlename: $("#middlename").val(),
                    firstname: $("#firstname").val(),
                    suffix: $("#suffix").val(),
                    dateof_death: $("#dateof_death").val(),
                    dateofbirth: $("#dateofbirth").val(),
                    civilstatus: $("input[name='civilstatus']:checked").val(),
                    dateof_burial: $("#dateof_burial").val(),
                    burial_time: $("#burial_time").val(),
                    sex: $("input[name='sex']:checked").val(),
                    region: $("#region").val(),
                    province: $("#province").val(),
                    city: $("#city").val(),
                    barangay: $("#barangay").val(),
                    causeofdeath: $("#causeofdeath").val(),
                    // service_id: $("#service_id").val(),
                    contactperson: $("#contactperson").val(),
                    relationship: $("#relationship").val(),
                    contactnumber: $("#contactnumber").val(),
                    region1: $("#region1").val(),
                    province1: $("#province1").val(),
                    city1: $("#city1").val(),
                    barangay1: $("#barangay1").val(),
                    region_text: region_text,
                    province_text: province_text,
                    city_text: city_text,
                    barangay_text: barangay_text,
                    region_text1: region_text1,
                    province_text1: province_text1,
                    city_text1: city_text1,
                    barangay_text1: barangay_text1,
                    sameaddress: haschecked,

                    contactperson1: $("#contactperson1").val(),
                    relationship1: $("#relationship1").val(),
                    contactnumber1: $("#contactnumber1").val(),
                    region2: $("#region2").val(),
                    province2: $("#province2").val(),
                    city2: $("#city2").val(),
                    barangay2: $("#barangay2").val(),
                    region_text2: region_text2,
                    province_text2: province_text2,
                    city_text2: city_text2,
                    barangay_text2: barangay_text2,
                    sameaddress1: haschecked1,
                    addcontactperson: addcontact_person,
                },
                dataType: 'json',
                success: function(response){
                    if(response.status == 1)
                    {
                        show_allBlocks();
                        show_allData();
                        $("input[type='text']").removeClass('is-invalid');
                        $("input[type='radio']").removeClass('is-invalid');
                        $("input[type='checkbox']").removeClass('is-invalid');
                        $("input[type='date']").removeClass('is-invalid');
                        $("input[type='number']").removeClass('is-invalid');
                        $(".select2-primary").removeClass('is-invalid');
                        $(".select2-info").removeClass('is-invalid');
                        $(".span").html("");
                        $("#modal_form").modal('hide');
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
                         $.each(response.message, function(key, value){
                            if(key == "lastname")
                            {
                                $("#sp_lastname").text(value);
                                $("#lastname").addClass('is-invalid');
                            }
                            else  if(key == "firstname")
                            {
                                $("#sp_firstname").text(value);
                                $("#firstname").addClass('is-invalid');
                            }
                            else if(key == "middlename")
                            {
                                $("#sp_middlename").text(value);
                                $("#middlename").addClass('is-invalid');
                            }
                            else if(key == "suffix")
                            {
                                $("#sp_suffix").text(value);
                                $("#suffix").addClass('is-invalid');
                            }
                            else if(key == "dateof_death")
                            {
                                $("#sp_dateofdeath").text(value);
                                $("#dateof_death").addClass('is-invalid');
                            }
                            else if(key == "dateofbirth")
                            {
                                $("#sp_dateofbirth").text(value);
                                $("#dateofbirth").addClass('is-invalid');
                            }
                            else if(key == "civilstatus")
                            {
                                $("#sp_civilstatus").text(value);
                                $("#civilstatus").addClass('is-invalid');
                            }
                            else if(key == "dateof_burial")
                            {
                                $("#sp_dateofburial").text(value);
                                $("#dateof_burial").addClass('is-invalid');
                            }
                            else if(key == "burial_time")
                            {
                                $("#sp_burialtime").text(value);
                                $("#burial_time").addClass('is-invalid');
                            }
                            else if(key == "sex")
                            {
                                $("#sp_sex").text(value);
                                $("#sex").addClass('is-invalid');
                            }
                            else if(key == "region")
                            {
                                $("#sp_region").text(value);
                                $("#region").addClass('is-invalid');
                            }
                            else if(key == "province")
                            {
                                $("#sp_province").text(value);
                                $("#province").addClass('is-invalid');
                            }
                            else if(key == "city")
                            {
                                $("#sp_city").text(value);
                                $("#city").addClass('is-invalid');
                            }
                            else if(key == "barangay")
                            {
                                $("#sp_barangay").text(value);
                                $("#barangay").addClass('is-invalid');
                            }
                            else if(key == "causeofdeath")
                            {
                                $("#sp_causeofdeath").text(value);
                                $("#causeofdeath").addClass('is-invalid');
                            }
                            else if(key == "service_id")
                            {
                                $("#sp_service").text(value);
                                $("#service_id").addClass('is-invalid');
                            }
                            else if(key == "contactperson")
                            {
                                $("#sp_contactperson").text(value);
                                $("#contactperson").addClass('is-invalid');
                            }
                            else if(key == "contactnumber")
                            {
                                $("#sp_contactnumber").text(value);
                                $("#contactnumber").addClass('is-invalid');
                            }
                            else if(key == "relationship")
                            {
                                $("#sp_relationship").text(value);
                                $("#relationship").addClass('is-invalid');
                            }
                            else if(key == "region1")
                            {
                                $("#sp_region1").text(value);
                                $("#region1").addClass('is-invalid');
                            }
                            else if(key == "province1")
                            {
                                $("#sp_province1").text(value);
                                $("#province1").addClass('is-invalid');
                            }
                            else if(key == "city1")
                            {
                                $("#sp_city1").text(value);
                                $("#city1").addClass('is-invalid');
                            }
                            else if(key == "barangay1")
                            {
                                $("#sp_barangay1").text(value);
                                $("#barangay1").addClass('is-invalid');
                            }

                            else if(key == "contactperson1")
                            {
                                $("#sp_contactperson1").text(value);
                                $("#contactperson1").addClass('is-invalid');
                            }
                            else if(key == "contactnumber1")
                            {
                                $("#sp_contactnumbe1r").text(value);
                                $("#contactnumber1").addClass('is-invalid');
                            }
                            else if(key == "relationship1")
                            {
                                $("#sp_relationship1").text(value);
                                $("#relationship1").addClass('is-invalid');
                            }
                            else if(key == "region2")
                            {
                                $("#sp_region2").text(value);
                                $("#region2").addClass('is-invalid');
                            }
                            else if(key == "province2")
                            {
                                $("#sp_province2").text(value);
                                $("#province2").addClass('is-invalid');
                            }
                            else if(key == "city2")
                            {
                                $("#sp_city2").text(value);
                                $("#city2").addClass('is-invalid');
                            }
                            else if(key == "barangay2")
                            {
                                $("#sp_barangay2").text(value);
                                $("#barangay2").addClass('is-invalid');
                            }
                            else
                            {
                                
                            }
                    });
                    }
                    else
                    {
                        alert(response.message);
                    }
                },
                complete: function(response){
                    $("#preloader").hide();
                },
                error: function(response)
                {
                    alert("Sorry for inconvenient cannot process the request.");
                }
            });
      
    });
  })
</script>
</body>
</html>
