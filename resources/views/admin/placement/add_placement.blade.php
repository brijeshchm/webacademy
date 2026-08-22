@extends('admin.layouts.app')
@section('title')
Add Placement     
@endsection
@section('content')

<div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Add Placement <small></small></h3><div class="succesmessage"></div><div class="errormessage"></div>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form id="course-form" class="form-horizontal form-label-left" action="" onsubmit="return placementController.savePlacement(this)" > 

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="name" value="" placeholder="Enter Name" >
                        </div>
                      </div> 
					  
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Email</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="email" value="" placeholder="Enter Email" >
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
							<option value="<?php echo $course->id ?>"><?php  echo $course->course_name; ?></option>
							<?php } } ?>
							</select>
                        </div>
                      </div>
					 
                       
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Rating(1-5)</label>
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
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Total Ratings</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="number" name="total_rating" placeholder="Enter Total Rating">
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Student Image<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="file" name="placement_image" accept=".jpeg,.jpg,.png">
                        </div>
                      </div>   
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Image alt<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="alt" placeholder="Enter image alt name">
                        </div>
                      </div>    

					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Related Course 
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<select class="form-control col-md-7 col-xs-12 select_related_courses" name="related_courses[]" multiple >
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
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Comment</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="comment" placeholder="Enter Comment"></textarea>
                        </div>
                      </div>
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Company Name<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="company_name" placeholder="Enter Company Name">
                        </div>
                      </div>					  
						  					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Designation<span class="required">*</span></label>					
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="designation" placeholder="Enter Designation">
                        </div>
                    </div> 
 
					   	 
                   <div class="form-group">

    <label for="salary_hike"
        class="control-label col-md-2 col-sm-3 col-xs-12">
        Salary Hike <span class="required">*</span>
    </label>

    <div class="col-md-8 col-sm-8 col-xs-12">

        <select name="salary_hike"
            id="salary_hike"
            class="form-control col-md-7 col-xs-12">

            <option value="">Select Salary Hike</option>

            @php
                $salaryHikes = [
                    10, 20, 30, 40, 50, 60, 70,
                    73, 75, 78,
                    80, 86, 88,
                    90, 93, 96, 98,
                    100, 110, 120,
                    130, 140, 150,
                    160, 170, 200
                ];

                $selectedSalary = old(
                    'salary_hike',
                    isset($edit_data) ? $edit_data->salary_hike : ''
                );
            @endphp

            @foreach($salaryHikes as $salary)

                <option value="{{ $salary }}"
                    {{ $selectedSalary == $salary.'%' ? 'selected' : '' }}>

                    {{ $salary }}%

                </option>

            @endforeach

        </select>

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
            </div>
            </div>
  
@endsection