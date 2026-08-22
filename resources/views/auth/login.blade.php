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
    background-image: url(../image/banner-login.jpg);
    background-size: cover;
}
.help-block{	
	color:red;
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
							
								<h4 style="color:red;" ><h4>
                            </div>
                        </div> 
                    </div>
                    <div class="panel-body">
					@if(count($errors)>0 && $errors->has('generic_err'))
						 <div class="row">
							<div class="col-md-12 col-md-offset-0">
						<div class="alert alert-danger">{{ $errors->first('generic_err') }}</div>
						</div>
						</div>
					@endif
                        <form  method="post"  action="{{url('admin/login')}}" >
						 {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label" for="username">Email </label>
                                <input type="hidden" value="1" name="lgn">
                                <input type="text" placeholder="Enter Email" title="Please enter email" value="" name="email" class="form-control">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" value="" name="password" id="password" class="form-control">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div  style="text-align:center;" >
                                <button class="btn btn-primary" type="submit" value="login" name="submit" >Login</button>
                                
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
