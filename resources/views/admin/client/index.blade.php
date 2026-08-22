@extends('admin.layouts.app')
@section('title')
Client
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
			<div class="page-title">
			<div class="title_left">
			<h3>Clients</h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
			<a href="/admin/client/add"  class="btn btn-info"> Add Client</a>

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
                    <form class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return clientController.submit(this)" > 

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Client Name <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="name" value="" placeholder="Enter Client Name" >
                        </div>
                      </div>    
					    
						<div class="form-group">
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Client Icon<span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12"><span>Original Dimensions 148*56</span>
						<input type="file" class="form-control col-md-7 col-xs-12" name="client_icons" value="" accept=".jpeg,.jpg,.png,.svg">
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
                     
                    <table id="datatable-all-client" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>                          
                          <th>Icons</th>                          
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