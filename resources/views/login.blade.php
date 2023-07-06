<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CEMETERY</title>

  @include('references/links')

</head>
<style>
  body{
  background: url("/dist/img/lugait-map.png") no-repeat center fixed;
  background-size: cover;
}

</style>
<body class="hold-transition login-page">
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="card animated flash infinite">
    <div class="card-body login-card-body">
      <div class="login-logo" >
        <!-- <img src="{{ asset('/assets/img/logos/calvarylogo.png') }}" style = "width: 120px; height: 120px" alt=""> -->
        <img src="{{ asset('/assets/img/logos/Lugait.png') }}" style = " background-size: cover; " alt="">
      </div>
      <h5 class="login-box-msg">MEEDO USER LOGIN</h5>

      <form action="" id = "login_form" method="post">
        <input type="hidden" value="{{ csrf_token() }}">
        <div class="input-group mb-3">
          <input type="email" name = "email" id = "email" class="form-control" placeholder="Email" autocomplete = "off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name = "password" id = "password" class="form-control" placeholder="Password" autocomplete = "off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if(Session::has('NotFound'))
          <div class="input-group mb-3">
            <span style = "color: red; delay: 3000">{{ Session::get('NotFound')}} </span>
          </div>
        @endif
        <ul id = "validation-errors" style = "color: red">

        </ul>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" id = "btn_signin" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div><br>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Include the Google Maps API library - required for embedding maps -->

<script type = "text/javascript">
  $(document).ready(function() {
       $("#login_form").on('submit', function(e){
         e.preventDefault();
         var email = $("#email").val();
         var password = $("#password").val();

         $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '{{ route("user.login") }}',
            data: {
                email: email,
                password: password,
                "_token": "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(response)
            {
              if(response.status == 1)
              {
                alert(response.message)
                window.location.href = "{{ route('managers.dashboard') }}";
              }
              else if(response.status == 2)
              {
                $("#validation-errors").html("");
                $("input[type='text']").removeClass('is-invalid');
                $.each(response.message, function(key,value) {
                    if(key == "email")
                    {
                      $("input[name='email']").addClass('is-invalid');
                    }
                    if(key == "password")
                    {
                      $("input[name='password']").addClass('is-invalid');
                    }
                    $('#validation-errors').append("<li>"+value+"</li>");
                }); 
              }
              else{
                $("#validation-errors").html("");
                $("#validation-errors").html("<li>"+response.message+"</li>");
              }
            },
            error: function(resp)
            {
                alert("Something went wrong!")
            }
         })
       })
    })
</script>
</body>
</html>
