@extends('admin.layouts.app')
@section('title')
Edit Course
@endsection
@section('content') 
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
	/* ===== Base table ===== */
.course-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 16px 0;
    font-size: 15px;
    line-height: 1.6;
    background: #fff;
}

/* ===== Header row ===== */
.course-content table th,
.course-content table thead td,
.course-content table tr:first-child td {
    background: #1d4ed8;
    color: #fff;
    font-weight: 600;
    text-align: left;
}

/* ===== All cells ===== */
.course-content table th,
.course-content table td {
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    vertical-align: top;
    text-align: left;
}

/* ===== Row styling ===== */
.course-content table tr:nth-child(even) td {
    background: #f8fafc;               /* striped rows */
}

 

/* ===== Rounded corners (optional) ===== */
.course-content table {
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

/* ===== Mobile: scroll sideways instead of breaking layout ===== */
@media (max-width: 640px) {
    .course-content table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
}
</style>
<div class="right_col" role="main">
          <div class="">            
            <div class="clearfix"></div>
            <div class="row">
              
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
					<h1> Course Page <small>Course Title and Rating</small></h1>  
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
						<form   method="post" class="form-horizontal form-label-left" autocomplete="off" action="{{ route('admin.editSave.CourseTitle',(isset($edit_data->id)? $edit_data->id:'')) }}" data-ajax-autosave data-section-name="CourseTitle" >
@csrf
                        	<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12 auto-save-field" for="last-name">Course Name<span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="course_name"  class="form-control col-md-7 col-xs-12" value="{{ old('course_name',(isset($edit_data)) ? $edit_data->course_name:"")}}"  placeholder="Enter Course Name"> 
							</div>
							</div>
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
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
							<select name="category" class="form-control col-md-7 col-xs-12 select_category"  >
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
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Title</label>
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
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Definition <span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<textarea class="form-control col-md-7 col-xs-12" type="text" name="course_defination" placeholder="Enter course defination">{{ old('course_defination',(isset($edit_data)) ? $edit_data->course_defination:"")}}</textarea>
							</div>
							</div>
							
						 
						 
						 
							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Type</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<select class="form-control col-md-7 col-xs-12 course_type_edit" type="text" name="course_type">
							<option value="">Select Course Type </option>
							<option value="1" @if ('1'== old('course_type'))
							selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->course_type == 1 ) ? "selected":"" }} @endif >Course Page 1</option>
							<option value="2" @if (2== old('course_type'))
							selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->course_type == 2 ) ? "selected":"" }} @endif>Course Page 2</option>

							</select>
							</div>
							</div>
						<!--show_courseModule  -->
					 
							<div class="form-group course-module">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Courses Module</label>
							<div class="col-md-8 col-sm-8 col-xs-12"> 
							<select class="form-control col-md-7 col-xs-12 select_courses_module" name="courses_module[]" multiple>
							<option value=""></option>
							<?php 					

							if(!empty($edit_data->courses_module)){	

							$courses_module = json_decode($edit_data->courses_module);	
							
						 
							}else{
							$courses_module=array();
							}
							if(!empty($course_list) ){						 	
							foreach($course_list as $course){

							if(in_array($course->slug, $courses_module)){
							?>
							<option value="<?php echo $course->slug; ?>" selected><?php echo $course->title; ?></option>

							<?php } else{ ?>

							<option value="<?php echo $course->slug; ?>" ><?php echo $course->title; ?></option>

							<?php	} }  } ?>
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
		
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
					<h1> Course Topic </h1>  			 	         
				 
					</div>
					<div class="x_content">                    
						<form   method="post" class="form-horizontal form-label-left" autocomplete="off" action="{{ route('admin.editSaveCourseTopic',(isset($edit_data->id)? $edit_data->id:'')) }}" data-ajax-autosave data-section-name="CourseTopic" >
@csrf
                         
							<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Enrolled Students<span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="enrolled" value="{{ old('enrolled',(isset($edit_data)) ? $edit_data->enrolled:"")}}" placeholder="Enter enrolled">
							</div>
							</div>

								<div class="form-group">
							<label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Price <span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="price" value="{{ old('price',(isset($edit_data)) ? $edit_data->price:"")}}" placeholder="Enter price">
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

								<select class="form-control col-md-7 col-xs-12" name="offer" id="offer" required>
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
						<label class="control-label col-md-2 col-sm-3 col-xs-12" for="offer">
							Featured <span class="required">*</span>
						</label>
						<div class="col-md-8 col-sm-8 col-xs-12">

							@php
								$featured = ['1'=>'Recommended','0'=>'un-Recommended'];
								$selectedFeatured = old('featured', isset($edit_data) ? $edit_data->featured : '');
							@endphp

							<select class="form-control col-md-7 col-xs-12" name="featured" required>
								<option value="" {{ $selectedFeatured == '' ? 'selected' : '' }}>Select featured</option>
								@foreach($featured as $featur=>$feturValue)
									<option value="{{ $featur }}" {{ $selectedFeatured == $featur ? 'selected' : '' }}>
										{{ $feturValue }}
									</option>
								@endforeach
							</select>

							@error('featur')
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

        <select class="form-control col-md-7 col-xs-12 select_skills" name="mode[]" id="mode" multiple>
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

        <select class="form-control col-md-7 col-xs-12" name="certificate" id="certificate" required>
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
        Who Is This Course For <span class="required">*</span>
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

        <select class="form-control col-md-7 col-xs-12" name="level" id="level" required>
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
							</div>
							</div> 

							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Professionals Trained</label>
							<div class="col-md-8 col-sm-8 col-xs-12"> 
							<input class="form-control col-md-7 col-xs-12" type="text" onkeypress="return isNumericKeyCheck(event);" name="professional_trained" value="{{ old('professional_trained',(isset($edit_data->professional_trained) && $edit_data->professional_trained!==0) ? $edit_data->professional_trained:$speciality->professionals_trained)}}"  placeholder="Enter Professional trained">
							</div>
							</div> 
							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Batches every month</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" type="text" name="batches_every_month" onkeypress="return isNumericKeyCheck(event);" value="{{ old('batches_every_month',(isset($edit_data->batches_every_month) && $edit_data->batches_every_month!==0) ? $edit_data->batches_every_month:$speciality->batches)}}"  placeholder="Enter Batches every month">
							</div>
							</div> 
 				 
						 
						 
<div class="form-group">
    <label for="skills" class="control-label col-md-2 col-sm-3 col-xs-12">Tools & Technologies</label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <select id="skills" class="form-control col-md-7 col-xs-12 select_skills" name="skills[]" multiple>
            <option value=""></option>
            <?php
            // Safe decode: always returns a real array, never a stdClass
            $courses_skills = [];
            if (!empty($edit_data) && !empty($edit_data->skills)) {
                $decoded = json_decode($edit_data->skills, true);
                if (is_array($decoded)) {
                    // normalize to ints so in_array comparisons never fail on type mismatch
                    $courses_skills = $decoded;
                }
            }

            if (!empty($tools_list)) {
                foreach ($tools_list as $course) {
                    $isSelected = in_array($course->name, $courses_skills, true);
					if($isSelected){
                    ?>
                    <option value="<?php echo $course->name; ?>" <?php echo $isSelected ? 'selected' : ''; ?>>
                        <?php echo $course->name; ?>
                    </option>
                    <?php
					}else{
						?>
							<option value="<?php echo $course->name; ?>" ><?php echo $course->name; ?></option>
						<?php
					}
                }
            }
            ?>
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
		

			  
				<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">  
					<h3>Course About <small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
					<div class="clearfix"></div>
					</div>
					<div class="x_content"> 
						<form class="form-horizontal form-label-left" method="post" 
						action="{{ route('admin.editSaveCourseAbout',(isset($edit_data->id)? $edit_data->id:'')) }}" data-ajax-autosave 
						
						  >
@csrf

	                    <div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12 auto-save-field"  name="heading" placeholder="Enter coure heading"  value="{{ old('heading',(isset($aboutHeading->heading)) ? $aboutHeading->heading:"")}}" > 
						</div>
						</div>


						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course About <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<textarea type="text" data-quill-editor class="form-control col-md-7 col-xs-12 auto-save-field summernote" name="courseabout" rows="7" placeholder="Enter coure about" style="display:none" >{{ old('courseabout',(isset($aboutHeading->courseabout)) ? $aboutHeading->courseabout:"")}}</textarea>
						<div class="quill-editor min-h-[250px]"></div>
				 


						</div>
						</div> 
									
					
						
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 1 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12 auto-save-field"  name="paragraph1" placeholder="Enter Paragraph 1" value="{{ old('paragraph1',(isset($aboutHeading->paragraph1)) ? $aboutHeading->paragraph1:"")}}" > 
						</div>
						</div> 
						
						
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 2 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12 auto-save-field"  name="paragraph2" placeholder="Enter Paragraph 2"   value="{{ old('paragraph2',(isset($aboutHeading->paragraph2)) ? $aboutHeading->paragraph2:"")}}" > 
						</div>
						</div> 
						
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 3 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12 auto-save-field"  name="paragraph3" placeholder="Enter Paragraph 3"   value="{{ old('paragraph3',(isset($aboutHeading->paragraph3)) ? $aboutHeading->paragraph3:"")}}" > 
						</div>
						</div> 
						
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 4 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12 auto-save-field"  name="paragraph4" placeholder="Enter Paragraph 4"   value="{{ old('paragraph4',(isset($aboutHeading->paragraph4)) ? $aboutHeading->paragraph4:"")}}" > 
						</div>
						</div> 
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 5 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12 auto-save-field"  name="paragraph5" placeholder="Enter Paragraph 5"   value="{{ old('paragraph5',(isset($aboutHeading->paragraph5)) ? $aboutHeading->paragraph5:"")}}" > 
						</div>
						</div> 
						
							
						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Paragraph 6 <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<input type="text" class="form-control col-md-7 col-xs-12 auto-save-field"  name="paragraph6" placeholder="Enter Paragraph 6" value="{{ old('paragraph6',(isset($aboutHeading->paragraph6)) ? $aboutHeading->paragraph6:"")}}" > 
						</div>
						</div>
						
						<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">                          
						 
					 
					<button type="submit" class="btn btn-success" >Submit</button>
					 
						</div>
						</div>
						</form>
					</div>
                </div>
              </div> 

			  






   	  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h3>Course Content</h3>

            <div id="courseSaveStatus" role="status" aria-live="polite"></div>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            {{-- Replace this URL with your existing POST save URL --}}
            <form                 
                class="form-horizontal form-label-left"
			  	method="POST"			 
				action="{{ route('admin.editSaveCourseContent',(isset($edit_data->id)? $edit_data->id:'')) }}"
					 
				
				data-section-name="editSaveCourseContent"  data-ajax-autosave>
@csrf
                @for($i = 1; $i <= 6; $i++)
                    @php
                        $headingField = 'heading' . $i;
                        $descriptionField = 'description' . $i;
                    @endphp

                    <details
                        class="course-content-section course-content"
                        @if($i === 1) open @endif
                    >
                        <summary class="course-content-trigger">
                            Heading {{ $i }}
                            <span class="course-content-arrow">⌄</span>
                        </summary>

                        <div class="course-content-body">
                            <div class="form-group">
                                <label
                                    for="course-{{ $headingField }}"
                                    class="control-label col-md-2 col-sm-3 col-xs-12"
                                >
                                    Heading {{ $i }}
                                </label>

                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input
                                        type="text"
                                        id="course-{{ $headingField }}"
                                        name="{{ $headingField }}"
                                        class="form-control auto-save-field"
                                        placeholder="Enter Heading {{ $i }}"
                                        value="{{ old($headingField, $aboutHeading->{$headingField} ?? '') }}"
                                    >
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    for="course-{{ $descriptionField }}"
                                    class="control-label col-md-2 col-sm-3 col-xs-12"
                                >
                                    Description {{ $i }}
                                </label>

                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <textarea
                                        id="course-{{ $descriptionField }}"
                                        name="{{ $descriptionField }}"
										data-quill-editor
                                        class="form-control auto-save-field"
                                        rows="6"
                                        placeholder="Enter Description {{ $i }}" style="display:none"
                                    >{{ old($descriptionField, $aboutHeading->{$descriptionField} ?? '') }}</textarea>
									<div class="quill-editor min-h-[250px]"></div>
                                </div>
                            </div>
                        </div>
                    </details>
                @endfor

                <div class="form-group">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                        <button type="submit" class="btn btn-success">
                            Save Now
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .course-content-section {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #fff;
    }

    .course-content-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        background: #f5f7fa;
        color: #34495e;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        list-style: none;
        border-radius: 6px;
    }

    .course-content-trigger::-webkit-details-marker {
        display: none;
    }

    .course-content-arrow {
        transition: transform .2s ease;
    }

    .course-content-section[open] > summary {
        border-bottom: 1px solid #ddd;
    }

    .course-content-section[open] .course-content-arrow {
        transform: rotate(180deg);
    }

    .course-content-body {
        padding: 20px 15px 5px;
    }

    #courseSaveStatus {
        margin-top: 10px;
        font-size: 14px;
    }

    #courseSaveStatus:empty {
        display: none;
    }

    #courseSaveStatus[data-state="success"] {
        padding: 10px 14px;
        color: #166534;
        background: #dcfce7;
        border: 1px solid #86efac;
        border-radius: 5px;
    }

    #courseSaveStatus[data-state="error"] {
        padding: 10px 14px;
        color: #991b1b;
        background: #fee2e2;
        border: 1px solid #fca5a5;
        border-radius: 5px;
    }

    #courseSaveStatus[data-state="pending"] {
        color: #64748b;
    }
</style>






@php
    $whyLearn = old(
        'why_learn',
        json_decode($edit_data->why_learn ?? '[]', true)
    );

    $whyLearn = is_array($whyLearn) && count($whyLearn)
        ? $whyLearn
        : [''];
@endphp

<div class="col-md-12 col-sm-12 col-xs-12">
    <details class="x_panel learn-panel">
        {{-- Content trigger --}}
        <summary class="learn-trigger">
            <span>What You'll Learn</span>
            <span class="learn-arrow">⌄</span>
        </summary>

        <div class="x_content">
            <div class="successCourseOverview"></div>
            <div class="errorCourseOverview"></div>

            <form
                class="form-horizontal form-label-left"         
 				method="POST"
               
                 action="{{ route('admin.editSaveCourseLearn',(isset($edit_data->id)? $edit_data->id:'')) }}"
             data-section-name="editSaveCourseLearn"  data-ajax-autosave>
@csrf
                

                <div class="learn-items">
                    @foreach($whyLearn as $value)
                        <div class="form-group learn-item">
                            <label class="control-label col-md-2 col-sm-3 col-xs-12">
                                Answer
                            </label>

                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <textarea
                                    class="form-control"
                                    name="why_learn[]"
                                    rows="3"
                                    placeholder="Why should you learn"
                                    aria-label="Learning outcome"
                                >{{ $value }}</textarea>

                                <button
                                    type="button"
                                    class="btn btn-danger btn-xs learn-remove"
                                    style="margin-top: 8px;"
                                    aria-label="Remove answer"
                                >
                                    <i class="glyphicon glyphicon-trash"></i>
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                        <button type="button" class="btn btn-default learn-add">
                            + Add More
                        </button>

                        <button type="submit" class="btn btn-success" name="submit">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </details>
</div>

<style>
    .learn-panel > .learn-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 10px;
        color: #34495e;
        font-size: 20px;
        font-weight: 600;
        cursor: pointer;
        list-style: none;
    }

    .learn-trigger::-webkit-details-marker {
        display: none;
    }

    .learn-trigger:focus-visible {
        outline: 2px solid #337ab7;
    }

    .learn-panel[open] > .learn-trigger {
        margin-bottom: 15px;
        border-bottom: 2px solid #e6e9ed;
    }

    .learn-arrow {
        transition: transform .2s ease;
    }

    .learn-panel[open] > .learn-trigger .learn-arrow {
        transform: rotate(180deg);
    }

    .learn-panel > .x_content {
        float: none;
    }
</style>

<script>
document.querySelectorAll('.learn-panel').forEach(function (panel) {
    if (panel.dataset.triggerReady) return;
    panel.dataset.triggerReady = 'true';

    const items = panel.querySelector('.learn-items');

    panel.querySelector('.learn-add').addEventListener('click', function () {
        const newItem = items.querySelector('.learn-item').cloneNode(true);

        newItem.querySelector('textarea').value = '';
        items.appendChild(newItem);
        newItem.querySelector('textarea').focus();
    });

    items.addEventListener('click', function (event) {
        const button = event.target.closest('.learn-remove');
        if (!button) return;

        const item = button.closest('.learn-item');

        if (items.querySelectorAll('.learn-item').length > 1) {
            item.remove();
        } else {
            item.querySelector('textarea').value = '';
        }
    });
});
</script>




			 
    



			  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">  
					<h3>Trainer About <small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
					<div class="clearfix"></div>
					</div>
					<div class="x_content"> 
						<form class="form-horizontal form-label-left" method="post"
						 action="{{ route('admin.editSaveTrainerAbout',(isset($edit_data->id)? $edit_data->id:'')) }}"
						
						 data-section-name="editSaveTrainerAbout"  data-ajax-autosave>
@csrf
 

						<div class="form-group">   
						<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Trainer About <span class="required">*</span></label>					  
						<div class="col-md-8 col-sm-8 col-xs-12">
						<textarea type="text" 
						data-quill-editor
						class="form-control col-md-7 col-xs-12 summernote"  name="trainer_about" rows="7" placeholder="Enter trainer about" style="display:none">{{ old('trainer_about',(isset($edit_data->trainer_about)) ? $edit_data->trainer_about:"")}}</textarea>
						<div class="quill-editor min-h-[250px]"></div>
						</div>
						</div> 
									
				@php
    $trainerParagraph = [];

    if (!empty($edit_data) && !empty($edit_data->trainer_paragraph)) {
        $trainerParagraph = json_decode($edit_data->trainer_paragraph, true) ?? [];
    }

    $trainerParagraph = old('trainer_paragraph', $trainerParagraph);
@endphp

@for($i = 0; $i < 6; $i++)

    <div class="form-group">

        <label class="control-label col-md-2 col-sm-3 col-xs-12">
            Paragraph {{ $i + 1 }}
            <span class="required">*</span>
        </label>

        <div class="col-md-8 col-sm-8 col-xs-12">

            <input
                type="text"
                class="form-control col-md-7 col-xs-12"
                name="trainer_paragraph[]"
                placeholder="Enter Paragraph {{ $i + 1 }}"
                value="{{ $trainerParagraph[$i] ?? '' }}"
            >

        </div>

    </div>

@endfor
		

					 
						
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
					<h3>Course Extra Content<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
					<div class="clearfix"></div>
					</div>
					<div class="x_content"> 
						<form class="form-horizontal form-label-left" method="post"			
						 action="{{ route('admin.editSaveCourseExtraContent',(isset($edit_data->id)? $edit_data->id:'')) }}"
						
						 data-section-name="editSaveCourseExtraContent"  data-ajax-autosave>
@csrf
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
						data-quill-editor
						class="form-control col-md-7 col-xs-12"
						name="top_description"
						placeholder="Enter top description" style="display:none"
						>{{ old('top_description', $edit_data->top_description ?? '') }}</textarea>
						<div class="quill-editor min-h-[250px]"></div>
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
				   <h3>Course Curriculum<small></small></h3>
					<div class="successCourseOverview"></div><div class="errorCourseOverview"></div>					
                    <div class="clearfix"></div>
					<a href="{{ route('admin.course.download-template') }}" class="btn btn-primary">
						<i class="fa fa-download"></i> Download CSV Template
					</a>
                  </div>
                  <div class="x_content">        
				  
                    <form class="form-horizontal form-label-left" method="post"  enctype="multipart/form-data" 
					 action="{{ route('admin.editSaveCurriculum',(isset($edit_data->id)? $edit_data->id:'')) }}"
					
					  data-section-name="editSaveCurriculum"  data-ajax-autosave>
@csrf
                      <div class="form-group">   
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Curriculum <span class="required">*</span></label>					  
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="file" class="form-control col-md-7 col-xs-12"  name="course_curriculum" accept=".csv" placeholder="Enter coure Curriculum"  <?php if(!empty($coursecurriculum) && count($coursecurriculum)>0){ ?> disabled  <?php } ?> >
                        </div>
                      </div> 
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">   
                           <?php if(!empty($coursecurriculum) && count($coursecurriculum)>0){ ?>
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
								<th>Content <a href="javascript:courseController.courseContentDelete('<?php echo $edit_data->id; ?>')" title="delete course content" style="float: right;margin-right: 41px;" class="btn btn-danger">Delete</a></th>
								@endif
														
							</tr>
						  </thead>
							<tbody>
							<?php 
							
			
							
							if($coursecurriculum){
								$i=0;
								foreach($coursecurriculum as $course){
								$i++;
								?>
							<tr>						 
							<td>							 
							<div class="lms-accordian">
							<button class="paccordion" style="font-weight: 700;font-size: 13px;">							 
							<?php echo str_replace('?','',$course['title']); ?></button>
							<div class="panel">
							<ul>						 
							 <?php 
					
							 if($course['topics']){						 
								 
								 foreach($course['topics'] as $content){ 
							
									?>
									<li style="font-size: 13px;"> <?php echo str_replace('?','',$content['content']); ?></li>
									 <?php 
										
										if($content['subcontents']){
											
											foreach($content['subcontents'] as $sub){ ?>
											<ul><li style="font-size: 12px;"><?php echo str_replace('?','',$sub['subcontent']); ?></li>
											
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
                    <h3>FAQ Course<small></small></h3>
                    <div class="successFAQs"></div><div class="errorFAQs"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form id="course-faq-form" method="POST"  class="form-horizontal form-label-left"	
					 action="{{ route('admin.editSaveFAQ',(isset($edit_data->id)? $edit_data->id:'')) }}"
					 data-section-name="editSaveFAQ"  data-ajax-autosave>
@csrf
					 <?php if(!empty($edit_data->FAQs)){
					     if($edit_data->FAQs){
						 $FAQs =json_decode($edit_data->FAQs);    
						 if($FAQs->faqq){
					        $faqquestion  = json_decode($FAQs->faqq);
					        if($faqquestion){					            
					            $faqquestion = $faqquestion;
					        }
					        $faqanswer  = json_decode($FAQs->faqa);
						 }else{
						     
						     $faqquestion = [];
						 }
					 }else{
					     
					     $faqquestion = [];
					 }
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
                    
                    <div class="succescourseRelated"></div><div class="errorcourseRelated"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form  class="form-horizontal form-label-left" 
					
					action="{{ route('admin.editSaveCourseRelated',(isset($edit_data->id)? $edit_data->id:'')) }}" data-ajax-autosave data-section-name="CourseRelated" method="post"  >
@csrf
				
					<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Show Related Courses (Sidebar)<span class="required">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<select class="form-control col-md-7 col-xs-12 select_related_courses_side" name="related_courses_side[]" multiple>
					<option value="">Select Course</option> 
						 @php
						$relatedCoursesSide = !empty($edit_data->related_courses_side)
							? (json_decode($edit_data->related_courses_side, true) ?? [])
							: [];
					@endphp

					@foreach($course_list ?? [] as $coursev)
						<option value="{{ $coursev->slug }}" @selected(in_array($coursev->slug, $relatedCoursesSide))>
							{{ $coursev->title }}
						</option>
					@endforeach		
 
					</select>

					</div>
					</div>
				 				 
				         <div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Home Page?<span class="required">*</span></label></div>
						<div class="col-12 col-md-3">
						Yes
						<input type="radio" name="show_front_page" value="1"  @if (1== old('show_front_page'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->show_front_page == 1 ) ? "checked":"" }} @endif>	
						</div>
						<div class="col-12 col-md-3">
						No
						<input type="radio" name="show_front_page" value="0"  @if ('0'== old('show_front_page'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->show_front_page == '0' ) ? "checked":"" }} @endif>
						</div>
						</div> 



				<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show on Home page Second in Trending?</label></div>
						<div class="col-12 col-md-2">
						Yes
						<input type="radio" name="show_front_second" value="1"  @if (1== old('show_front_second'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->show_front_second == 1 ) ? "checked":"" }} @endif>	
						</div>
					
						<div class="col-12 col-md-2">
						No 
						<input type="radio" name="show_front_second"  value="0"  @if ('0'== old('show_front_second'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->show_front_second == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>  


				<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show footer certificate</label></div>
						<div class="col-12 col-md-2">
						Yes
						<input type="radio" name="footer_certificate" value="1"  @if (1== old('footer_certificate'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->footer_certificate == 1 ) ? "checked":"" }} @endif>	
						</div>
					
						<div class="col-12 col-md-2">
						No 
						<input type="radio" name="footer_certificate"  value="0"  @if ('0'== old('footer_certificate'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->footer_certificate == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>
						
						
						
						<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show footer Top Course</label></div>
						<div class="col-12 col-md-2">
						Yes
						<input type="radio" name="footer_top_course" value="1"  @if (1== old('footer_top_course'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->footer_top_course == 1 ) ? "checked":"" }} @endif>	
						</div>
					
						<div class="col-12 col-md-2">
						No 
						<input type="radio" name="footer_top_course"  value="0"  @if ('0'== old('footer_top_course'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->footer_top_course == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>
						
							<div class="form-group">
						<div class="control-label col col-md-2"><label for="text-input" class=" form-control-label">Show Trending Courses</label></div>
						<div class="col-12 col-md-2">
						Yes
						<input type="radio" name="show_trending_courses" value="1"  @if (1== old('show_trending_courses'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->show_trending_courses == 1 ) ? "checked":"" }} @endif>	
						</div>
					
						<div class="col-12 col-md-2">
						No 
						<input type="radio" name="show_trending_courses"  value="0"  @if ('0'== old('show_trending_courses'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->show_trending_courses == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>
						
						
						
						
						
						<div class="form-group">
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
						</div>   

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
						<input type="radio" name="show_on_footer" value="0"  @if ('0'== old('show_on_footer'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->show_on_footer == '0' ) ? "checked":"" }} @endif>
						</div>
						</div>  
						 
						
						
						
					 
                     	<div class="form-group">
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Related Courses</label>
					<div class="col-md-8 col-sm-8 col-xs-12">Please Select 4 Or  8
					<select class="form-control col-md-7 col-xs-12 select_related_courses" name="related_courses[]" multiple>
						@php
						$relatedCourses = !empty($edit_data->related_courses)
						? (json_decode($edit_data->related_courses, true) ?? [])
						: [];
						@endphp

						@foreach($course_list  as $course_v)
						<option value="{{ $course_v->slug }}" @selected(in_array($course_v->slug, $relatedCourses))>
						{{ $course_v->title }}
						</option>
						@endforeach
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

 

<script>   
	  
	  var learnAppendCount = 0;
$(".add_why_learn").click(function(){
    if (learnAppendCount >= 8) return;
    var addinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Answer</label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="why_learn[]" placeholder="Why should you learn" multiple="true"></textarea> <span class="btn btn-inverse btn-circle m-b-5" onclick="remove(this)" style="margin-right: -38px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span></div></div></div><br />');   
		learnAppendCount++;

    $(".result_why_learn").append(addinput);
});
	  
</script>

<script>
function remove(a){
$(a).parent("div").parent("div").remove();
}
</script>
     <script>	  
	  var faqAppendCount = 2;
$(".add_more_stream").click(function(){
    if (faqAppendCount >= 11) return;

    var addinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Question '+faqAppendCount+' <span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><input class="form-control col-md-7 col-xs-12" type="text" name="faqq[]" placeholder="FAQ Question '+faqAppendCount+'"></div></div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">FAQ Answer '+faqAppendCount+'<span class="required">*</span></label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="faqa[]" placeholder="Enter FAQ Answer " multiple="true"></textarea></div></div><span class="btn btn-inverse btn-circle m-b-5" onclick="removefaq(this)" style="margin-right: 132px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span></div><br />');
    faqAppendCount++;

    $(".addfqa").append(addinput);
});
	  
</script>

<script>
function removefaq(a){
$(a).parent("div").remove();
}

</script>

 

<script>
function removetestimonial(a){
$(a).parent("div").remove();
}

</script>

<script>	
	window.addEventListener('load', function()
	{
		var category_id = @json($edit_data->category ?? '');
		var subcategory_id = @json($edit_data->subcategory ?? '');
		var course_pdf_text = @json($edit_data->course_pdf_text ?? '');
		var course_type = @json($edit_data->course_type ?? '');
		var course_module = @json($edit_data->courses_module ?? '');
		var course_releted = @json($edit_data->related_courses ?? '');
		// get_subcategory(category_id,subcategory_id);	 
		// get_categoryPDF(subcategory_id,course_pdf_text);			
		get_courseModuleedit(course_type,category_id,course_module);	 
		get_courseReleted(category_id,course_releted);		 
	 
	});
</script>
 

<script>

function get_courseModuleedit(ctid,cid,cm=""){	 
	 //alert(cm);
	if("2" == ctid ){
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "get",	 
	url: "{{URl('admin/course/get_course_modul_edit')}}",
	data: {cid:cid,cm:cm},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_courseModule").html(data);
	}
	});
	}
}

function get_courseReleted(cid,cr=""){	 
	 
	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "get",	 
	url: "{{URl('admin/course/get_course_releted_edit')}}",
	data: {cid:cid,cr:cr},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_course_releted").html(data);
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
		<?php
if((isset($edit_data) && $edit_data->show_on_footer =='1' )){ ?>
<script>
	$('.show_footer_city').show();	
	</script>
	<?php 
}else{ ?>
<script>
	$('.show_footer_city').hide();
	</script>
	<?php 
}


		?>
<script>

function showfooter(gst){			
			 
		$('.show_footer_city').show();
				
		}
		
		function nofooter(gstno){	
 		
			$('.show_footer_city').hide();		
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

		.lms-accordian .panel {
		padding: 0 18px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
		} 
		</style>







<style>
    .course-section-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        width: 100%;
        padding: 14px 12px;
        border: 0;
        border-radius: 6px;
        background: #f5f7fa;
        color: #34495e;
        text-align: left;
        font: inherit;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
    }
    .course-section-toggle:hover { background: #eaf0f7; }
    .course-section-toggle:focus-visible { outline: 2px solid #337ab7; }
    .course-section-toggle small { font-size: 12px; color: #64748b; }
    .course-toggle-arrow { transition: transform .2s ease; }
    .course-section-toggle[aria-expanded="true"] .course-toggle-arrow {
        transform: rotate(180deg);
    }
    .course-trigger-panel > .x_title { padding: 0 0 10px; }
    .course-trigger-panel > .x_title h1,
    .course-trigger-panel > .x_title h3 {
        float: none;
        width: 100%;
        margin: 0 0 8px;
    }
    .course-trigger-panel > .x_content { float: none; }
    .course-trigger-panel > .x_content[hidden] { display: none !important; }

	.x_title span{

	    color: #060606;

	}
</style>
<script>
(function () {
    function initializeCourseTriggers() {
        document.querySelectorAll('.right_col .x_panel').forEach(function (panel, index) {
            // The learning section already has its own native details trigger.
            if (panel.tagName === 'DETAILS' || panel.dataset.sectionTriggerReady) return;
            const title = [...panel.children].find(el => el.classList.contains('x_title'));
            const content = [...panel.children].find(el => el.classList.contains('x_content'));
            if (!title || !content) return;
            panel.dataset.sectionTriggerReady = '1';
            panel.classList.add('course-trigger-panel');
            let heading = title.querySelector('h1, h3');
            if (!heading) {
                heading = document.createElement('h3');
                heading.textContent = 'Related Courses & Visibility';
                title.prepend(heading);
            }
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'course-section-toggle';
            const label = document.createElement('span');
            while (heading.firstChild) label.appendChild(heading.firstChild);
            const arrow = document.createElement('span');
            arrow.className = 'course-toggle-arrow';
            arrow.textContent = '⌄';
            arrow.setAttribute('aria-hidden', 'true');
            button.append(label, arrow);
            heading.appendChild(button);
            if (!content.id) content.id = 'course-section-body-' + index;
            button.setAttribute('aria-controls', content.id);
            function setOpen(open) {
                content.hidden = !open;
                button.setAttribute('aria-expanded', String(open));
                if (open) {
                    // Notify responsive widgets that their container is visible.
                    window.dispatchEvent(new Event('resize'));
                    const $ = window.jQuery;
                    if ($ && $.fn.dataTable) {
                        $(content).find('table').each(function () {
                            if ($.fn.dataTable.isDataTable(this)) {
                                $(this).DataTable().columns.adjust();
                            }
                        });
                    }
                }
            }
            button.addEventListener('click', function () {
                setOpen(button.getAttribute('aria-expanded') !== 'true');
            });
            content.addEventListener('invalid', function () { setOpen(true); }, true);
            setOpen(index === 0 || !!content.querySelector('.text-danger, .alert-danger'));
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeCourseTriggers, { once: true });
    } else initializeCourseTriggers();
})();
</script>





<!-- Success / error popup -->
<div id="courseSavePopup" role="status" aria-live="polite"></div>

<style>
    #courseSavePopup {
        position: fixed;
        top: 25px;
        right: 25px;
        z-index: 99999;
        max-width: calc(100vw - 40px);
        padding: 14px 22px;
        border-radius: 8px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .18);
        opacity: 0;
        transform: translateY(-15px);
        transition: opacity .25s, transform .25s;
        pointer-events: none;
    }

    #courseSavePopup.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    #courseSavePopup[data-type="success"] {
        background: #15803d;
    }

    #courseSavePopup[data-type="error"] {
        background: #dc2626;
    }
</style>



<style>
.common-save-status { margin: 0 0 15px; padding: 10px 14px; border-radius: 5px; }
.common-save-status:empty { display: none; }
.common-save-status[data-state="pending"] { color: #475569; background: #f1f5f9; }
.common-save-status[data-state="success"] { color: #166534; background: #dcfce7; }
.common-save-status[data-state="error"] { color: #991b1b; background: #fee2e2; }
</style>
 


			  
 <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>
(function () {
    function initializeQuillEditors() {
        if (typeof Quill === 'undefined') {
            console.error('Quill library did not load.');
            return;
        }

        document.querySelectorAll('textarea[data-quill-editor]')
            .forEach(function (textarea) {
                // Force original textarea to stay hidden.
                textarea.hidden = true;
                textarea.style.setProperty('display', 'none', 'important');

                if (textarea.dataset.quillReady === 'true') return;

                const editor = textarea.nextElementSibling;

                if (!editor || !editor.classList.contains('quill-editor')) {
                    console.error('Quill editor container missing:', textarea);
                    return;
                }

                let htmlMode = false;

                const quill = new Quill(editor, {
                    theme: 'snow',
                    placeholder: textarea.dataset.placeholder || 'Write here...',
                    modules: {
                        toolbar: [
                            [{ header: [2, 3, 4, 5, false] }],
                            [{ font: [] }],
                            [{ size: ['small', false, 'large', 'huge'] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ color: [] }, { background: [] }],
                            [{ align: [] }],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            [{ indent: '-1' }, { indent: '+1' }],
                            ['blockquote', 'code-block'],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                quill.clipboard.dangerouslyPasteHTML(
                    textarea.value || '',
                    'silent'
                );

                textarea.dataset.quillReady = 'true';
                textarea.quillInstance = quill;

                const toolbar = quill.getModule('toolbar').container;

                const htmlEditor = document.createElement('textarea');
                htmlEditor.className = 'form-control';
                htmlEditor.rows = 12;
                htmlEditor.spellcheck = false;
                htmlEditor.setAttribute('aria-label', 'Edit HTML source');
                htmlEditor.style.cssText =
                    'width:100%;min-height:220px;padding:15px;font-family:monospace;';

                // Use display:none!important to prevent CSS overriding hidden.
                htmlEditor.hidden = true;
                htmlEditor.style.setProperty('display', 'none', 'important');

                editor.insertAdjacentElement('afterend', htmlEditor);

                const toggleButton = document.createElement('button');
                toggleButton.type = 'button';
                toggleButton.className = 'btn btn-default';
                toggleButton.textContent = '</> Edit HTML';
                toggleButton.setAttribute('aria-pressed', 'false');

                toolbar.parentNode.insertBefore(toggleButton, toolbar);

                function setVisible(element, visible) {
                    element.hidden = !visible;
                    element.style.setProperty(
                        'display',
                        visible ? 'block' : 'none',
                        'important'
                    );
                }

                function updateTextarea(html) {
                    if (textarea.value === html) return;

                    textarea.value = html;
                    textarea.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }

                function getEditorHTML() {
                    const isEmpty =
                        quill.getLength() === 1 &&
                        quill.getText() === '\n' &&
                        quill.getContents().ops.every(function (operation) {
                            return typeof operation.insert === 'string';
                        });

                    return isEmpty ? '' : quill.root.innerHTML;
                }

                quill.on('text-change', function (delta, oldDelta, source) {
                    if (!htmlMode && source !== 'silent') {
                        updateTextarea(getEditorHTML());
                    }
                });

                htmlEditor.addEventListener('input', function () {
                    updateTextarea(htmlEditor.value);
                });

                toggleButton.addEventListener('click', function () {
                    htmlMode = !htmlMode;

                    if (htmlMode) {
                        htmlEditor.value = textarea.value;

                        setVisible(editor, false);
                        setVisible(toolbar, false);
                        setVisible(htmlEditor, true);

                        toggleButton.textContent = 'Visual Editor';
                        htmlEditor.focus();
                    } else {
                        quill.clipboard.dangerouslyPasteHTML(
                            htmlEditor.value,
                            'silent'
                        );

                        setVisible(htmlEditor, false);
                        setVisible(editor, true);
                        setVisible(toolbar, true);

                        toggleButton.textContent = '</> Edit HTML';
                        updateTextarea(getEditorHTML());
                    }

                    toggleButton.setAttribute(
                        'aria-pressed',
                        String(htmlMode)
                    );
                });
            });
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initializeQuillEditors,
            { once: true }
        );
    } else {
        initializeQuillEditors();
    }

    window.initializeQuillEditors = initializeQuillEditors;
})();
</script>


 


{{-- ======================= PART 2: AUTOSAVE ======================= --}}

<script>
(function () {
    'use strict';

    function initialize() {
        if (window.courseAutosaveInitialized) return;
        window.courseAutosaveInitialized = true;

        const popup = document.getElementById('courseSavePopup');
        let popupTimer;

        function toast(message, type) {
            if (!popup) return;
            clearTimeout(popupTimer);
            popup.textContent = message;
            popup.dataset.type = type;
            popup.classList.add('is-visible');
            popupTimer = setTimeout(() => popup.classList.remove('is-visible'), 4000);
        }

        const states = new Map();

        // Copy Summernote content back into its textarea before reading the form
         

		function sync(form) {
			const $ = window.jQuery;
			if (!$ || !$.fn.summernote) return;

			form.querySelectorAll('textarea.summernote').forEach(textarea => {
				const $ta = $(textarea);
				if (!$ta.data('summernote')) return;   // not initialized yet
				textarea.value = $ta.summernote('code');
			});
		}

        function payload(form) {
            sync(form);
            const data = new FormData(form);

            // Keep empty multi-selects / removed repeatable rows explicit
            const arrayNames = new Set([...form.querySelectorAll('[name$="[]"]')].map(el => el.name));
            arrayNames.forEach(name => {
                if (!data.has(name)) data.append(name, '');
            });

            // Always send the freshest CSRF token
            const token = document.querySelector('meta[name="csrf-token"]')?.content
                || form.querySelector('[name="_token"]')?.value;
            if (token) data.set('_token', token);

            return data;
        }

        function snapshot(data) {
            return JSON.stringify([...data].map(([key, value]) => [
                key,
                typeof value === 'string' ? value : [value.name, value.size, value.lastModified]
            ]));
        }

        function status(state, message, type) {
            state.status.textContent = message;
            state.status.dataset.state = type;
        }

        function schedule(form) {
            const state = states.get(form);
            if (!state) return;
            state.dirty = true;
            clearTimeout(state.timer);
            status(state, 'Unsaved changes…', 'pending');
            state.timer = setTimeout(() => save(form), 1000);
        }



		async function save(form, manual = false) {
    const state = states.get(form);
    clearTimeout(state.timer);

    if (state.saving) { state.queued = true; return; }

    state.saving = true;
    let succeeded = false;
    let sentSnapshot = '';

    try {
        const data = payload(form);
        sentSnapshot = snapshot(data);

        // Nothing changed: skip the request
        if (!manual && sentSnapshot === state.saved) {
            state.dirty = false;
            status(state, '', 'success');
            return;
        }

        if (!form.checkValidity()) {
            status(state, 'Complete the required fields to save this section.', 'error');
            if (manual) form.reportValidity();
            return;
        }

        const action = form.getAttribute('action');
        if (!action) throw new Error('Save URL is missing for this form.');

        status(state, 'Saving…', 'pending');
        console.log('[autosave] POST', action);

        const response = await fetch(action, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });

        if (!(response.headers.get('content-type') || '').includes('application/json')) {
            throw new Error('Save route must return JSON (HTTP ' + response.status + '). Check route and login.');
        }

        const result = await response.json();

        const failed = result.success === false || result.success === 0
            || result.status === false || result.status === 0 || result.status === '0'
            || result.status === 'error'
            || (result.errors && Object.keys(result.errors).length);

        if (!response.ok || failed) {
            const errors = Object.values(result.errors || {}).flat().join(' ');
            throw new Error(errors || result.message || result.msg || 'Save failed.');
        }

        const confirmed = result.success === true || result.success === 1
            || result.status === true || result.status === 1 || result.status === '1'
            || result.status === 'success';

        if (!confirmed) throw new Error('Server did not confirm saving. Return status: 1 in JSON.');

        state.saved = sentSnapshot;
        succeeded = true;
        state.dirty = snapshot(payload(form)) !== sentSnapshot;

        if (!state.dirty) {
            status(state, 'Saved successfully.', 'success');
            toast(result.message || result.msg || 'Saved successfully.', 'success');
        }
    } catch (error) {
        console.error('[autosave] failed:', error);
        state.dirty = true;
        status(state, (error.message || 'Save failed.') + ' Use Submit to retry.', 'error');
        toast(error.message || 'Save failed.', 'error');
    } finally {
        state.saving = false;
        try {
            const latest = snapshot(payload(form));
            if ((succeeded || latest !== sentSnapshot) && latest !== state.saved) {
                clearTimeout(state.timer);
                state.timer = setTimeout(() => save(form), 1000);
            }
        } catch (e) { console.error('[autosave] re-check failed:', e); }
    }
}


       

        document.querySelectorAll('form[data-ajax-autosave]').forEach(form => {
            const indicator = document.createElement('div');
            indicator.className = 'common-save-status';
            indicator.setAttribute('role', 'status');
            indicator.setAttribute('aria-live', 'polite');
            form.prepend(indicator);

            const state = {
                status: indicator,
                saved: snapshot(payload(form)),
                dirty: false,
                saving: false,
                timer: null
            };
            states.set(form, state);

            form.addEventListener('input', event => {
                if (event.target.matches('input,textarea,select,[contenteditable="true"],.note-codable')) schedule(form);
            });

            form.addEventListener('change', event => {
                if (event.target.matches('input,textarea,select')) schedule(form);
            });

            form.addEventListener('submit', event => {
                event.preventDefault();
                event.stopImmediatePropagation();
                save(form, true);
            }, true);

            // Detect added/removed repeatable fields (FAQ, reviews, learn items)
            new MutationObserver(records => {
                const fieldChanged = records.some(record =>
                    [...record.addedNodes, ...record.removedNodes].some(node =>
                        node.nodeType === 1
                        && !node.matches('.note-editor,.note-toolbar,.note-statusbar,.common-save-status')
                        && (node.matches('input[name],textarea[name],select[name]')
                            || node.querySelector('input[name],textarea[name],select[name]'))
                    )
                );
                if (fieldChanged) schedule(form);
            }).observe(form, { childList: true, subtree: true });
        });

        // FIXED: the event is "summernote.change" with NO extra namespace
        // (a dot in jQuery means namespace, so the old name never fired)
        const $ = window.jQuery;
        if ($) {
            $(document).on('change', 'textarea.summernote', function (event, contents) {
                if (typeof contents === 'string') this.value = contents;
                if (this.form) schedule(this.form);
            });
        }

        // Safety net: catches code-view and plugin changes. Only changed data saves.
        setInterval(() => {
            states.forEach((state, form) => {
                const current = snapshot(payload(form));
                if (current !== state.observed) {
                    if (state.observed !== undefined && current !== state.saved) schedule(form);
                    state.observed = current;
                }
            });
        }, 700);

        window.addEventListener('beforeunload', event => {
            if ([...states.values()].some(state => state.dirty || state.saving)) {
                event.preventDefault();
                event.returnValue = '';
            }
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize, { once: true });
    else initialize();
})();


 

</script>





@endsection
