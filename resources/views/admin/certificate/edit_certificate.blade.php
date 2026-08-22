@extends('admin.layouts.app')
@section('title')
Edit Certificate
@endsection
@section('content')
 
<div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> Certificate Title and Rating <small></small></h2>  
						<div class="succesmessage"></div><div class="errormessage"></div>
						@if(Session::has('success')) 	
						<div class="row">
						<div class="col-md-8 col-md-offset-2">
						<div class="alert alert-success">
						<strong>Success!</strong> {{Session::get('success')}}.
						</div>
						</div>
						</div>
						@endif
						@if(Session::has('failed')) 	
						<div class="row">
						<div class="col-md-8 col-md-offset-2">
						<div class="alert alert-danger">
						<strong>!</strong> {{Session::get('failed')}}.
						</div>
						</div>
						</div>
						@endif                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" method="post" onsubmit="return certificateController.editSaveCertificateTitle(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Titile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="title" value="{{ old('title',(isset($edit_data)) ? $edit_data->title:"")}}" placeholder="Enter coure title">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Sub Titile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="sub_title" value="{{ old('subtitle',(isset($edit_data)) ? $edit_data->sub_title:"")}}" placeholder="Enter Sub title">
                        </div>
                      </div>
					  
					  <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Slug <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="slug"  value="{{ old('slug',(isset($edit_data)) ? $edit_data->slug:"")}}"  placeholder="Enter Coure Slug">
                        </div>
                      </div>
					 
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Course Name<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" name="course_name"  class="form-control col-md-7 col-xs-12" value="{{ old('course_name',(isset($edit_data)) ? $edit_data->course_name:"")}}"  placeholder="Enter Coure Name"> 
                        </div>
                      </div>
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="category" class="form-control col-md-7 col-xs-12 select_category " onchange="get_subcategory(this.value);">
						  <option value="">Select Category</option>
							@if(!empty($cetegories))
							@foreach($cetegories as $category)	
							<option value="<?php  echo $category->id; ?>" @if ($category->id== old('category'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->category == $category->id ) ? "selected":"" }} @endif> <?php echo $category->category; ?></option>		
							@endforeach
							@endif						
						  </select>
                        </div>
                      </div>  

					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Sub Category<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">      
						
						  <select name="subcategory" class="form-control col-md-7 col-xs-12 select_subcategory show_subcategory">
						   				
						  </select>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Rating(1-5)<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="rating" class="form-control col-md-7 col-xs-12">
						  <option value="">Select Rating</option>
						  <option value="4" @if (4== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4 ) ? "selected":"" }} @endif >4</option>
						  <option value="4.5" @if (4.5== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.5 ) ? "selected":"" }} @endif >4.5</option>
						  <option value="4.75" @if (4.75== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.75 ) ? "selected":"" }} @endif >4.75</option>
						  <option value="4.8" @if (4.8== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.8 ) ? "selected":"" }} @endif >4.8</option>
						  <option value="4.9" @if (4.9== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.9 ) ? "selected":"" }} @endif >4.9</option>
						  <option value="5" @if (5== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 5 ) ? "selected":"" }} @endif >5</option>						  
						  </select>
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Total Ratings<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="total_rating" value="{{ old('total_rating',(isset($edit_data)) ? $edit_data->total_rating:"")}}"  placeholder="Enter Total Rating">
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Course Image<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">

							@if(isset($edit_data) && $edit_data->course_image !='')									 
							<?php $vimage= json_decode($edit_data->course_image);  ?>
							<div >
							<img src="<?php echo asset($vimage['course_image']['src']); ?>" style="max-width:100px;" height="100" width="100">	
							<a href="/admin/certificate/del_icon/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="" name="course_image" value="{{ $edit_data->course_image }}" >
							</div>
							@else											 
							<input type="file" dir="auto" name="course_image" accept="image/*">


							@endif
                           
                        </div>
                      </div>                      
						<div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Image alt<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">								 
						<?php 
						if(isset($edit_data) && $edit_data->course_image !=''){	
						$altname= json_decode($edit_data->course_image);   
						$alt =$altname['course_image']['alt'];
						}else{
						$alt=""; 
						}
						?> 
                          <input class="form-control col-md-7 col-xs-12" type="text" name="alt" value="<?php if($alt){ echo $alt; } ?>" placeholder="Enter image alt name">
                        </div>
                      </div> 
					 
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Meta Keyword<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_keyword" placeholder="Enter Meta Keyword">{{ old('meta_keyword',(isset($edit_data)) ? $edit_data->meta_keyword:"")}}</textarea>
                        </div>
                      </div>
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Meta Description<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_description" placeholder="Enter Meta Description">{{ old('meta_description',(isset($edit_data)) ? $edit_data->meta_description:"")}}</textarea>
                        </div>
                      </div>
 				  
                      
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			  
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" action="" method="post" onsubmit="return certificateController.editSaveCertificateOverview(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">

                      <div class="form-group">  
						<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Course Overview<span class="required">*</span></label>                      
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 summernote"  name="course_overview" placeholder="Enter coure title">{{ old('course_overview',(isset($edit_data)) ? $edit_data->course_overview:"")}}</textarea>
                        </div>
                      </div> 
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
			  
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
 
                    <div class="succeCurriculum"></div><div class="errorCurriculum"></div>			
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                   
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return certificateController.editSaveCertificateCurriculum(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					<div class="form-group">	
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Course Curriculum<span class="required">*</span></label>					
					<div class="col-md-10 col-sm-10 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12 summernote" type="text" name="course_curriculum" placeholder="Enter Total Rating">{{ old('course_curriculum',(isset($edit_data)) ? $edit_data->course_curriculum:"")}}</textarea>
					</div>
					</div>  
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit" >Submit</button>
                        </div>
                    </div>

                    </form>
                  </div>
                </div>
              </div> 


			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Related Course<small></small></h2>
                    <div class="succescourseRelated"></div><div class="errorcourseRelated"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return certificateController.editSaveCertificateRelated(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Show Related Courses (Sidebar)</label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<select class="form-control col-md-7 col-xs-12 select_related_courses_side" name="related_courses_side[]" multiple>
					<option value="">Select Course</option> 
						<?php 						 
						if(!empty($edit_data->related_courses_side)){	
 					
						$related_courses_side = json_decode($edit_data->related_courses_side);	
						}else{
							$related_courses_side=array();
						}
						 
						if(!empty($course_list)){						
						foreach($course_list as $course){
						if(in_array($course->id, $related_courses_side)){
						?>
						<option value="<?php echo $course->id; ?>" selected><?php echo $course->title; ?></option>

						<?php }else{ ?>

						<option value="<?php echo $course->id; ?>" ><?php echo $course->title; ?></option>

						<?php	} }  }  ?>		
 
					</select>

					</div>
					</div>
					
					
				
					
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Related Certifications</label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<select class="form-control col-md-7 col-xs-12 select_related_certifications" name="related_certifications[]" multiple>
					<option value="">Select</option>
					<?php 		

						if(!empty($edit_data->related_certifications)){	

						$related_certifications = json_decode($edit_data->related_certifications);	
						}else{
						$related_certifications=array();
						}					
						if(!empty($course_list)){
						foreach($course_list as $course){

						if(in_array($course->id, $related_certifications)){
						?>
						<option value="<?php echo $course->id; ?>" selected><?php echo $course->title; ?></option>

						<?php } else{ ?>

						<option value="<?php echo $course->id; ?>" ><?php echo $course->title; ?></option>

						<?php	} }  } ?>
					</select>
					 
					</div>
					</div>
				 <div class="form-group">
				 
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Certification Tab?<span class="required">*</span></label></div>
						<div class="col-12 col-md-2">
						Yes
						<input type="radio" name="show_certification_tab" value="1"  @if (1== old('show_certification_tab'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_certification_tab == 1 ) ? "checked":"" }} @endif>	
						</div>
						<div class="col-12 col-md-2">
						No
						<input type="radio" name="show_certification_tab" value="0" @if ('0'== old('show_certification_tab'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_certification_tab == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>
						
				         <div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Front Page?<span class="required">*</span></label></div>
						<div class="col-12 col-md-2">
						Yes
						<input type="radio" name="show_front_page" value="1"  @if (1== old('show_front_page'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_front_page == 1 ) ? "checked":"" }} @endif>	
						</div>
						<div class="col-12 col-md-2">
						No
						<input type="radio" name="show_front_page" value="0"  @if ('0'== old('show_front_page'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_front_page == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>             
                     	<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Related Courses</label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<select class="form-control col-md-7 col-xs-12 select_related_courses" name="related_courses[]" multiple>
					<option value=""></option>
					<?php 						 
						if(!empty($edit_data->related_courses)){						
						$related_courses = json_decode($edit_data->related_courses);		
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
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			  
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>FAQ Course<small></small></h2>
                    <div class="successFAQs"></div><div class="errorFAQs"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return certificateController.editSaveFAQ(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					 <?php if(!empty($edit_data->FAQs)){
						 $FAQs =json_decode($edit_data->FAQs);                    
					 $faqquestion  = json_decode($FAQs->faqq);
					 
					 $faqanswer  = json_decode($FAQs->faqa);
 					 
					 for($i=0; $i<count($faqquestion); $i++){						 
					 ?>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">FAQ Question <?php echo $i+1; ?> <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" value="<?php echo (isset($faqquestion[$i])? $faqquestion[$i]:""); ?>" placeholder="FAQ Question 1"> 
					</div>
					</div>
				 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">FAQ Answer <?php echo $i+1; ?><span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12" type="text" name="faqa[]" placeholder="Enter FAQ Answer 1"><?php echo (isset($faqanswer[$i])? $faqanswer[$i]:""); ?></textarea>
					</div>
					</div>		 
					 <?php   }  }else{ ?> 
					 <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">FAQ Question  <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" value="" placeholder="FAQ Question 1"> 
					</div>
					</div>
				 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">FAQ Answer <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12" type="text" name="faqa[]" placeholder="Enter FAQ Answer 1"></textarea>
					</div>
					</div>
					 <?php } ?>
					<div class="addfqa">
					
					</div>
					
					<button class="add_more_stream" type="button" style="margin-top: -20px;float: right;margin-right: 125px;">Add More</button> 
				 
                      
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
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
	var maxAppend = 2;
	$(".add_more_stream").click(function(){
	if (maxAppend >= 11) return;
	var addinput = $(
	'<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">FAQ Question '+maxAppend+' <span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" placeholder="FAQ Question '+maxAppend+'"></div></div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">FAQ Answer '+maxAppend+'<span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="faqa[] placeholder="Enter FAQ Answer "></textarea></div></div><br />');
	maxAppend++;

	$(".addfqa").append(addinput);
	});
	</script>
	<script>
	function remove(a){
	$(a).parent("div").remove();
	}
	$('#basicExample').timepicker();
	</script>
	
	
<script>	
	window.onload = function()
	{
		var category_id 	='<?php echo $edit_data->category; ?>';
		var subcategory_id 	= '<?php echo $edit_data->subcategory; ?>';	 
		get_subcategory(category_id,subcategory_id);	 
	 
	}	 
</script> 

<script>
function get_subcategory(cid,sid){	 
 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/subcategory/get_subcategory')}}",
	data: {cid:cid,sid:sid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_subcategory").html(data);
	}
	});



}

</script>
@endsection
