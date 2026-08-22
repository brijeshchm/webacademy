@extends('admin.layouts.app')
@section('title')
Permission
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
			<div class="page-title">
			<div class="title_left">
			<h3><a href="{{url('admin/permission')}}" >Permission</a></h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
			<a href="{{url('admin/permission/add')}}"  class="btn btn-info"> Add Permission</a>

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
                    <form class="form-horizontal form-label-left" action="#" method="POST" onsubmit="return permissionController.submit(this)">
						<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
						<div class="col-md-7 col-sm-7 col-xs-12">
						<input type="text" class="form-control" name="permission" autocomplete="off" placeholder="Enter Permission Text" value="{{ old('permission',(isset($edit_data)) ? $edit_data->permission:"")}}" >
						</div>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group">
						<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
						<button type="reset" class="btn btn-primary">Reset</button>
						<button type="submit" class="btn btn-success">Submit</button>
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
                    <table id="datatable-permission" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                        <th>Name</th>
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