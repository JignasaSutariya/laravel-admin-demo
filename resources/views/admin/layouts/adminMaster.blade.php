<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title> @yield('title') Zayfy</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ URL::asset('resources/assets/img/favicon-16x16.png')}}" />
@include('admin.layouts.adminCss')
@yield('css')
<script>
$(document).ready(function(){
  var SITE_URL = "<?php echo URL::to('/'); ?>";
  $(".sidebar-toggle").click(function (e) {
      e.preventDefault();
      $.ajax({
        url: SITE_URL + '/setsidecookie',
        type: 'GET',
        dataType: 'html',
        data: "",
        success: function (data) {
        }
    });
  });
});
</script>
</head>
<?php
    $sidebarClass = "";
    if (isset($_COOKIE['sidebar-collapse']) && $_COOKIE['sidebar-collapse'] == "no") {
        $sidebarClass = "sidebar-collapse";
    }else{
        $sidebarClass = "";
    }
?>
<body class="hold-transition skin-black sidebar-mini <?php echo $sidebarClass; ?>">
    <div class="wrapper">
        @include('admin.layouts.adminHeader')
        @include('admin.layouts.adminSidebar')
        @yield('content')
        @include('admin.layouts.adminFooter')
    </div>
    @include('admin.layouts.adminJS')
    @yield('script')
</body>
</html>
