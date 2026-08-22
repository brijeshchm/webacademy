@extends('admin.layouts.app')
@section('title')
All SEO Course Page
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
			<div class="page-title">
			<div class="title_left">
			<h3>All SEO Course Page</h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
			<a href="/admin/seopage/add"  class="btn btn-info"> Add SEO Course Page</a>
			</div>
			</div>
			</div>
			</div>
            <div class="clearfix"></div>
            <div class="row">
               
              <div class="col-md-12 col-sm-12 col-xs-12">
                   <div class="row">	 							  
					  <form  method="GET" action=""  novalidate autocomplete="off">					 
							        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							  <div class="nk-int-mk">
                                    <h6>Category</h6>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-windows"></i>
                                    </div>
                                    <div class="nk-int-st">
									 
                                        <select class="bootstrap-select fm-cmp-mg form-control category" name="search[category]" >
											<option value="">Select Category</option>										 
											
										@if(!empty($categorylist))
												@foreach($categorylist as $category)
													@if(isset($search['category']) && $search['category']==$category->id)
														<option value="{{ $category->id }}" selected>{{ $category->category}}</option>
													@else
														<option value="{{ $category->id }}">{{ $category->category }}</option>
													@endif
												@endforeach
											@endif
											</select>
                                    </div>
                                </div>
                                </div>						 
								
							    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								<div class="nk-int-mk">
								<h6>Course Type</h6>
								</div>
								<div class="form-group ic-cmp-int">
								<div class="form-ic-cmp">
								<i class="notika-icon notika-star"></i>
								</div>
								<div class="nk-int-st">
								<select class="bootstrap-select fm-cmp-mg form-control" name="search[course_type]" >
								<option value="">Select Type</option>
								<option value="1" @if(isset($search['course_type']) && $search['course_type'] == 1) selected @endif>Course Type 1</option>		
								<option value="2" @if(isset($search['course_type']) && $search['course_type'] == 2) selected @endif>Course Type 2</option>		
								</select>
								</div>
								</div>
								</div>	
								
								
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">							  
								<div class="form-group ic-cmp-int">                                     
								<div class="nk-int-st">                                        
								<button type="submit" class="btn btn-success" style="margin-top:10%;width: 200px;" name="submit">Filter</button>					 					 
								</div>                                 
								</div>
								</div>
                          </form>
						</div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Course  <small>List</small></h2>
                     
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     
                    <table id="datatable-all-SEO-course" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Course name</th>
                          <th>Title</th>
                          <th>Slug</th>
                          <th>Course Type</th>
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