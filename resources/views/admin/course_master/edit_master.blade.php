@extends('admin.layouts.app')
@section('title')
Edit Course Master
@endsection
@section('content') 
<div class="right_col" role="main">
          <div class="">            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3> Course Master Title and Rating<small></small></h3>  
				<div class="succesmessage"></div><div class="errormessage"></div>
				@if(Session::has('success')) 	
				<div class="row">
				<div class="col-md-6 col-md-offset-3">
				<div class="alert alert-success">
				<strong>Success!</strong> {{Session::get('success')}}.
				</div>
				</div>
				</div>
				@endif
				@if(Session::has('failed')) 	
				<div class="row">
				<div class="col-md-6 col-md-offset-3">
				<div class="alert alert-danger">
				<strong>!</strong> {{Session::get('failed')}}.
				</div>
				</div>
				</div>
				@endif                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return courseMasterController.editSaveCourseMasterTitle(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">


                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="last-name">Course Name<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" name="course_name"  class="form-control col-md-7 col-xs-12" value="{{ old('course_name',(isset($edit_data)) ? $edit_data->course_name:"")}}"  placeholder="Enter Coure Name"> 
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Titile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="title" value="{{ old('title',(isset($edit_data)) ? $edit_data->title:"")}}" placeholder="Enter coure title">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Sub Titile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="sub_title" value="{{ old('sub_title',(isset($edit_data)) ? $edit_data->sub_title:"")}}" placeholder="Enter Course Sub Title">
                        </div>
                      </div>
					  
					  <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Slug <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="slug"  value="{{ old('slug',(isset($edit_data)) ? $edit_data->slug:"")}}"  placeholder="Enter Coure Slug">
                        </div>
                      </div>
					 
					  
					   <div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
							<select name="category" class="form-control col-md-7 col-xs-12 select_category" onchange="get_subcategory(this.value);">
							<option value="">Select Category</option>
							@if(!empty($cetegories))
							@foreach($cetegories as $category)	
							<option value="<?php  echo $category->categoryid; ?>" @if ($category->categoryid== old('category'))
							selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->category == $category->categoryid ) ? "selected":"" }} @endif> <?php echo $category->categoryname; ?></option>		
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
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Duration(Mths)<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="tel" name="course_duration" onkeypress="return isNumericKeyCheck(event);" value="{{ old('course_duration',(isset($edit_data)) ? $edit_data->course_duration:"")}}"  placeholder="Enter Course Duration">
                        </div>
                      </div> 
					  
				 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Fees<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="tel" name="fees" onkeypress="return isNumericKeyCheck(event);" value="{{ old('fees',(isset($edit_data)) ? $edit_data->fees:"")}}"  placeholder="Enter fees">
                        </div>
                      </div> 
					   
					  
					           
						 
					 
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Keyword<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_keyword" placeholder="Enter Meta Keyword">{{ old('meta_keyword',(isset($edit_data)) ? $edit_data->meta_keyword:"")}}</textarea>
                        </div>
                      </div>
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Description<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_description" placeholder="Enter Meta Description">{{ old('meta_description',(isset($edit_data)) ? $edit_data->meta_description:"")}}</textarea>
                        </div>
                      </div>
					  
 				   <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Short Definition<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="course_description" placeholder="Enter Meta Description">{{ old('course_description',(isset($edit_data)) ? $edit_data->course_description:"")}}</textarea>
                        </div>
                      </div>
                      
 				   <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Salary<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">Heading
                          <input type="text" class="form-control col-md-7 col-xs-12" value="{{ old('salary_heading',(isset($edit_data)) ? $edit_data->salary_heading:"")}}" name="salary_heading" placeholder="Enter Salary heading"> 
                        </div> 
						<div class="col-md-8 col-sm-8 col-xs-12 col-xs-offset-2">Details
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="salary_details" placeholder="Enter salary details">{{ old('salary_details',(isset($edit_data)) ? $edit_data->salary_details:"")}}</textarea>
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Job<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">Heading
                          <input type="text" class="form-control col-md-7 col-xs-12" value="{{ old('job_heading',(isset($edit_data)) ? $edit_data->job_heading:"")}}" name="job_heading" placeholder="Enter Job heading"> 
                        </div> 
						<div class="col-md-8 col-sm-8 col-xs-12 col-xs-offset-2">Details
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="job_details" placeholder="Enter job details">{{ old('job_details',(isset($edit_data)) ? $edit_data->job_details:"")}}</textarea>
                        </div>
                      </div>
 				    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Analytics<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">Heading
                          <input type="text" class="form-control col-md-7 col-xs-12" value="{{ old('analytics_heading',(isset($edit_data)) ? $edit_data->analytics_heading:"")}}" name="analytics_heading" placeholder="Enter Analytics heading"> 
                        </div> 
						<div class="col-md-8 col-sm-8 col-xs-12 col-xs-offset-2">Details
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="analytics_details" placeholder="Enter Analytics details">{{ old('analytics_details',(isset($edit_data)) ? $edit_data->analytics_details:"")}}</textarea>
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
			  
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">  
					<h3>Course Curriculum<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
					<div class="clearfix"></div>
					</div>
					<div class="x_content"> 
						<form class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseCurriculumExcel(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multiform/data-from">

						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Curriculum<span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="file" class="form-control col-md-7 col-xs-12"  name="course_about" accept=".csv" placeholder="Enter coure Curriculum">
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
								@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_master_curriculum'))								
								<th>Content <a href="javascript:courseMasterController.masterCurriculumExcelDelete('<?php echo $edit_data->id; ?>')" title="delete course content" style="float: right;margin-right: 41px;" class="btn btn-danger">Delete</a></th>
								@endif
														
							</tr>
						  </thead>
							
						<tbody>
							<?php 							
							//echo "<pre>";print_r($course_curriculum);die;
							if(!empty($course_curriculum)){
								$i=0;
								foreach($course_curriculum as $course){
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
							$aboutLevel1 = App\MasterCurriculumExcel::where('heading_id',$course->id)->get();
							 if($aboutLevel1){						 
								 
								 foreach($aboutLevel1 as $level1){ ?>
									<li style="font-size: 13px;"> <?php echo str_replace('?','',$level1->level1); ?></li>
									 <?php 
										$aboutLevel2 = App\MasterCurriculumExcel::where('level1_id',$level1->id)->get();
										if($aboutLevel2){
											
											foreach($aboutLevel2 as $level2){ ?>
											<ul><li style="font-size: 12px;">  <?php echo str_replace('?','',$level2->level2); ?></li>
											
										 <?php 
										$aboutLevel3 = App\MasterCurriculumExcel::where('level2_id',$level2->id)->get();
										if($aboutLevel3){										
											foreach($aboutLevel3 as $level3){
											?><ul>
											<li style="font-size: 11px;"><?php echo str_replace('?','',$level3->level3); ?></li>
											<ul>
											<?php 
										$aboutLevel4 = App\MasterCurriculumExcel::where('level3_id',$level3->id)->get();
										if($aboutLevel4){										
											foreach($aboutLevel4 as $level4){
											?>
										<li style="font-size: 11px;"><?php echo str_replace('?','',$level4->level4); ?></li>
										
										<ul>
											<?php 
										$aboutLevel5 = App\MasterCurriculumExcel::where('level4_id',$level4->id)->get();
										if($aboutLevel5){										
											foreach($aboutLevel5 as $level5){
											?>
										<li style="font-size: 11px;"><?php echo str_replace('?','',$level5->level5); ?></li>
										
										<ul>
											<?php 
										$aboutLevel6 = App\MasterCurriculumExcel::where('level5_id',$level5->id)->get();
										if($aboutLevel6){										
											foreach($aboutLevel6 as $level6){
											?>
										<li style="font-size: 11px;"><?php echo str_replace('?','',$level6->level6); ?></li>
										
										
										<ul>
											<?php 
										$aboutLevel7 = App\MasterCurriculumExcel::where('level6_id',$level6->id)->get();
										if($aboutLevel7){										
											foreach($aboutLevel7 as $level7){
											?>
										<li style="font-size: 11px;"><?php echo str_replace('?','',$level7->level7); ?></li>
										
											 
										
											<?php }  } ?>
											</ul>
										
											<?php }  } ?>
											</ul>
										
											<?php }  } ?>
											</ul>
										
											<?php }  } ?>
											</ul>
											
											</ul>
											<?php } } ?>
											</ul>	
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
                       <h3>About Master Course<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseMasterAbout(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">

                      <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 1<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="course_heading1" value="{{ old('course_heading1',(isset($edit_data)) ? $edit_data->course_heading1:"")}}" placeholder="Enter Heading 1">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 1 Details <span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12"  name="course_heading_details1" placeholder="Enter Heading 1 Details">{{ old('course_heading_details1',(isset($edit_data)) ? $edit_data->course_heading_details1:"")}}</textarea>
                        </div>
                      </div> 
					  
					  
					 
					  
					<?php 
					
				 
					  if(!empty($edit_data->paragraph)){
					  $paragraphs = json_decode($edit_data->paragraph); 
 					  				$i=0;	 
					?>	
					@foreach($paragraphs as $key=>$value)
					  <?php $i++; ?>
						<div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph <?php echo $i; ?></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="paragraph[]" placeholder="Paragraph" multiple="true">{{$value}}</textarea>
						 
                        </div>
						 <span class="btn btn-inverse btn-circle m-b-5" onclick="remove(this)" style="margin-right:132px;color: red;float: right;margin-top:25px;"><i class="glyphicon glyphicon-trash"></i></span>
                      </div>
					  @endforeach
					 <?php }else{ ?>
					 <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 1</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="paragraph[]" placeholder="paragraph 1" multiple="true"></textarea>
                        </div>
                      </div>
					 <?php } ?>
						<div class="result_paragraph">

						</div>
						<button class="add_paragraph" type="button" style="margin-top: -28px;float: right;margin-right: 45px;">Add More</button>
						

					   <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 2<span class="required">*</span></label>					  
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="course_heading2" value="{{ old('course_heading2',(isset($edit_data)) ? $edit_data->course_heading2:"")}}" placeholder="Enter Heading 2">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 2 Details <span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12"  name="course_heading_details2" placeholder="Enter Heading 2 Details">{{ old('course_heading_details2',(isset($edit_data)) ? $edit_data->course_heading_details2:"")}}</textarea>
                        </div>
                      </div> 
					
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">

					<div class="col-md-1 col-sm-1 col-xs-12">
					<img src="{{asset('public/image/Web_Icon.png')}}">
					</div>
					<div class="col-md-11 col-sm-11 col-xs-12">

					<input type="text" name="professionals" class="form-control col-md-7 col-xs-12" value="{{ old('professionals',(isset($edit_data)) ? $edit_data->professionals:"")}}" placeholder="Enter Professionals data">
					</div>
					</div>
					</div>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">

					<div class="col-md-1 col-sm-1 col-xs-12">
					<img src="{{asset('public/image/Brain.png')}}">
					</div>
					<div class="col-md-11 col-sm-11 col-xs-12">

					<input type="text" name="beginners" class="form-control col-md-7 col-xs-12"  value="{{ old('beginners',(isset($edit_data)) ? $edit_data->beginners:"")}}" placeholder="Enter Beginners data">
					</div>
					</div>
					</div>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">

					<div class="col-md-1 col-sm-1 col-xs-12">
					<img src="{{asset('public/image/Polygon.png')}}">
					</div>
					<div class="col-md-11 col-sm-11 col-xs-12">

					<input type="text" name="polygon" class="form-control col-md-7 col-xs-12"  value="{{ old('polygon',(isset($edit_data)) ? $edit_data->polygon:"")}}" placeholder="Enter Polygon data">
					</div>
					</div>
					</div>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">

					<div class="col-md-1 col-sm-1 col-xs-12">
					<img src="{{asset('public/image/Analytics.png')}}">
					</div>
					<div class="col-md-11 col-sm-11 col-xs-12">

					<input type="text" name="scope" class="form-control col-md-7 col-xs-12"  value="{{ old('scope',(isset($edit_data)) ? $edit_data->scope:"")}}" placeholder="Enter Scope data">
					</div>
					</div>
					</div>
					
					 
				 
					  
					  
					   <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 3<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="course_heading3" value="{{ old('course_heading3',(isset($edit_data)) ? $edit_data->course_heading3:"")}}" placeholder="Enter Heading 3">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 3 Details <span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12"  name="course_heading_details3" placeholder="Enter Heading 3 Details">{{ old('course_heading_details3',(isset($edit_data)) ? $edit_data->course_heading_details3:"")}}</textarea>
                        </div>
                      </div> 
					  <div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">

					<div class="col-md-1 col-sm-1 col-xs-12">
					<img src="{{asset('public/image/mp-Icon_1.png')}}" width="50px">
					</div>
					<div class="col-md-11 col-sm-11 col-xs-12">

					<input type="text" name="growth" class="form-control col-md-7 col-xs-12" value="{{ old('growth',(isset($edit_data)) ? $edit_data->growth:"")}}" placeholder="Enter course growth data">
					</div>
					</div>
					</div>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">

					<div class="col-md-1 col-sm-1 col-xs-12">
					<img src="{{asset('public/image/mp-Icon_2.png')}}" width="50px">
					</div>
					<div class="col-md-11 col-sm-11 col-xs-12">

					<input type="text" name="analytic" class="form-control col-md-7 col-xs-12"  value="{{ old('analytic',(isset($edit_data)) ? $edit_data->analytic:"")}}" placeholder="Enter analytic data">
					</div>
					</div>
					</div>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">

					<div class="col-md-1 col-sm-1 col-xs-12">
					<img src="{{asset('public/image/mp-Icon_3.png')}}" width="50px">
					</div>
					<div class="col-md-11 col-sm-11 col-xs-12">

					<input type="text" name="structure" class="form-control col-md-7 col-xs-12"  value="{{ old('structure',(isset($edit_data)) ? $edit_data->structure:"")}}" placeholder="Enter data">
					</div>
					</div>
					</div>
					   <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 4<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="course_heading4" value="{{ old('course_heading4',(isset($edit_data)) ? $edit_data->course_heading4:"")}}" placeholder="Enter Heading 4">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 4 Details <span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12"  name="course_heading_details4" placeholder="Enter Heading 4 Details">{{ old('course_heading_details4',(isset($edit_data)) ? $edit_data->course_heading_details4:"")}}</textarea>
                        </div>
                      </div> 
					  
					    
					<?php 				 
					  if(!empty($edit_data->masterparagraph)){
					  $masterparagraphs = json_decode($edit_data->masterparagraph); 
 					  				$j=0;	 
					?>	
					@foreach($masterparagraphs as $key=>$value)
					  <?php $j++; ?>
						<div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph <?php echo $j; ?></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="masterparagraph[]" placeholder="Paragraph" multiple="true">{{$value}}</textarea>
						 
                        </div>
						 <span class="btn btn-inverse btn-circle m-b-5" onclick="remove(this)" style="margin-right:132px;color: red;float: right;margin-top:25px;"><i class="glyphicon glyphicon-trash"></i></span>
                      </div>
					  @endforeach
					 <?php }else{ ?>
					 <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 1</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="masterparagraph[]" placeholder="paragraph 1" multiple="true"></textarea>
                        </div>
                      </div>
					 <?php } ?>
						<div class="result_masterparagraph">

						</div>
						<button class="add_masterparagraph" type="button" style="margin-top: -28px;float: right;margin-right: 45px;">Add More</button>
					  
					  
					  
					  
					   <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 5</label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="course_heading5" value="{{ old('course_heading5',(isset($edit_data)) ? $edit_data->course_heading5:"")}}" placeholder="Enter Heading 5">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading 5 Details </label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12"  name="course_heading_details5" placeholder="Enter Heading 5 Details">{{ old('course_heading_details5',(isset($edit_data)) ? $edit_data->course_heading_details5:"")}}</textarea>
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
                       <h3>Tools Covered Image <span class="required">*</span><small>Please Select 6 Or 12</small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseToolsCovered(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">
					<?php 					

					if(!empty($edit_data->tools_covered)){	

					$tools_covered = json_decode($edit_data->tools_covered);	
					}else{
					$tools_covered=array();
					}
					if(!empty($tools_covered_list) ){						 	
					foreach($tools_covered_list as $tools){

					if(in_array($tools->id, $tools_covered)){
					?>
					<div class="col-md-3 col-sm-3 col-xs-3">
					<input type="checkbox" name="tools_covered[]" checked value="<?php echo $tools->id ?>" style="width: 37px;height: 20px;"><?php echo $tools->name; ?>
					</div>
					<?php } else{ ?>
					 
					<div class="col-md-3 col-sm-3 col-xs-3">

					<input type="checkbox" name="tools_covered[]" value="<?php echo $tools->id ?>" style="width: 37px;height: 20px;"><?php echo $tools->name; ?>
					</div>
					<?php	} }  } ?>
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
                       <h3>Recrutment Partners<span class="required">*</span><small>Please Select 5 Or 10</small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseClients(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12"> </label>	
					<div class="col-md-10 col-sm-10 col-xs-12">
					<?php 					

					if(!empty($edit_data->clients)){	

					$clients = json_decode($edit_data->clients);	
					}else{
					$clients=array();
					}
					if(!empty($client_list) ){						 	
					foreach($client_list as $recurt_client){

					if(in_array($recurt_client->id, $clients)){
					?>
					<div class="col-md-3 col-sm-3 col-xs-3">
					<input type="checkbox" name="clients[]" checked value="<?php echo $recurt_client->id ?>" style="width: 37px;height: 20px;"><?php echo $recurt_client->name; ?>
					</div>
					<?php } else{ ?>
					 
					<div class="col-md-3 col-sm-3 col-xs-3">

					<input type="checkbox" name="clients[]" value="<?php echo $recurt_client->id ?>" style="width: 37px;height: 20px;"><?php echo $recurt_client->name; ?>
					</div>
					<?php	} }  } ?>
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
                       <h3>Course Structure<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseStructure(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
 
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Duration Hours<span class="required">*</span></label>					  
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="duration_hours" maxlength="3" onkeypress="return isNumericKeyCheck(event);" value="{{ old('duration_hours',(isset($edit_data)) ? $edit_data->duration_hours:"")}}"  placeholder="Enter Duration in hours"> 
                        </div>
                      </div>  
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Assigments<span class="required">*</span></label>					  
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="assigment" maxlength="2" onkeypress="return isNumericKeyCheck(event);" value="{{ old('assigment',(isset($edit_data)) ? $edit_data->assigment:"")}}"  placeholder="Enter Assigment"> 
                        </div>
                      </div> 
					    
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">project<span class="required">*</span></label>					  
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="project" maxlength="2" onkeypress="return isNumericKeyCheck(event);" value="{{ old('project',(isset($edit_data)) ? $edit_data->project:"")}}"  placeholder="Enter project no"> 
                        </div>
                      </div>  

					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Live project<span class="required">*</span></label>					  
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="live_project" maxlength="2" onkeypress="return isNumericKeyCheck(event);" value="{{ old('live_project',(isset($edit_data)) ? $edit_data->live_project:"")}}"  placeholder="Enter Live project"> 
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
                       <h3>Placement & Recrutment<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseMasterPlacement(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">

                      <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Careers And Salaries<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12"  name="careers_salaries" placeholder="Enter Careers And Salaries">{{ old('careers_salaries',(isset($edit_data)) ? $edit_data->careers_salaries:"")}}</textarea>
                        </div>
                      </div>  


				<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement 1<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12 "  name="placement1" value="{{ old('placement1',(isset($edit_data)) ? $edit_data->placement1:"")}}" placeholder="Enter Placement Heading 1">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement Details 1<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12"  name="placement_details1" placeholder="Enter Placement Details 1">{{ old('placement_details1',(isset($edit_data)) ? $edit_data->placement_details1:"")}}</textarea>
                        </div>
                      </div> 
					   <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement 2<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="placement2" value="{{ old('placement2',(isset($edit_data)) ? $edit_data->placement2:"")}}" placeholder="Enter Placement Heading 2">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement Details 2 <span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 "  name="placement_details2" placeholder="Enter placement Details 2">{{ old('placement_details2',(isset($edit_data)) ? $edit_data->placement_details2:"")}}</textarea>
                        </div>
                      </div> 
					   <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement 3<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="placement3" value="{{ old('placement3',(isset($edit_data)) ? $edit_data->placement3:"")}}" placeholder="Enter placement heading 3 ">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement Details 3<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 "  name="placement_details3" placeholder="Enter Placement Details 3">{{ old('placement_details3',(isset($edit_data)) ? $edit_data->placement_details3:"")}}</textarea>
                        </div>
                      </div> 
					   <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement 4<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="placement4" value="{{ old('placement4',(isset($edit_data)) ? $edit_data->placement4:"")}}" placeholder="Enter Placement heading 4">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement Details 4<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 "  name="placement_details4" placeholder="Enter Placement details 4">{{ old('placement_details4',(isset($edit_data)) ? $edit_data->placement_details4:"")}}</textarea>
                        </div>
                      </div> 
					 

						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement 5<span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="placement5" value="{{ old('placement5',(isset($edit_data)) ? $edit_data->placement5:"")}}" placeholder="Enter Placement Heading 5">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement Details 5 <span class="required">*</span></label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 "  name="placement_details5" placeholder="Enter Placement details 5">{{ old('placement_details5',(isset($edit_data)) ? $edit_data->placement_details5:"")}}</textarea>
                        </div>
                      </div> 

						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement 6</label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="placement6" value="{{ old('placement6',(isset($edit_data)) ? $edit_data->placement6:"")}}" placeholder="Enter Placement Heading 6">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement Details 6 </label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 "  name="placement_details6" placeholder="Enter placement details 6">{{ old('placement_details6',(isset($edit_data)) ? $edit_data->placement_details6:"")}}</textarea>
                        </div>
                      </div> 	


					<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement 7</label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="placement7" value="{{ old('placement7',(isset($edit_data)) ? $edit_data->placement7:"")}}" placeholder="Enter Placement Heading 7">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement Details 7 </label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 "  name="placement_details7" placeholder="Enter placement details 7">{{ old('placement_details7',(isset($edit_data)) ? $edit_data->placement_details7:"")}}</textarea>
                        </div>
                      </div> 

					<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement 8</label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="placement8" value="{{ old('placement8',(isset($edit_data)) ? $edit_data->placement8:"")}}" placeholder="Enter Placement Heading 8">
                        </div>
                      </div> 
					  
					  <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Placement Details 8 </label>					  
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12"  name="placement_details8" placeholder="Enter placement details 8">{{ old('placement_details8',(isset($edit_data)) ? $edit_data->placement_details8:"")}}</textarea>
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
 
			  
			   
			  <!--
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">                    
                    <div class="succeCurriculum"></div><div class="errorCurriculum"></div>			
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                   
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseMasterCurriculum(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					<div class="form-group">	
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Curriculum <span class="required">*</span></label>					
					<div class="col-md-10 col-sm-10 col-xs-12">
					<textarea class="form-control col-md-7 col-xs-12 summernote" type="text" name="course_curriculum" placeholder="Enter Total Rating">{{ old('course_curriculum',(isset($edit_data)) ? $edit_data->course_curriculum:"")}}</textarea>
					</div>
					</div>  
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit" >Submit</button>
                        </div>
                    </div>

                    </form>
                  </div>
                </div>
              </div> 
-->

			 <!-- <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <div class="succescourseRelated"></div><div class="errorcourseRelated"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseMasterRelated(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					<div class="form-group">
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
					
					
				
					
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Related Certifications<span class="required">*</span></label>
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
						<div class="col-12 col-md-3 ">
						Yes
						<input type="radio" name="show_certification_tab" value="1"  @if (1== old('show_certification_tab'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_certification_tab == 1 ) ? "checked":"" }} @endif>	
						</div>
						<div class="col-12 col-md-3">
						No
						<input type="radio" name="show_certification_tab" value="0" @if ('0'== old('show_certification_tab'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->show_certification_tab == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>
						
				         <div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Front Page?<span class="required">*</span></label></div>
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
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>-->
			  
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>FAQ Course<small></small></h3>
                    <div class="successFAQs"></div><div class="errorFAQs"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveFAQ(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					 <?php if(!empty($edit_data->FAQs)){
					     
						 $FAQs =json_decode($edit_data->FAQs);  
						
						 if($FAQs){
						 if($FAQs->faqq){
						     
					 $faqquestion  = json_decode($FAQs->faqq);
					 
					 $faqanswer  = json_decode($FAQs->faqa);
					     }else{
					         
					         $faqquestion = 0;
					     }
						 }else{
						    $faqquestion = 0; 
						     
						 }
					 for($i=0; $i<count($faqquestion); $i++){						 
					 ?>
					
					<div>
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Question <?php echo $i+1; ?> <span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" value="<?php echo (isset($faqquestion[$i])? $faqquestion[$i]:""); ?>" placeholder="FAQ Question 1" multiple="true"> 
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
					
					<button class="add_more_stream" type="button" style="margin-top: 0px;float: right;margin-right: 125px;">Add More</button> 
				 
                      
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
                    <h3>Testimonial<small></small></h3>
                    <div class="successFAQs"></div><div class="errorFAQs"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveTestimonial(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					 <?php if(!empty($edit_data->testimonial)){
						 $testimonials =json_decode($edit_data->testimonial);                    
					 $name  = json_decode($testimonials->name);
					 
					 $comment  = json_decode($testimonials->comment);
 					 
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
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <div class="succescourseRelated"></div><div class="errorcourseRelated"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form data-parsley-validate class="form-horizontal form-label-left" action="" method="post" onsubmit="return courseMasterController.editSaveCourseFooter(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					 	  
					  
				<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Footer in Master?</label></div>
						<div class="col-12 col-md-2">
						Yes
						<input type="radio" name="footer_master" value="1"  @if (1== old('footer_master'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->footer_master == 1 ) ? "checked":"" }} @endif>	
						</div>
					
						<div class="col-12 col-md-2">
						No 
						<input type="radio" name="footer_master"  value="0"  @if ('0'== old('footer_master'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->footer_master == '0' ) ? "checked":"" }} @endif>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>-->

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script type="text/javascript">
$('.summernote').summernote({
height: 200
});
</script>

<script> 
	  var max = 0;
$(".add_masterparagraph").click(function(){
    if (max >= 8) return;
    var addinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph '+max+'</label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="masterparagraph[]" placeholder="Paragraph '+maxAppend+'"></textarea> </div></div><span class="btn btn-inverse btn-circle m-b-5" onclick="pararemove(this)" style="margin-right:132px;color: red;float: right;margin-top: -38px;"><i class="glyphicon glyphicon-trash"></i></span></div><br />');   
		max++;

    $(".result_masterparagraph").append(addinput);
});
	  
</script>

<script>
function pararemove(a){
$(a).parent("div").remove();
}
</script>


<script> 
	  var maxAppend = 0;
$(".add_paragraph").click(function(){
    if (maxAppend >= 8) return;
    var addinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph '+maxAppend+'</label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="paragraph[]" placeholder="Paragraph '+maxAppend+'"></textarea> </div></div><span class="btn btn-inverse btn-circle m-b-5" onclick="remove(this)" style="margin-right:132px;color: red;float: right;margin-top: -38px;"><i class="glyphicon glyphicon-trash"></i></span></div><br />');   
		maxAppend++;

    $(".result_paragraph").append(addinput);
});
	  
</script>

<script>
function remove(a){
$(a).parent("div").remove();
}
</script>
     <script>	  
	  var maxAppend = 2;
$(".add_more_stream").click(function(){
    if (maxAppend >= 11) return;

    var addinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Question '+maxAppend+' <span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" placeholder="FAQ Question '+maxAppend+'"></div></div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Answer '+maxAppend+'<span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="faqa[]" placeholder="Enter FAQ Answer "></textarea></div></div><span class="btn btn-inverse btn-circle m-b-5" onclick="removefaq(this)" style="margin-right: 128px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span></div><br />');
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
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Name'+maxtest+' <span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><input class="form-control col-md-7 col-xs-12" type="text" name="name[]" placeholder="Enter Name '+maxtest+'"></div></div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Comment '+maxtest+'<span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="comment[] placeholder="Enter Comment" multiple="true"></textarea></div></div><span class="btn btn-inverse btn-circle m-b-5" onclick="removetestimonial(this)" style="margin-right: 132px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span></div><br />');
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
@endsection
