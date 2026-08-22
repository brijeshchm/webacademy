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
	</style>
  </head>
  <body class="login" >
   
   
   
   
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
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email" class="control-label">Mobile</label>
							<input type="hidden" name="mobileOTP" value="1" />
                         
					<select id="mobile" class="form-control mobilehide" name="mobile" onchange="mobileval(this);">
									<option value="">-- Select the mobile --</option>                                    
									<option value="9205323836">9205323836(Brijesh Chauhan)</option>
								 
									 
									 
								</select>
                                
                           
                        </div>
						
						<div class="form-group">
							<div class="text-center col-md-6 col-md-offset-4 color-text">OR</div>
						</div>
						
						<div class="form-group">
							<label for="otp_to_email" class="control-label">Email</label>
                           
				<select id="otp_to_email" class="form-control emailhide" name="otp_to_email" onchange="emailval(this);">
									<option value="">-- Select the email --</option>
									 
									<option value="brijeshchauhan68@gmail.com">brijeshchauhan68@gmail.com</option>
								 
									 
 
								</select>
                            
						</div>
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Submit
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
	
   
    
    
<script>
function mobileval(sel)
{
   var mobile =  (sel.value);
  
   if(mobile !='')
   {	   
	  $('.emailhide').attr("disabled", "disabled"); 
	   
   }else{
	 
	     $('.emailhide').removeAttr("disabled");
   }
}

function emailval(sel)
{
   var mobile =  (sel.value);
 
   if(mobile !='')
   {	   
	  $('.mobilehide').attr("disabled", "disabled"); 
	   
   }else{
	  
	     $('.mobilehide').removeAttr("disabled");
   }
}
</script>
 <script src="{{asset('assests/js/jquery.js')}}"></script>
 

  </body>
</html>
