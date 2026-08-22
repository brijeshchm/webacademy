<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="{{asset('admin/images/favicon.png')}}" type="image/ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login </title>   
    <link href="{{asset('admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">  
    <link href="{{asset('admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"> 
    <link href="{{asset('admin/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendors/animate.css/animate.min.css')}}" rel="stylesheet">   
    <link href="{{asset('admin/build/css/custom.min.css')}}" rel="stylesheet">
 
	
	<style>
	.login{
    background-image: url(../image/banner-login.png);
    background-size: cover;
}
.help-block{	
	color:red;
}
	</style>
  </head>
  <body >
  
   <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form" style="margin-top: 40px;">
          <section class="">          
			
			<div class="panel-body">
                        <div class="login-wrapper loginpwd">
           
            <div class="container-center">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="view-header" style="text-align: center;">
                            <div class="header-icon">
							
                            </div>
                            <div class="header-title" style="margin-left:0px;">
							<img src="{{asset('/image/svg/logo.svg')}}" style="width:90px;margin:auto" >
								<h4 style="color:red;" ><h4>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                       <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/otp') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="otp" class="control-label">OTP</label>                   
                                <input id="otp" type="otp" class="form-control" name="otp" placeholder="Enter OTP Four Digit">
								@if ($errors->has('otp'))
									<span class="help-block">
										<strong>{{ $errors->first('otp') }}</strong>
									</span>
								@endif

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Secure Login
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
                    </div>
          </section>
		  
		  
		  
		  
        </div>

        
      </div>
	  
	  
    </div>
  
   

	
  </body>
</html>
