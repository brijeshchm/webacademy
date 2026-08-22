<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">	
<link rel="icon" href="{{asset('favicon.ico')}}" type="image/ico">
<meta name="csrf-token" content="<?php echo csrf_token(); ?>">
<link rel="canonical" href="{{ URL::current() }}"/>	
<title>@yield('title')</title>

<!-- Bootstrap -->
<link href="{{asset('admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
<!-- Font Awesome -->
<link href="{{asset('admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
<!-- NProgress -->
<link href="{{asset('admin/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
<!-- iCheck -->
<link href="{{asset('admin/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
<!-- bootstrap-wysiwyg -->
<link href="{{asset('admin/vendors/google-code-prettify/bin/prettify.min.css')}}" rel="stylesheet">
<!-- Select2 -->
<link href="{{asset('admin/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('admin/vendors/select2/dist/css/select2-bootstrap.css')}}" rel="stylesheet">
<!-- Switchery -->
<link href="{{asset('admin/vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet">
<!-- starrr -->
<link href="{{asset('admin/vendors/starrr/dist/starrr.css')}}" rel="stylesheet">
<!-- bootstrap-daterangepicker -->  

<link href="{{asset('admin/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
<link href="{{asset('admin/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
 <link href="{{asset('admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('admin/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('admin/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

<!-- Custom Theme Style -->
<link href="{{asset('admin/build/css/custom.css')}}" rel="stylesheet">
</head>

<body class="nav-md">
	 <div id="spinnerBkgd"></div>
<div id="spinnerCntr"></div>
<div class="container body">
  <div class="main_container">
	<div class="col-md-3 left_col">
	  @include('admin.layouts.sidebar')
	  
	</div>

	<!-- top navigation -->
	<div class="top_nav">
	  <div class="nav_menu">
		<nav>
		  <div class="nav toggle">
			<a id="menu_toggle"><i class="fa fa-bars"></i></a>
		  </div>

		  <ul class="nav navbar-nav navbar-right">
			<li class="">
			  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<img src="{{asset('admin/images/user.png')}}" alt=""><?php if(Auth::user()->name){ echo  Auth::user()->name; } ?>
				<span class=" fa fa-angle-down"></span>
			  </a>
			  <ul class="dropdown-menu dropdown-usermenu pull-right">
			   <li><a href="{{ url('/admin/profile') }}"> Profile</a></li>   
				<li><a href="{{ url('/admin/change-password') }}">Change Password</a></li>   
				<li><a href="{{ url('/admin/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
			  </ul>
			</li>

			 
		  </ul>
		</nav>
	  </div>
	</div>
	<!-- /top navigation -->

	<!-- page content -->
	 @yield('content')
	<!-- /page content -->
		<div id="successMessageId" class="modal fade" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h5 class="modal-title">Payment List</h5>
		

		</div>
		<div class="modal-body" style="padding-top:5px">
		</div>

		</div>

		</div>
		</div>
	<!-- footer content -->
	<footer>
	  <div class="pull-right">
	   Developed by <a href="estival.com">estival</a>
	  </div>
	  <div class="clearfix"></div>
	</footer>
	<!-- /footer content -->
  </div>
</div>

<!-- jQuery -->
<script src="{{asset('admin/vendors/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('admin/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('admin/vendors/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('admin/vendors/nprogress/nprogress.js')}}"></script>
<!-- bootstrap-progressbar -->
<script src="{{asset('admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('admin/vendors/iCheck/icheck.min.js')}}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{asset('admin/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{asset('admin/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<!-- bootstrap-wysiwyg -->
<script src="{{asset('admin/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js')}}"></script>
<script src="{{asset('admin/vendors/jquery.hotkeys/jquery.hotkeys.js')}}"></script>
<script src="{{asset('admin/vendors/google-code-prettify/src/prettify.js')}}"></script>
<!-- jQuery Tags Input -->
<script src="{{asset('admin/vendors/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
<!-- Switchery -->
<script src="{{asset('admin/vendors/switchery/dist/switchery.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('admin/vendors/select2/dist/js/select2.full.min.js')}}"></script>
<!-- Parsley -->
<script src="{{asset('admin/vendors/parsleyjs/dist/parsley.min.js')}}"></script>
<!-- Autosize -->
<script src="{{asset('admin/vendors/autosize/dist/autosize.min.js')}}"></script>
<!-- jQuery autocomplete -->
<script src="{{asset('admin/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
<!-- starrr -->
<script src="{{asset('admin/vendors/starrr/dist/starrr.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{asset('admin/build/js/custom.min.js')}}"></script>

<script src="{{asset('admin/vendors/iCheck/icheck.min.js')}}"></script>
<!-- Datatables -->
<script src="{{asset('admin/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('admin/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('admin/vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{asset('admin/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{asset('admin/vendors/spinner/spin.min.js')}}"></script>  
 <script src="{{asset('admin/build/js/script.js')}}"></script>		 
<script>
$(document).ready(function () {
	$('.start_date').datetimepicker({
	format: 'YYYY-MM-DD'
	}); 
	$('.start_time').datetimepicker({
	format: 'hh:mm A'
});	
});     
</script>

 
</body>
</html>
