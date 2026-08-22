@extends('admin.layouts.app')
@section('title')
All Certificate
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    

            <div class="clearfix"></div>
            <div class="row">
               
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Certificate  dd <small>List</small></h2>
                     
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     
                    <table id="datatable-all-Certificate" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Certificate name</th>
                          <th>Title</th>
                          <th>Slug</th>
                          <th>Rating</th>
                          <th>Image</th>
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