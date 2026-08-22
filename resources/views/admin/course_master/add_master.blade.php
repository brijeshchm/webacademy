@extends('admin.layouts.app')
@section('title')
Add Course Master
@endsection
@section('content')

<div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Add Course Master<small></small></h3><div class="succesmessage"></div><div class="errormessage"></div>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form class="form-horizontal form-label-left" method="post" action="" onsubmit="return courseMasterController.saveCourseMasterTitle(this)" > 
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Course Name<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" name="course_name"  class="form-control col-md-7 col-xs-12" placeholder="Enter Course Name"> 
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="title" value="" placeholder="Enter title" >
                        </div>
                      </div> 
  				 

					 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Sub Title <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="sub_title" value="" placeholder="Enter Sub Title" >
                        </div>
                      </div>
					<!--  <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Slug URL <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="slug"  value=""  placeholder="Enter Coure Slug">
                        </div>
                      </div>-->	
                    
					     <div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
							<select name="category" class="form-control col-md-7 col-xs-12 select_category" onchange="get_subcategory(this.value);">
							<option value="">Select Category</option>
							@if(!empty($cetegories))
							@foreach($cetegories as $category)	
							<option value="<?php  echo $category->categoryid; ?>" @if ($category->categoryid== old('category'))
							selected="selected"	
							 @endif> <?php echo $category->categoryname; ?></option>		
							@endforeach
							@endif						
							</select>
							</div>
							</div>  

							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Sub Category<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">      

							<select name="subcategory" class="form-control col-md-7 col-xs-12 select_subcategory show_subcategory_pdf" onchange="get_categoryPDF(this.value);">

							</select>
							</div>
							</div> 
							
					  
						<div class="form-group">
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course PDF<span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12">   
						<select name="course_pdf_text" class="form-control col-md-7 col-xs-12  show_course_pdf">

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
                          <input class="form-control col-md-7 col-xs-12" type="tel" name="total_rating" onkeypress="return isNumericKeyCheck(event);" placeholder="Enter Total Rating">
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Duration(Months)<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="tel" name="course_duration" onkeypress="return isNumericKeyCheck(event);" value=""  placeholder="Enter Course Duration">
                        </div>
                      </div> 
					  
					  <!--<div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Live project<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="tel" name="live_project" value=""  placeholder="Enter Live project">
                        </div>
                      </div>  -->
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Fees<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="tel" name="fees" value=""  onkeypress="return isNumericKeyCheck(event);" placeholder="Enter fees">
                        </div>
                      </div> 
					   
					<!--  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Icon<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">						 										 
							<input type="file" dir="auto" class="form-control col-md-7 col-xs-12" name="course_icons" accept="image/*">                        
                        </div>
                      </div>  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Image<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="file" name="course_image" accept=".jpeg,.jpg,.png">
                        </div>
                      </div>   
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Image alt<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="alt" placeholder="Enter image alt name">
                        </div>
                      </div>   -->                   
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
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Short Definition<span class="required">*</span></label>					
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12" name="course_description" placeholder="Enter course description">{{ old('course_description')}}</textarea>
                        </div>
                    </div> 
				 
					 
					 
                    <!-- <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">City </label>
					@if(!empty($citys))
						@foreach($citys as $city)
					<div class="col-md-2 col-sm-2 col-xs-2">
					   <?php echo $city->city; ?> <input type="checkbox" name="citycourse[]" value="<?php echo $city->city ?>" style="width: 37px;height: 20px;">
					</div>
					@endforeach
					@endif
					 
					</div>-->
                      
                    
					  
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
 
  
  
 


<script>	
	window.onload = function()
	{
		  
		get_subcategory(category_id,subcategory_id);	 
		get_categoryPDF(subcategory_id,course_pdf_text);	 
	 
	}	 
</script>
 

<script>

function get_subcategory(cid,sid){	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/subcategory_pdf/get_subcategory_pdf')}}",
	data: {cid:cid,sid:sid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_subcategory_pdf").html(data);
	}
	});



}

function get_categoryPDF(sid,pid){	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/get_category_course_pdf/get_course_pdf')}}",
	data: {sid:sid,pid:pid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_course_pdf").html(data);
	}
	});



}

</script>
@endsection
