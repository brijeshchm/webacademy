@extends('admin.layouts.app')
@section('title')
Add Certificate
@endsection
@section('content')
  
<div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Add Certificate<small></small></h3><div class="succesmessage"></div><div class="errormessage"></div>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form class="form-horizontal form-label-left" action="" onsubmit="return certificateController.saveCertificateTitle(this)" > 

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Titile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="title" value="" placeholder="Enter Certificate title" >
                        </div>
                      </div> 
  				 

					 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Sub Titile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="sub_title" value="" placeholder="Enter Certificate Sub Title" >
                        </div>
                      </div>
					 
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Certificate Name<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" name="course_name"  class="form-control col-md-7 col-xs-12" placeholder="Enter Certificate Name"> 
                        </div>
                      </div>
					   <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="category" class="form-control col-md-7 col-xs-12 select_category category">
						  <option value="">Select Category</option>
							@if(!empty($cetegories))
							@foreach($cetegories as $category)	
							<option value="<?php  echo $category->id; ?>"><?php echo $category->category; ?></option>		
							@endforeach
							@endif						
						  </select>
                        </div>
                      </div> 
					   <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Sub Category<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="subcategory" class="form-control col-md-7 col-xs-12 select_subcategory">
						   				
						  </select>
                        </div>
                      </div> 
					  
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Rating(1-5)<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="rating" class="form-control col-md-7 col-xs-12">
						  <option value="">Select Rating</option>
						  <option value="4">4</option>
						  <option value="4.5">4.5</option>
						  <option value="4.75">4.75</option>
						  <option value="4.8">4.8</option>
						  <option value="4.9">4.9</option>
						  <option value="5">5</option>						  
						  </select>
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Total Ratings<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="number" name="total_rating" placeholder="Enter Total Rating">
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Certificate Image<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="file" name="course_image" accept=".jpeg,.jpg,.png">
                        </div>
                      </div>   
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Image alt<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="alt" placeholder="Enter image alt name">
                        </div>
                      </div>                      
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Keyword<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_keyword" placeholder="Enter Meta Keyword"></textarea>
                        </div>
                      </div>
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Description<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_description" placeholder="Enter Meta Description"></textarea>
                        </div>
                      </div>	


					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Why should you learn AWS?</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="why_learn[]" placeholder="Why should you learn AWS"></textarea>
                        </div>
                      </div>
						<div class="result_why_learn">

						</div>
						<button class="add_why_learn" type="button" style="margin-top: -30px;float: right;margin-right: 95px;">Add More</button> 					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Certificate About<span class="required">*</span></label>					
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 summernote" name="course_overview" placeholder="Enter Certificate title">{{ old('course_overview')}}</textarea>
                        </div>
                    </div> 
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Training Curriculum Text<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="curriculum_text" placeholder="Enter Training Curriculum Text">
                        </div>
                      </div>	
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Certificate Content<span class="required">*</span></label>					
					<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea type="text" class="form-control col-md-7 col-xs-12 summernote"  name="course_content" placeholder="Enter Certificate Content">{{ old('course_overview')}}</textarea>
					</div>
					</div> 
					 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Related Courses</label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<select class="form-control col-md-7 col-xs-12 select_related_courses" name="related_courses[]" multiple>
					<option value="">Select Related Course</option>
					<?php 
					if(!empty($course_list)){						
					foreach($course_list as $course){
					?>
					 <option value="<?php echo $course->id ?>"><?php  echo $course->title; ?></option>
					<?php } } ?>
					</select>
					</div>
					</div>
                     <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">How Namy City </label>
					@if(!empty($citys))
						@foreach($citys as $city)
					<div class="col-md-2 col-sm-2 col-xs-2">
					   <?php echo $city->city; ?> <input type="checkbox" name="citycourse[]" value="<?php echo $city->city ?>" style="width: 37px;height: 20px;">
					</div>
					@endforeach
					@endif
					 
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


<script>   
	  
	  var maxAppend = 0;
$(".add_why_learn").click(function(){
    if (maxAppend >= 8) return;
    var addinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"></label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="why_learn[]" placeholder="Why should you learn AWS"></textarea> <span class="btn btn-inverse btn-circle m-b-5" onclick="remove(this)" style="margin-right:-40px;color:red;"><i class="glyphicon glyphicon-trash"></i></span></div></div></div><br />');   
		maxAppend++;

    $(".result_why_learn").append(addinput);
});
	  
</script>

<script>
function remove(a){
$(a).parent("div").remove();
}
</script>
@endsection
