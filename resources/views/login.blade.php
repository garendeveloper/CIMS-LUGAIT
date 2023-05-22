<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CEMETERY</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html"><b>LUGAIT </b>CEMETERY IS</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <input type="hidden" value="{{ csrf_token() }}">
        <div class="input-group mb-3">
          <input type="email" name = "email" id = "email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name = "password" id = "password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="button" id = "btn_signin" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div><br>
        <ul id = "validation-errors" style = "color: red">

        </ul>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<script type = "text/javascript">
    $(document).ready(function(){
       $("#btn_signin").on('click', function(){
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
                window.location.href = "{{ route('managers.dashboard') }}";
              }
              else if(response.status == 2)
              {
                $("#validation-errors").html("");
                $.each(response.message, function(key,value) {
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
