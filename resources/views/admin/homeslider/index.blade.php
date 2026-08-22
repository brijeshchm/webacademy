@extends('admin.layouts.app')
@section('title')
Home Bannar Slider
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
<div class="page-title">
              <div class="title_left">
                <h3>Web Home Bannar</h3>
				<div class="succesmessage"></div><div class="errormessage"></div>
              </div>

              <!--<div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                     <a href="/admin/homeslider/add"  class="btn btn-info">Add Home Bannar Slider</a>
                    
                  </div>
                </div>
              </div>-->
            </div>
            <div class="clearfix"></div>
				 @if(Request::segment(3)=='add'  || Request::segment(3)=='edit'  )
			 <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel"> 
                  <div class="x_content">                    
                    <form class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return homesliderController.sliderSubmit(this)" enctype="multipart/form-data"> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Home Slider Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="slider_name" value="" placeholder="Enter Bannar Slider Name" >
                        </div>
                      </div>          
					    <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Image <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">Size(1366 × 410 px)
								<input class="form-control col-md-7 col-xs-12" type="file" name="image_slider" accept=".jpeg,.jpg,.png,.svg" placeholder="Enter Content Image">
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
						<table id="datatable-all-home-slider" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No</th>   
									<th>Slider Name</th>    
									<th>Slider Image</th>                          
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
          
		  <!---- Mobile Home Banner----->
				<div class="">    
					<div class="page-title">
					  <div class="title_left">
						<h3>Mobile Home Bannar</h3>
						<div class="succesmessage"></div><div class="errormessage"></div>
					  </div>

					  <!--<div class="title_right">
						<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
						  <div class="input-group">
							 <a href="/genie/mobhomeslider/add"  class="btn btn-info">Add Mobile Bannar</a>
							
						  </div>
						</div>
					  </div>-->
					</div>
					<div class="clearfix"></div>
						 @if(Request::segment(3)=='add'  || Request::segment(3)=='edit'  )
					 <div class="row">
					  <div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel"> 
						  <div class="x_content">                    
							<form class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return homesliderController.sliderSubmit(this)" enctype="multipart/form-data"> 
							  <div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Mobile Banner Name <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input type="text" class="form-control col-md-7 col-xs-12" name="slider_name" value="" placeholder="Enter Bannar Slider Name" >
								</div>
							  </div>          
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Mobile Banner Image <span class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input class="form-control col-md-7 col-xs-12" type="file" name="image_slider" accept=".jpeg,.jpg,.png,.svg" placeholder="Enter Content Image">
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
								<table id="datatable-all-mobile-banner" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Mobile Banner Name</th>                          
											<th>Banner Image</th>                          
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