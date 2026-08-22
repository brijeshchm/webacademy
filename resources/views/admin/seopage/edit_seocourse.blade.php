@extends('admin.layouts.app')
@section('title')
Edit Course
@endsection
@section('content') 
<style>
.disabled {
    pointer-events: none;
    cursor: not-allowed;
	 background: #dddddd;
}
</style>
<div class="right_col" role="main">
          <div class="">            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
					<h1> Course SEO Page <small>Course Title and Rating</small></h1>  
					<div class="succesmessage"></div><div class="errormessage"></div>
					@if(Session::has('success')) 	
					<div class="row">
					<div class="col-md-8 col-md-offset-3">
					<div class="alert alert-success">
					<strong>Success!</strong> {{Session::get('success')}}.
					</div>
					</div>
					</div>
					@endif
					@if(Session::has('failed')) 	
					<div class="row">
					<div class="col-md-8 col-md-offset-3">
					<div class="alert alert-danger">
					<strong>!</strong> {{Session::get('failed')}}.
					</div>
					</div>
					</div>
					@endif                  
					<div class="clearfix"></div>
					</div>
					<div class="x_content">                    
						<form  data-parsley-validate method="post" class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return SEOController.editSaveCourseSeoTitle(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">

							<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="title" value="{{ old('title',(isset($edit_data)) ? $edit_data->title:"")}}" placeholder="Enter title">
							</div>
							</div>
						

							<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Slug <span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="slug"  value="{{ old('slug',(isset($edit_data)) ? $edit_data->slug:"")}}"  placeholder="Enter Course Slug">
							</div>
							</div>

							<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="last-name">Course Name<span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="course_name"  class="form-control col-md-7 col-xs-12" value="{{ old('course_name',(isset($edit_data)) ? $edit_data->course_name:"")}}"  placeholder="Enter Course Name"> 
							</div>
							</div>

							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
							<select name="category" class="form-control col-md-7 col-xs-12 select_category" onchange="get_subcategory(this.value);">
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
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Rating(1-5)<span class="required">*</span></label>
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
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Total Ratings<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" type="tel" name="total_rating" onkeypress="return isNumericKeyCheck(event);" value="{{ old('total_rating',(isset($edit_data)) ? $edit_data->total_rating:"")}}"  placeholder="Enter Total Rating">
							</div>
							</div>  
                         
				 


						
							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Title<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_title" placeholder="Enter Meta Title">{{ old('meta_title',(isset($edit_data)) ? $edit_data->meta_title:"")}}</textarea>
							</div>
							</div>
						
							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Description<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_description" placeholder="Enter Meta Description">{{ old('meta_description',(isset($edit_data)) ? $edit_data->meta_description:"")}}</textarea>
							</div>
							</div>

							<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Short description <span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="description" value="{{ old('description',(isset($edit_data)) ? $edit_data->description:"")}}" placeholder="Enter description">
							</div>
							</div>
							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Definition <span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<textarea class="form-control col-md-7 col-xs-12" type="text" name="course_defination" placeholder="Enter course defination">{{ old('course_defination',(isset($edit_data)) ? $edit_data->course_defination:"")}}</textarea>
							</div>
							</div>
                        <div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">City <span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<select name="city" class="form-control col-md-7 col-xs-12 disabled">
						<option value="">Select City</option>
						
						<option value="{{$edit_data->city}}" selected >{{$edit_data->city}}</option>
					 
						</select>	
							</div>
							</div>
							 
							
							<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success" onclick="check(this)">Submit</button>
							</div>
							</div>

						</form>
					  </div>
                </div>
              </div>
			  
			   <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">  
					<h3>Course Extra Content<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
					<div class="clearfix"></div>
					</div>
					<div class="x_content"> 
						<form class="form-horizontal form-label-left" action="" method="post" onsubmit="return SEOController.editSaveCourseExtraContent(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multiform/data-from">




						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Top Heading<span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12"  name="top_heading" placeholder="Enter top heading" value="<?php echo (isset($edit_data->top_heading)? $edit_data->top_heading:""); ?>" >
						</div>
						</div> 

				<div class="form-group">
    <label for="top_description" class="control-label col-md-2 col-sm-3 col-xs-12">
        Top Description <span class="required">*</span>
    </label>

    <div class="col-md-8 col-sm-8 col-xs-12">
        <textarea
            id="top_description"
            class="form-control col-md-7 col-xs-12"
            name="top_description"
            placeholder="Enter top description"
        >{{ old('top_description', $edit_data->top_description ?? '') }}</textarea>
    </div>
</div>


						<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">                          
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
					<h3>Course About <small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
					<div class="clearfix"></div>
					</div>
					<div class="x_content"> 
						<form class="form-horizontal form-label-left" action="" method="post" onsubmit="return SEOController.editSaveCourseSeoAbout(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multiform/data-from">


	                    <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12"  name="heading" placeholder="Enter coure heading"   value="{{ old('heading',(isset($aboutHeading->heading)) ? $aboutHeading->heading:"")}}" > 
						</div>
						</div>


						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course About <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<textarea type="text" class="form-control col-md-7 col-xs-12 summernote"  name="courseabout" rows="7" placeholder="Enter coure about"  >{{ old('courseabout',(isset($aboutHeading->courseabout)) ? $aboutHeading->courseabout:"")}}</textarea>
						</div>
						</div> 
						
						
					
						
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 1 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12"  name="paragraph1" placeholder="Enter Paragraph 1"   value="{{ old('paragraph1',(isset($aboutHeading->paragraph1)) ? $aboutHeading->paragraph1:"")}}" > 
						</div>
						</div> 
						
						
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 2 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12"  name="paragraph2" placeholder="Enter Paragraph 2"   value="{{ old('paragraph2',(isset($aboutHeading->paragraph2)) ? $aboutHeading->paragraph2:"")}}" > 
						</div>
						</div> 
						
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 3 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12"  name="paragraph3" placeholder="Enter Paragraph 3"   value="{{ old('paragraph3',(isset($aboutHeading->paragraph3)) ? $aboutHeading->paragraph3:"")}}" > 
						</div>
						</div> 
						
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 4 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12"  name="paragraph4" placeholder="Enter Paragraph 4"   value="{{ old('paragraph4',(isset($aboutHeading->paragraph4)) ? $aboutHeading->paragraph4:"")}}" > 
						</div>
						</div> 
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 5 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12"  name="paragraph5" placeholder="Enter Paragraph 5"   value="{{ old('paragraph5',(isset($aboutHeading->paragraph5)) ? $aboutHeading->paragraph5:"")}}" > 
						</div>
						</div> 
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 6 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12"  name="paragraph6" placeholder="Enter Paragraph 6"   value="{{ old('paragraph6',(isset($aboutHeading->paragraph6)) ? $aboutHeading->paragraph6:"")}}" > 
						</div>
						</div>
						
						<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">                          
						 
					 
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
					<h3>Why should you learn<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
					<div class="clearfix"></div>
					</div>
					<div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" action="" method="post" onsubmit="return SEOController.editSaveCourseLearn(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">                
					  


					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Why should you learn?<span class="required">*</span></label>					  
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="why_learn_heading" value="{{ old('why_learn_heading',(isset($edit_data)) ? $edit_data->why_learn_heading:"")}}" placeholder="Why should you learn Heading"></textarea>
                        </div>
                      </div> 
					  
					  
					<?php 
					  if(!empty($edit_data->why_learn)){
					  $why_learn = json_decode($edit_data->why_learn); 
 					  					 
										 ?>	
					@foreach($why_learn as $key=>$value)
				 
						<div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Answer </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="why_learn[]" placeholder="Why should you learn" multiple="true">{{$value}}</textarea>
						  <span class="btn btn-inverse btn-circle m-b-5" onclick="remove(this)" style="margin-right: -38px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span>
                        </div>
                      </div>
					  @endforeach
					 <?php }else{ ?>
					 <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Answer</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="why_learn[]" placeholder="Why should you learn" multiple="true"></textarea>
                        </div>
                      </div>
					 <?php } ?>
						<div class="result_why_learn">

						</div>
						<button class="add_why_learn" type="button" style="margin-top: 1px;float: right;margin-right: 95px;">Add More</button>
                      
					  
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">                          
						 
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
				   <h3>Course Curriculum<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" action="" method="post" onsubmit="return SEOController.editSaveCurriculum(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multiform/data-from">

                      <div class="form-group">   
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Curriculum <span class="required">*</span></label>					  
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="file" class="form-control col-md-7 col-xs-12 disabled"  name="course_curriculum" accept=".csv" <?php if(count($coursecurriculum)>0 && !empty($coursecurriculum)){ ?> disabled  <?php } ?> placeholder="Enter coure Curriculum">
                        </div>
                      </div> 
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">                          
						 
                          <?php if(count($coursecurriculum)>0 && !empty($coursecurriculum)){ ?>		
							<?php }else{?>
											<button type="submit" class="btn btn-success" name="submit">Submit</button>
							<?php } ?>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div> 
			  
			  
				<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">  
					<div class="col-md-7">
					<h3>View Course Curriculum<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>
					</div>
					<div class="clearfix"></div>
					</div>				   
					  <div class="x_content">        
					  <div class="control-label col-md-2 col-sm-3 col-xs-12"></div>	
					  <div class="col-md-8 col-sm-8 col-xs-12">
						<div class="card-box table-responsive">
					   
						
						<table id="datatable-course-curriculum" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						  <thead>
							<tr>  
                            @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_course_curriculum'))		
                            
                            <?php if($edit_data->course_curriculum){ ?>		
                            
                            <?php }else{ ?>
                            <th>Content <a href="javascript:SEOController.courseContentDelete('<?php echo $edit_data->id; ?>')" title="delete course content" style="float: right;margin-right: 41px;" class="btn btn-danger">Delete</a></th>
                            <?php } ?>
                            @endif

														
							</tr>
						  </thead>
							<tbody>
							<?php if($coursecurriculum){
								$i=0;
								foreach($coursecurriculum as $course){
								$i++;
								?>
							<tr>						 
							<td>							 
							<div class="lms-accordian">
							<button class="paccordion" style="font-weight: 700;font-size: 13px;">							 
							<?php echo str_replace('?','',$course->heading); ?></button>
							<div class="panel">
							<ul>						 
							 <?php 
							$contents = App\CourseCurriculumExcel::where('heading_id',$course->id)->get();
							 if($contents){						 
								 
								 foreach($contents as $content){ ?>
									<li style="font-size: 13px;"> <?php echo str_replace('?','',$content->coursescontent); ?></li>
									 <?php 
										$subcontents = App\CourseCurriculumExcel::where('content_id',$content->id)->get();
										if($subcontents){
											
											foreach($subcontents as $sub){ ?>
											<ul><li style="font-size: 12px;">  <?php echo str_replace('?','',$sub->subcontent); ?></li>
											
										 <?php 
										$lastcontents = App\CourseCurriculumExcel::where('subcontent_id',$sub->id)->get();
										if($lastcontents){										
											foreach($lastcontents as $last){
											?><ul><li style="font-size: 11px;"><?php echo str_replace('?','',$last->lastcontent); ?></li>
											
											<ul>
											<?php 
										$aboutLevel4 = App\CourseCurriculumExcel::where('endcontent_id',$last->id)->get();
										if($aboutLevel4){										
											foreach($aboutLevel4 as $level4){
											?>
										<li style="font-size: 11px;"><?php echo str_replace('?','',$level4->endcontent); ?></li>
											<?php }  } ?>
											</ul>
											</ul><?php } } ?></ul>	
									<?php 			
											}
										}
									?> 								 
									
							 <?php }
							 }
	 
							 ?>
							 </ul>
							</div>			
						
						</div>							 
							</td>	
							</tr>
							<?php } } ?>
							</tbody>
						</table>
						 
						
					  </div>
					  
					  </div>
					  </div>
					</div>
              </div>
			  
			  


			  
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
					<h1> Course Topic </h1>  			 	         
				 
					</div>
					<div class="x_content">                    
						<form  data-parsley-validate method="post" class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return SEOController.editSaveCourseSeoTopic(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
                         
							<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Enrolled Amount<span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="enrolled" value="{{ old('enrolled',(isset($edit_data)) ? $edit_data->enrolled:"")}}" placeholder="Enter enrolled">
							@error('enrolled')
							<span class="text-danger">{{ $message }}</span>
							@enderror
							</div>
							</div>

							<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Price <span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="price" value="{{ old('price',(isset($edit_data)) ? $edit_data->price:"")}}" placeholder="Enter price">
							@error('price')
							<span class="text-danger">{{ $message }}</span>
							@enderror
							</div>
							</div>

						<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="offer">
        Offer <span class="required">*</span>
    </label>
    <div class="col-md-8 col-sm-8 col-xs-12">

        @php
            $offers = ['10%','15%','20%','25%','30%','35%','40%','45%','50%','55%','60%'];
            $selectedOffer = old('offer', isset($edit_data) ? $edit_data->offer : '');
        @endphp

        <select class="form-control col-md-7 col-xs-12" name="offer" id="offer" >
            <option value="" {{ $selectedOffer == '' ? 'selected' : '' }}>Select Offer</option>
            @foreach($offers as $offer)
                <option value="{{ $offer }}" {{ $selectedOffer == $offer ? 'selected' : '' }}>
                    {{ $offer }}
                </option>
            @endforeach
        </select>

        @error('offer')
            <span class="text-danger">{{ $message }}</span>
        @enderror

    </div>
</div>



					
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="duration_hours">
        Course Duration(Hrs) <span class="required">*</span>
    </label>
    <div class="col-md-8 col-sm-8 col-xs-12">

         @php
    $durations = [
        '30hrs','40hrs','50hrs','60hrs','70hrs','80hrs','90hrs',
        '100hrs','110hrs','120hrs','130hrs','140hrs','150hrs',
        '160hrs','170hrs','180hrs','200hrs'
    ];

    $rawDuration = old('duration_hours', isset($edit_data) ? $edit_data->duration_hours : '');

    // Normalize: if DB stores "40" but options are "40hrs", append suffix
    $selectedDuration = $rawDuration;
    if ($rawDuration !== '' && !str_ends_with((string) $rawDuration, 'hrs')) {
        $selectedDuration = $rawDuration . 'hrs';
    }
@endphp

<select class="form-control col-md-7 col-xs-12" name="duration_hours" id="duration_hours">
    <option value="" {{ $selectedDuration == '' ? 'selected' : '' }}>Select Duration</option>
    @foreach($durations as $duration)
        <option value="{{ $duration }}" {{ (string) $selectedDuration === (string) $duration ? 'selected' : '' }}>
            {{ $duration }}
        </option>
    @endforeach
</select>

@error('duration_hours')
    <span class="text-danger">{{ $message }}</span>
@enderror

    </div>
</div>



						
<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="mode">
        Mode <span class="required">*</span>
    </label>
    <div class="col-md-8 col-sm-8 col-xs-12">

        @php
            $modes = [
                'Live Online Class',
                'Live Online Class with Recording',
                'Recorded Class',
                'Offline Classroom Training',
                'One-to-One Class',
                'Online One-to-One Class',
                'Offline One-to-One Class',
                'Hybrid Class',
                'Self-Paced Learning',
                'Weekend Class',
                'Weekday Class',
                'Fast Track Class',
                'Crash Course',
                'Group Class',
                'Corporate Training',
                'Home Tuition',
                'On-Site Training',
            ];

            // old('mode') returns an array for multi-selects; fall back to edit_data (decode if stored as JSON)
            $selectedModes = old('mode');
            if (!$selectedModes) {
                if (isset($edit_data) && !empty($edit_data->mode)) {
                    $decoded = json_decode($edit_data->mode, true);
                    $selectedModes = is_array($decoded) ? $decoded : [$edit_data->mode];
                } else {
                    $selectedModes = [];
                }
            }
        @endphp

        <select class="form-control col-md-7 col-xs-12 select_skills" name="mode[]" id="mode" multiple >
            @foreach($modes as $m)
                <option value="{{ $m }}" {{ in_array($m, $selectedModes) ? 'selected' : '' }}>
                    {{ $m }}
                </option>
            @endforeach
        </select>

        @error('mode')
            <span class="text-danger">{{ $message }}</span>
        @enderror

    </div>
</div>

							

<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="certificate">
        Certificate <span class="required">*</span>
    </label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        @php
            $certificateTypes = [
                'included'                  => 'Included',
                'included-free'             => 'Included (Free)',
                'included-with-payment'     => 'Included with Payment',
                'third-party-certificate'   => 'Third-Party Certificate',
                'exam-required'             => 'Exam Required',
                'exam-fee-extra'            => 'Exam Fee Extra',
                'optional-certificate'      => 'Optional Certificate',
                'paid-certificate'          => 'Paid Certificate',
                'free-certificate'          => 'Free Certificate',
                'completion-certificate'    => 'Completion Certificate',
                'participation-certificate' => 'Participation Certificate',
                'professional-certificate'  => 'Professional Certificate',
                'industry-certificate'      => 'Industry Certificate',
                'vendor-certificate'        => 'Vendor Certificate',
                'government-certificate'    => 'Government Certificate',
                'international-certificate' => 'International Certificate',
                'accredited-certificate'    => 'Accredited Certificate',
                'digital-certificate'       => 'Digital Certificate',
                'physical-certificate'      => 'Physical Certificate',
                'certificate-not-included'  => 'Certificate Not Included',
                'no-certificate'            => 'No Certificate',
            ];
            $selectedCertificate = old('certificate', isset($edit_data) ? $edit_data->certificate : '');
        @endphp

        <select class="form-control col-md-7 col-xs-12" name="certificate" id="certificate" >
            <option value="" {{ $selectedCertificate == '' ? 'selected' : '' }}>Select Certificate Type</option>
            @foreach($certificateTypes as $value => $label)
                <option value="{{ $value }}" {{ $selectedCertificate == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('certificate')
            <span class="text-danger">{{ $message }}</span>
        @enderror

    </div>
</div>





						<div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="level">
        Level <span class="required">*</span>
    </label>
    <div class="col-md-8 col-sm-8 col-xs-12">

        @php
            $levels = [
                'beginner'     => 'Beginner',
                'intermediate' => 'Intermediate',
                'advanced'     => 'Advanced',
                'allLevels'    => 'All Levels',
            ];
            $selectedLevel = old('level', isset($edit_data) ? $edit_data->level : '');
        @endphp

        <select class="form-control col-md-7 col-xs-12" name="level" id="level" >
            <option value="" {{ $selectedLevel == '' ? 'selected' : '' }}>Select Level</option>
            @foreach($levels as $value => $label)
                <option value="{{ $value }}" {{ $selectedLevel == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('level')
            <span class="text-danger">{{ $message }}</span>
        @enderror

    </div>
</div>

			 
 
					

					
							
						 
							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Live project<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" type="text" onkeypress="return isNumericKeyCheck(event);" name="live_project" value="{{ old('live_project',(isset($edit_data)) ? $edit_data->live_project:"")}}"  placeholder="Enter Live project">
							     @error('live_project')
            <span class="text-danger">{{ $message }}</span>
        @enderror
							</div>
							</div> 

							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Professionals Trained</label>
							<div class="col-md-8 col-sm-8 col-xs-12"> 
							<input class="form-control col-md-7 col-xs-12" type="text" onkeypress="return isNumericKeyCheck(event);" name="professional_trained" value="{{ old('professional_trained',(isset($edit_data->professional_trained) && $edit_data->professional_trained!==0) ? $edit_data->professional_trained:$speciality->professionals_trained)}}"  placeholder="Enter Professional trained">
							     @error('professional_trained')
            <span class="text-danger">{{ $message }}</span>
        @enderror
							</div>
							</div> 
							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Batches every month</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" type="text" name="batches_every_month" onkeypress="return isNumericKeyCheck(event);" value="{{ old('batches_every_month',(isset($edit_data->batches_every_month) && $edit_data->batches_every_month!==0) ? $edit_data->batches_every_month:$speciality->batches)}}"  placeholder="Enter Batches every month">
							     @error('batches_every_month')
            <span class="text-danger">{{ $message }}</span>
        @enderror
							</div>
							</div> 
 
							 
						 

                      
													
													
													
							<div class="form-group">
								<label for="skills" class="control-label col-md-2 col-sm-3 col-xs-12">Tools & Technologies</label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<select id="skills" class="form-control col-md-7 col-xs-12 select_skills" name="skills[]" multiple>
										<option value=""></option>
										<?php
										// Safe decode: always returns a real array, never a stdClass
										$courses_module = [];
										if (!empty($edit_data) && !empty($edit_data->skills)) {
											$decoded = json_decode($edit_data->skills, true);
											if (is_array($decoded)) {
												// normalize to ints so in_array comparisons never fail on type mismatch
												$courses_module = array_map('intval', $decoded);
											}
										}

										if (!empty($tools_list)) {
											foreach ($tools_list as $course) {
												$isSelected = in_array($course->name, $courses_module, true);
												?>
												<option value="<?php echo $course->name; ?>" <?php echo $isSelected ? 'selected' : ''; ?>>
													<?php echo $course->name; ?>
												</option>
												<?php
											}
										}
										?>
									</select>
										@error('skills')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
							</div>
					 
						
						 
							
							<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success" onclick="check(this)">Submit</button>
							</div>
							</div>

						</form>
					  </div>
                </div>
              </div>
		

			  
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>FAQ Course<small></small></h3>
                    <div class="successFAQs"></div><div class="errorFAQs"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return SEOController.editSaveFAQ(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					
					
					<?php if(!empty($edit_data->FAQs)){
					$FAQs =json_decode($edit_data->FAQs);                    
					$faqquestion  = json_decode($FAQs->faqq);					 
					$faqanswer  = json_decode($FAQs->faqa); 					 
					 for($i=0; $i<count($faqquestion); $i++){						 
					 ?>
					 <div>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Question <?php echo $i+1; ?> <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" value="<?php echo (isset($faqquestion[$i])? $faqquestion[$i]:""); ?>" placeholder="FAQ Question 1"> 
					 
							 
					</div>
					</div>
				 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Answer <?php echo $i+1; ?><span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12" type="text" name="faqa[]" placeholder="Enter FAQ Answer 1" ><?php echo (isset($faqanswer[$i])? $faqanswer[$i]:""); ?></textarea>
					</div>
					</div>	
					<span class="btn btn-inverse btn-circle m-b-5" onclick="removefaq(this)" style="margin-right: 132px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span>
					</div>	
										
					 <?php   }  }else{ ?> 
					 <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Question <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" value="" placeholder="FAQ Question 1"> 
					@if ($errors->has('faqq[]'))
								<small class="error alert-danger">{{ $errors->first('faqq[]') }}</small>
								@endif
					</div>
					</div>
				 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Answer <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12" type="text" name="faqa[]" placeholder="Enter FAQ Answer 1"></textarea>
					</div>
					</div>	
					 <?php  } ?>
					<div class="addfqa">					
					</div>					
					<button class="add_more_stream" type="button" style="margin-top: 0px;float: right;margin-right: 5px;">Add More</button>                     
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  
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
                    <h3>Reviews<small></small></h3>
                    <div class="successFAQs"></div><div class="errorFAQs"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return SEOController.editSaveTestimonial(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					 <?php if(!empty($edit_data->testimonial)){
						 $testimonials =json_decode($edit_data->testimonial);                    
					 $name  = json_decode($testimonials->name);
					 
					 $comment  = json_decode($testimonials->comment);
 					 if(!empty($testimonials->linkedinurl)){
					$linkedinurl  = json_decode($testimonials->linkedinurl);
					}else{
						$linkedinurl="";
					}
					
					 for($i=0; $i<count($name); $i++){						 
					 ?>
					 <div>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Name <?php echo $i+1; ?> <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="name[]" value="<?php echo (isset($name[$i])? $name[$i]:""); ?>" placeholder="Enter Name"> 
					 
							 
					</div>
					</div>
				 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Comment <?php echo $i+1; ?><span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12" type="text" name="comment[]" placeholder="Enter Comment" ><?php echo (isset($comment[$i])? $comment[$i]:""); ?></textarea>
					</div>
					</div>
					
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Linkedin <?php echo $i+1; ?> <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="linkedinurl[]" value="<?php echo (isset($linkedinurl[$i])? $linkedinurl[$i]:""); ?>" placeholder="Enter linkedin url"> 							 
					</div>
					</div>
					
					
					<span class="btn btn-inverse btn-circle m-b-5" onclick="removefaq(this)" style="margin-right: 132px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span>
					</div>	
										
					 <?php   }  }else{ ?> 
					 <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Name<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="name[]" value="" placeholder="Enter Name"> 
					@if ($errors->has('name[]'))
								<small class="error alert-danger">{{ $errors->first('name[]') }}</small>
								@endif
					</div>
					</div>
				 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Comment<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12" type="text" name="comment[]" placeholder="Enter Comment"></textarea>
					</div>
					</div>
					
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Linkedin <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="linkedinurl[]" value="" placeholder="Enter linkedin url"> 							 
					</div>
					</div>
					
					 <?php  } ?>
					<div class="addtestimonial">					
					</div>					
					<button class="add_more_testimonial" type="button" style="margin-top: 0px;float: right;margin-right: 5px;">Add More</button>  
					
					<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Testimonial Visibility*<span class="required">*</span></label></div>
						<div class="col-12 col-md-3">
						Yes
						<input type="radio" name="testimonial_visibility" value="1"  @if (1== old('testimonial_visibility'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->testimonial_visibility == 1 ) ? "checked":"" }} @endif>	
						</div>
						<div class="col-12 col-md-3">
						No
						<input type="radio" name="testimonial_visibility" value="0"  @if ('0'== old('testimonial_visibility'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->testimonial_visibility == '0' ) ? "checked":"" }} @endif>
						</div>
					</div> 	
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			  
			  <?php if(!empty($edit_data->certification_visibility)) { ?>
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Certification Show Section<small></small></h3>
                    <div class="successFAQs"></div><div class="errorFAQs"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                       <?php $certificate =App\Course::select('exam_title','exam_text','format','certification_type','delivery_method','certification_time','certification_cost','language','certification_visibility')->where('id',$edit_data->course_clone_id)->first();	
 
					?>
                    
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return SEOController.editSaveCourseCertificate(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					  
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Certification heading <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="exam_title" value="<?php if($edit_data->exam_title){ echo $edit_data->exam_title; }else{ echo (isset($certificate)? $certificate->exam_title:""); } ?>" placeholder="Global Certification heading"> 
					</div>
					</div>
				 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Certification text<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12" type="text" name="exam_text" placeholder="Enter Certification text"><?php if($edit_data->exam_text){ echo $edit_data->exam_text; }else{ echo (isset($certificate)? $certificate->exam_text:""); } ?></textarea>
					</div>
					</div>		 
					 
					 <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Format <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="format" value="<?php if($edit_data->format){ echo $edit_data->format; }else{ echo (isset($certificate)? $certificate->format:""); } ?>" placeholder="Enter format"> 
					</div>
					</div>
				 
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Type<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="certification_type" value="<?php if($edit_data->certification_type){ echo $edit_data->certification_type; }else{ echo (isset($certificate)? $certificate->certification_type:""); }  ?>" placeholder="Enter Type">
					</div>
					</div>
					 
					 <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Delivery Method<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="delivery_method" value="<?php if($edit_data->delivery_method){ echo $edit_data->delivery_method; }else{ echo (isset($certificate)? $certificate->delivery_method:""); }  ?>" placeholder="Enter Delivery Method">
					</div>
					</div>
					 
					 <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Time<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="certification_time" value="<?php if($edit_data->certification_time){ echo $edit_data->certification_time; }else{ echo (isset($certificate)? $certificate->certification_time:""); }  ?>" placeholder="Enter Time">
					</div>
					</div>
					 
					 <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Cost<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="certification_cost" value="<?php if($edit_data->certification_cost){ echo $edit_data->certification_cost; }else{ echo (isset($certificate)? $certificate->certification_cost:""); } ?>" placeholder="Enter Cost">
					</div>
					</div>
					 
					  
					 <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Language<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="language" value="<?php if($edit_data->language){ echo $edit_data->language; }else{ echo (isset($certificate)? $certificate->language:""); } ?>" placeholder="Enter Language">
					</div>
					</div>
					 
					<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Certification Visibility*<span class="required">*</span></label></div>
						<div class="col-12 col-md-3">
						Yes
						<input type="radio" name="certification_visibility" value="1"  @if ($edit_data->certification_visibility == '1')
								checked="checked"	
							@else
							{{ (isset($certificate) && $certificate->certification_visibility == 1  ) ? "checked":"" }} @endif>	
						</div>
						<div class="col-12 col-md-3">
						No
						<input type="radio" name="certification_visibility" value="0"  @if ($edit_data->certification_visibility == '0')
								checked="checked"	
							@else
							{{ (isset($certificate) && $certificate->certification_visibility == '0' ) ? "checked":"" }} @endif>
						</div>
					</div> 		
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">                      
						 
                          <!--<button type="submit" class="btn btn-success">Submit</button>-->
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			  
			  
			  <?php } ?>

			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <div class="succescourseRelated"></div><div class="errorcourseRelated"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return SEOController.editSaveCourseRelated(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					
					
					<!--<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Show Related Courses (Sidebar)<span class="required">*</span></label>
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
					-->
					
				
					
					 
					 
				        <!-- <div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Home Page?<span class="required">*</span></label></div>
						<div class="col-12 col-md-3">
						Yes
						<input type="radio" name="show_front_page" value="1"  @if (1== old('show_front_page'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_front_page == 1 ) ? "checked":"" }} @endif>	
						</div>
						<div class="col-12 col-md-3">
						No
						<input type="radio" name="show_front_page" value="0"  @if ('0'== old('show_front_page'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_front_page == '0' ) ? "checked":"" }} @endif>
						</div>
						</div> -->

						<!--<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Top Menu?</label></div>
						<div class="col-12 col-md-3">
						Yes
						<input type="radio" name="show_top_menu" value="1"  @if (1== old('show_top_menu'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_top_menu == 1 ) ? "checked":"" }} @endif>	
						</div>
						<div class="col-12 col-md-3">
						No
						<input type="radio" name="show_top_menu" value="0"  @if ('0'== old('show_top_menu'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_top_menu == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>  --> 

						<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Footer?</label></div>
						<div class="col-12 col-md-2">
						Yes
						<input type="radio" name="show_on_footer"  value="1"  @if (1== old('show_on_footer'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_on_footer == 1 ) ? "checked":"" }} @endif>	
						</div>
						 
						<div class="col-12 col-md-2">
						No 
						<input type="radio" name="show_on_footer"  value="0"  @if ('0'== old('show_on_footer'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->show_on_footer == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>  
						 
                     	<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Related Courses</label>
					<div class="col-md-8 col-sm-8 col-xs-12">Please Select 4 Or  8
					<select class="form-control col-md-7 col-xs-12 select_related_courses show_course_releted" name="related_courses[]" multiple>
					<option value=""></option>
				<!--	<?php 					
 			
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

						<?php	} }  } ?>-->
					</select>
					 
					</div>
					</div>
                      
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  
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
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Answer</label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="why_learn[]" placeholder="Why should you learn" multiple="true"></textarea> <span class="btn btn-inverse btn-circle m-b-5" onclick="remove(this)" style="margin-right: -38px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span></div></div></div><br />');   
		maxAppend++;

    $(".result_why_learn").append(addinput);
});
	  
</script>

<script>
function remove(a){
$(a).parent("div").parent("div").remove();
}
</script>
     <script>	  
     
	  var maxAppend = 2;
$(".add_more_stream").click(function(){
    
    if (maxAppend >= 11) return;
    var addinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Question '+maxAppend+' <span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" placeholder="FAQ Question '+maxAppend+'"></div></div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Answer '+maxAppend+'<span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="faqa[] placeholder="Enter FAQ Answer " multiple="true"></textarea></div></div><span class="btn btn-inverse btn-circle m-b-5" onclick="removefaq(this)" style="margin-right: 132px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span></div><br />');
    maxAppend++;

    $(".addfqa").append(addinput);
});
</script>

<script>
function removefaq(a){
$(a).parent("div").remove();
}

</script>


<script>	  
	  var maxtest = 2;
$(".add_more_testimonial").click(function(){
    if (maxtest >= 11) return;

    var testimonialinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Name'+maxtest+' <span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><input class="form-control col-md-7 col-xs-12" type="text" name="name[]" placeholder="Enter Name '+maxtest+'"></div></div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Comment '+maxtest+'<span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="comment[] placeholder="Enter Comment" multiple="true"></textarea></div></div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Linkedin '+maxtest+' <span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><input class="form-control col-md-7 col-xs-12" type="text" name="linkedinurl[]" value="" placeholder="Enter linkedin url"></div></div><span class="btn btn-inverse btn-circle m-b-5" onclick="removetestimonial(this)" style="margin-right: 132px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span></div><br />');
    maxtest++;

    $(".addtestimonial").append(testimonialinput);
});
	  
</script>

<script>
function removetestimonial(a){
$(a).parent("div").remove();
}
</script>

<script>	
	window.onload = function()
	{
		var category_id 	='<?php echo $edit_data->category; ?>';
		var subcategory_id 	= '<?php echo $edit_data->subcategory; ?>';	 
		var course_pdf_text 	= '<?php echo $edit_data->course_pdf_text; ?>';	 
		var course_releted 	= '<?php echo $edit_data->related_courses?>';	 
		get_subcategory(category_id,subcategory_id);	 
		get_categoryPDF(subcategory_id,course_pdf_text);	
		get_seoCourseReleted(category_id,course_releted);	 
	 
	}	 
</script>
 

<script>
function get_seoCourseReleted(cid,cr=""){
	 
	
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "get",	 
	url: "{{URl('admin/course/get_seo_course_releted_edit')}}",
	data: {cid:cid,cr:cr},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_course_releted").html(data);
	}
	});
	 
}
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
  
		<script>
		var acc = document.getElementsByClassName("paccordion");
		var i;

		for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.maxHeight) {
		panel.style.maxHeight = null;
		} else {
		panel.style.maxHeight = panel.scrollHeight + "px";
		} 
		});
		}
		</script>
	
<script>

function showfooter(gst){			
			 
		$('.show_footer_city').show();
				
		}
		
		function nofooter(gstno){	
 		
			$('.show_footer_city').hide();		
		}
</script>

<script>
// function matchYoutubeUrl(url) {
//     var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
//     var matches = url.match(p);
//     if(matches){
//         return matches[1];
//     }
//     return false;
// }
//   function check(sender){
//     var url = $('#youtube').val();
//     var id = matchYoutubeUrl(url);
//     if(id!=false){
//         //alert('True YouTube URL');
//     }else{
//         alert('Incorrect YouTube URL');
//     }
// }
</script>
		<style>
		 .lms-accordian .paccordion {
		background-color: transparent;
		color: #444;
		cursor: pointer;
		padding: 8px;
		width: 100%;
		border: none;
		margin: 0;
		text-align: left;
		outline: none;
		font-size: 15px;
		transition: 0.4s;
		}

		.lms-accordian .paccordion:hover {
		background-color: #ccc;
		}

		.lms-accordian .paccordion:after {
		content: '\002B';
		color: #777;
		font-weight: bold;
		float: left;
		margin-right: 5px;
		}

		.paccordion.active:after {
		content: "\2212";
		}

		.panel {
		padding: 0 18px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
		} 
		</style>




 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script type="text/javascript">
$('.summernote').summernote({
height: 500
});
</script>

@endsection
