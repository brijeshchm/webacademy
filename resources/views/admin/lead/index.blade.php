@extends('admin.layouts.app')
@section('title')
All Inquiry
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
			<div class="page-title">
			<div class="title_left">
			<h3>Inquiry</h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
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
                                   	<label>Date From</label>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-windows"></i>
                                    </div>
                                    <div class="nk-int-st">
                                      	<input type="text" class="form-control leaddf" name="search[leaddf]" value="" placeholder="Create Date From">
                                    </div>
                                </div>
                            </div>						 
								
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								<div class="nk-int-mk">
									<label>Date To</label>
								</div>
								<div class="form-group ic-cmp-int">
								<div class="form-ic-cmp">
								<i class="notika-icon notika-star"></i>
								</div>
								<div class="nk-int-st">
							 	<input type="text" class="form-control leaddt" name="search[leaddt]" value="" placeholder="Create Date From">
								</div>
								</div>
								</div>	
								
								
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								<div class="nk-int-mk">
								<label>Cources</label>
								</div>
								<div class="form-group ic-cmp-int">
								<div class="form-ic-cmp">
								<i class="notika-icon notika-star"></i>
								</div>
								<div class="nk-int-st">
							  	<select class="form-control select_related_courses_side" name="search[courses]">
											<option value="">Select Course</option>
										 
												@foreach($courses as $course)
												@if(isset($search['courses']) && $search['courses'] == $course->id)
														<option value="{{ $course->id }}" selected><?php echo  substr($course->course_name,0,16); ?></option>
													@else
														<option value="{{ $course->id }}"><?php echo substr($course->course_name,0,16); ?></option>
													@endif
												@endforeach
										 
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
                    
                  <div class="x_content">
                       
                    <table id="datatable-all-leads" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all" class="check-box-lead"></th>
						    <th>Date</th>                          
                            <th>Name</th>                          
                            <th>Mobile</th>     
                              <th>Email</th>    
                            <th>Course</th>                          
                            <th>Form Field</th>  
                        </tr>
                      </thead>


                       </table>
                  </div>
                </div>
                
                	@if(Auth::user()->current_user_can('administrator')|| Auth::user()->current_user_can('delete_lead') )
                <div class="col-lg-4">
				<button type="button" class="btn btn-success  btn-block move-not-interested" onclick="javascript:leadController.selectLeads()" >Delete</button>
				</div>	
				@endif
              </div>

             
               
              
            </div>
			 
          </div>
        </div>
		
	<!--	<script>
		
	function autoRefresh_div()
	{    

		$.ajax({
		url: "/getleadcount",
		dataType: 'json',
		contentType: "application/json; charset=utf-8",
		success:  
		function(data,textStatus,jqXHR){ 
		if(data.statusCode){
		var payload = data.success.count_data;
		  
		$('.circle').html(payload);  
		} 
		}
		});
	}
	setInterval('autoRefresh_div()', 9000);
		</script>-->
		@endsection