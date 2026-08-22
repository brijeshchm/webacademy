@extends('admin.layouts.app')
@section('title')
Add Course PDF
@endsection
@section('content')

<div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Add Course PDF <small></small></h3><div class="succesmessage"></div><div class="errormessage"></div>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form id="course-form" class="form-horizontal form-label-left" method="post" action="" autocomplete="off" onsubmit="return coursePdfController.saveCoursePDF(this)" > 

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
						   			<option value="">Select Sub Category</option>	
						  </select>
                        </div>
                      </div>
						
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Upload PDF<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="file" class="form-control col-md-7 col-xs-12" name="course_pdf"  accept=".pdf">
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