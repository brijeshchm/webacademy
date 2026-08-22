@extends('admin.layouts.app')
 @section('title')
     Update  
@endsection
@section('content')
	<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Update User - {{ $edit_data->name }}</h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="alert alert-danger hide"></div>
						@if(Session::has('success'))
						<div class="alert alert-success">{{Session::get('success')}}</div>
						@endif
						 
						<div class="x_content">
							<br />
							<form class="form-horizontal form-label-left" role="form" method="POST" action="" onsubmit="return userController.editRegisterSubmit(this,<?php echo $edit_data->id; ?>)">						 
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="name" type="text" name="name" class="form-control col-md-7 col-xs-12" value="{{ $edit_data->name }}">
										
										 
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span> </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="email" class="form-control col-md-7 col-xs-12" name="email" value="{{ $edit_data->email }}">
										
										 
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Phone">Phone<span class="required">*</span> </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" class="form-control col-md-7 col-xs-12" name="mobile" value="{{ $edit_data->mobile }}">									
										 
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="password" class="form-control col-md-7 col-xs-12" name="password" placeholder="****">
										
										 
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password-confirm">Confirm Password </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="password" class="form-control col-md-7 col-xs-12" name="password_confirmation" placeholder="****">
										
										 
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Role<span class="required">*</span> </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<select id="role" class="form-control col-md-7 col-xs-12"  name="role"
										
										<?php //echo (Auth::user()->current_user_can('super_admin')||Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager') )?"name=\"role\"":"disabled"; ?>>
										 
											<?php
											$roles = [											 										
												"administrator"=>"Administrator",
												"manager"=>"Manager",
												"SEO"=>"SEO"
											];
											?>
											 
												
											
											 
											<option value="">Select Role</option>
											@foreach($roles as $key=>$value)
												<option value="{{ $key }}" <?php echo ($key==$edit_data->role)?"selected":""; ?>>{{ $value }}</option>
											@endforeach
										</select>
										 
									</div>
								</div>
								<div class="form-group"> 
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="capabilities">Capabilities<span class="required">*</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
										 							
							 
										$html = "";
										foreach($permissions as $permission){
											$selected = "";
											
											 
											if(in_array($permission->permission,$userCaps,TRUE)){
												$selected = "selected";
											}
											$html.="<option value='$permission->permission' $selected>$permission->permission</option>";
										}  
									 
										?>
										<select id="capabilities" class="form-control chosen-select col-md-7 col-xs-12" multiple name="capabilities[]">
										<?php echo $html; ?>
										</select>
										 
									</div>
								</div>
							 
								 
								<div class="ln_solid"></div>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button type="submit" class="btn btn-success"><i class="fa fa-btn fa-user"></i> Submit</button>
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->
@endsection
