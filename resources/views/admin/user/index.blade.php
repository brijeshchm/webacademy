@extends('admin.layouts.app')
@section('title')
User
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
			<div class="page-title">
			<div class="title_left">
			<h3>Users</h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
			<a href="{{url('admin/users/add')}}"  class="btn btn-info"> Add User</a>

			</div>
			</div>
			</div>
			</div>
            <div class="clearfix"></div>
				 @if(Request::segment(3)=='add'  || Request::segment(3)=='edit'  )
			 <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">                    
                    <form class="form-horizontal form-label-left" autocomplete="off" action=""  onsubmit="return userController.registerSubmit(this)" > 

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="name" value="" placeholder="Enter name" >
                        </div>
                      </div>   

					  
					   <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="email" value="" placeholder="Enter Email" >
                        </div>
                      </div>   
					  
					    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="mobile" value="" placeholder="Enter Phone" >
                        </div>
                      </div>  
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input id="password" type="password" class="form-control col-md-7 col-xs-12" placeholder="*******" name="password" autocomplete="off">						 
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="password-confirm">Confirm Password <span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input id="password-confirm" type="password" class="form-control col-md-7 col-xs-12" placeholder="******" name="password_confirmation" autocomplete="off">							 
							</div>
						</div>
					  
						<div class="form-group">
						<label class="control-label col-md-2 col-sm-3 col-xs-12" for="role">Role <span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12">
						<select id="role" class="form-control col-md-7 col-xs-12 rolemanage" name="role">
						<option value="">Select Role</option> 											 
						<option value="administrator" @if ("administrator"== old('role')) selected="selected" @endif>Administrator</option>											 
						<option value="manager" @if ("manager"== old('role')) selected="selected" @endif>Manager</option>
						<option value="SEO" @if ("SEO"== old('role')) selected="selected" @endif>SEO</option>	
						</select>										 
						</div>
						</div>
						<div class="form-group">							  
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="capabilities">Capabilities <span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select id="capabilities" class="form-control chosen-select col-md-7 col-xs-12" name="capabilities[]" multiple>
								 
								</select>
								 
							</div>
						</div>
					    
						 
                      
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
			@else
            <div class="row">               
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">                  
                  <div class="x_content">                     
                    <table id="datatable-all-users" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>                          
                          <th>Email</th>                          
                          <th>Phone</th>                          
                          <th>Role</th>                          
                          <th>Status</th>                          
                          <th>Action</th>                           
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>  
            </div>
			@endif
          </div>
        </div>
		
		@endsection