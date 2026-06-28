<?php use Carbon\Carbon; ?>

<?php
  $tm = Carbon::today();
  $ts = new Carbon('2017-04-21');
  $interval = $tm->diff($ts);
  $interval =  $interval->format('%a');
  if($interval > 0){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="icon" href="{{ ('img/favicon.ico') }}">
    <title>Login | Merak CBT</title>

    <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
    <link href="{!! url('css/login.css') !!}" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('/assets/mdl/material.min.css') }}">
    <script src="{{ url('/assets/mdl/material.min.js') }}"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  </head>
  <body>
    <div class="container">
    	@yield('content')
	</div>
	<script src="{{ url('/assets/assets/vendor/jquery.min.js') }}"></script>
  <script src="{{ url('lib/bootstrap/js/bootstrap.js') }}"></script>
  <script src="{{ url('/js/jquery.backstretch.min.js') }}"></script>
  <script>
    // $.backstretch("{{ url('/img/bg2.jpg') }}", {speed: 150});
    
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
  </body>
</html>

<?php }else{ ?>
  <script>
    window.location.href = "{{ url('/exp') }}";
  </script>
<?php } ?>