@extends('admin.layouts.app')
@section('title')
Edit Reviews
@endsection
@section('content')
 
<div class="right_col" role="main">
          <div class="">
            			<div class="page-title">
			<div class="title_left">
			<h3>Edit Reviews</h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			@if(Session::has('success')) 	
				<div class="row">
				<div class="col-md-10 col-md-offset-4">
				<div class="alert alert-success">
				<strong>Success!</strong> {{Session::get('success')}}.
				</div>
				</div>
				</div>
				@endif
				@if(Session::has('failed')) 	
				<div class="row">
				<div class="col-md-10 col-md-offset-4">
				<div class="alert alert-danger">
				<strong>!</strong> {{Session::get('failed')}}.
				</div>
				</div>
				</div>
				@endif
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
			<a href="/admin/reviews/add"  class="btn btn-info"> Add Reviews</a>

			</div>
			</div>
			</div>
			</div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return reviewsController.editSaveReviews(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">	

					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="name" value="{{ old('name',(isset($edit_data)) ? $edit_data->name:"")}}" placeholder="Enter Name" >
                        </div>
                      </div> 
					  
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Email</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="email" value="{{ old('email',(isset($edit_data)) ? $edit_data->email:"")}}" placeholder="Enter Email" >
                        </div>
                      </div> 
  				 

					 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Course <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<select class="form-control col-md-7 col-xs-12 select_courses" name="course" >
							<option value="">Select Course</option>
							<?php 
							if(!empty($course_list)){						
							foreach($course_list as $course){
							?>
							<option value="<?php echo $course->id ?>" @if ($course->id== old('course'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->course == $course->id ) ? "selected":"" }} @endif><?php  echo $course->course_name; ?></option>
							<?php } } ?>
							</select>
                        </div>
                      </div>
                        <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Gender <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="gender" >
							<option value="">Select gender</option>
							 
							<option value="Male" @if ('Male'== old('gender'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->gender == 'Male' ) ? "selected":"" }} @endif>Male</option>
						
						<option value="Female" @if ('Female'== old('gender'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->gender == 'Female' ) ? "selected":"" }} @endif>Female</option>
							 
							</select>
                        </div>
                      </div>
                        	 
                       
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Rating(1-5)<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						    <select name="rating" class="form-control col-md-7 col-xs-12">
						  <option value="">Select Rating</option>
						  <option value="1" @if (1== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 1 ) ? "selected":"" }} @endif >1</option>
						
						<option value="2" @if (2== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 2 ) ? "selected":"" }} @endif >2</option>
						  <option value="3" @if (3== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 3 ) ? "selected":"" }} @endif >3</option>
						  <option value="4" @if (4== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4 ) ? "selected":"" }} @endif >4</option>
						  <option value="4.5" @if (4.5== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.5 ) ? "selected":"" }} @endif >4.5</option>
						  <option value="5" @if (5== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 5 ) ? "selected":"" }} @endif >5</option>						  
						  </select>
                        </div>
                      </div> 
					  
					 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Reviews Image<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                         @if(isset($edit_data) && $edit_data->review_image !='')									 
							<?php $vimage= json_decode($edit_data->review_image);  ?>
							<div >
							<img src="<?php echo asset('public/'.$vimage['review_image']['src']); ?>" style="max-width:100px;" height="100" width="100">	
							<a href="/admin/reviews/del_icon/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="" name="review_image" value="{{ $edit_data->review_image }}" >
							</div>
							@else											 
							<input type="file" dir="auto" name="review_image" accept="image/*">


							@endif
                        </div>
                      </div>   
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Image alt<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                         <?php 
						if(isset($edit_data) && $edit_data->review_image !=''){	
						$altname= json_decode($edit_data->review_image);   
						$alt =$altname['review_image']['alt'];
						}else{
						$alt=""; 
						}
						?> 
                          <input class="form-control col-md-7 col-xs-12" type="text" name="alt" value="<?php if($alt){ echo $alt; } ?>" placeholder="Enter image alt name">
                        </div>
                      </div>  
						<div class="form-group">
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Related Courses</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
						<select class="form-control col-md-7 col-xs-12 select_related_courses" name="related_courses[]" multiple>
						<option value=""></option>
						<?php 					
				
							if(!empty($edit_data->related_courses)){	

							$related_courses = json_decode($edit_data->related_courses);	
							}else{
							$related_courses=array();
							}
							if(!empty($course_list) ){						 	
							foreach($course_list as $course){

							if(in_array($course->id, $related_courses)){
							?>
							<option value="<?php echo $course->id; ?>" selected><?php echo $course->title; ?></option>

							<?php } else{ ?>

							<option value="<?php echo $course->id; ?>" ><?php echo $course->title; ?></option>

							<?php	} }  } ?>
						</select>
						 
						</div>
						</div>					  
                       <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Comment<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="comment" >{{ old('comment',(isset($edit_data))?$edit_data->comment:"")}}</textarea>
                        </div>
                      </div>
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Company Name</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="company_name" value="{{ old('company_name',(isset($edit_data)) ? $edit_data->company_name:"")}}" placeholder="Enter Company Name">
                        </div>
                      </div>					  
						  					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Designation</label>					
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="designation" value="{{ old('designation',(isset($edit_data)) ? $edit_data->designation:"")}}" placeholder="Enter Designation">
                        </div>
                    </div> 
					   	  				   	 					
                      
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>

                    </form>
                  </div>
                </div>
              </div>		  
            </div> 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
$('.summernote').summernote({
height: 200
});
</script>
 


@endsection
