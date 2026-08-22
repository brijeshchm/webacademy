@extends('admin.layouts.app')
@section('title')
Category   
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
			<div class="page-title">
			<div class="title_left">
			<h3>Category</h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
			<a href="/admin/category/add"  class="btn btn-info"> Add Category</a>

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
                    <form class="form-horizontal form-label-left" method="post" autocomplete="off" action="" onsubmit="return categoryController.submit(this)" > 

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Category <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="category" value="" placeholder="Enter Category" >
                        </div>
                      </div>    
					    
						<div class="form-group">
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Category Icon<span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12"><span>Original Dimensions 49*49 && Max 3Kb</span>
						<input type="file" class="form-control col-md-7 col-xs-12" name="category_icons" value="" accept=".jpeg,.jpg,.png,.svg">
						</div>
						</div>  
						<div class="form-group">
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Video Link <span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12"><span>Copy embed URL</span>
						<input type="text" class="form-control col-md-7 col-xs-12" name="video_link" value="" placeholder="Enter Embed Youtube embed Link">
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
                     
                    <table id="datatable-all-category" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Category</th>                          
                          <th>Icons</th>    
                         
                                                  
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