@extends('admin.layouts.app')
@section('title')
Edit Careers
@endsection
@section('content')
 
<div class="right_col" role="main">
          <div class="">
            			<div class="page-title">
			<div class="title_left">
			<h3>Edit Careers</h3>
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
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
			<a href="/admin/careers/add"  class="btn btn-info"> Add Careers</a>

			</div>
			</div>
			</div>
			</div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return careersController.editSaveCareers(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">	

					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Job Title <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="job_title" value="{{ old('job_title',(isset($edit_data)) ? $edit_data->job_title:"")}}" placeholder="Enter Job Title" >
                        </div>
                      </div> 
					  
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Position</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="position" value="{{ old('position',(isset($edit_data)) ? $edit_data->position:"")}}" placeholder="Enter Position" >
                        </div>
                      </div> 
  				 
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Profile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							 <textarea type="text" class="form-control col-md-7 col-xs-12" name="profile" placeholder="Enter profile" >{{ old('profile',(isset($edit_data))?$edit_data->profile:"")}}</textarea>
                        </div>
                    </div>                      	 
                       
					    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Experience<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
								<div class="col-md-6 col-sm-6 col-xs-12" style="margin-left: -8px;">  
								<select name="exp_from" class="form-control col-md-7 col-xs-12">
								<option value="">Exp From</option>
								<?php for($i=0; $i<=12; $i++){ ?>
								<option value="{{$i}}" @if ($i== old('exp_from'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->exp_from == $i ) ? "selected":"" }} @endif>{{$i}} Exp</option>
								<?php } ?>
								 						  
								</select>							
								</div>	

								<div class="col-md-6 col-sm-6 col-xs-12" style="margin-right: -10px;margin-left: 17px;">  
								<select name="exp_to" class="form-control col-md-7 col-xs-12">
								<option value="">Exp To</option>
								<?php for($i=0; $i<=12; $i++){ ?>
								<option value="{{$i}}" @if ($i== old('exp_to'))
								selected="selected"	
								@else
								{{ (isset($edit_data) && $edit_data->exp_to == $i ) ? "selected":"" }} @endif>{{$i}} Exp</option>
								<?php } ?>					  
								</select>							
								</div>						

							</div>
                      </div> 
					   <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="description" >{{ old('description',(isset($edit_data))?$edit_data->description:"")}}</textarea>
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
