@extends('admin.layouts.app')
@section('title')
Blog
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
<div class="page-title">
              <div class="title_left">
                <h3>Blog</h3>
				<div class="succesmessage"></div><div class="errormessage"></div>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                     <a href="/admin/blog/add"  class="btn btn-info"> Add Blog</a>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
				 
            <div class="row">
               
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                     
                    <table id="datatable-all-blog" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Title</th>                  
                          <th>Slug</th>                  
                          <th>Image</th>           
                            <th>Status</th>            
                          <th>Action</th>
                           
                        </tr>
                      </thead>


                       </table>
                  </div>
                </div>
              </div>

             
               
              
            </div>
			 
          </div>
        </div>
		
		@endsection