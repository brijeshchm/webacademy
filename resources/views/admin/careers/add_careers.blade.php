@extends('admin.layouts.app')
@section('title')
Add Careers 
@endsection
@section('content')

<div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Add Careers <small></small></h3><div class="succesmessage"></div><div class="errormessage"></div>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form  class="form-horizontal form-label-left" action="" method="post" onsubmit="return careersController.saveCareers(this)" > 

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Job Title <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="job_title" value="" placeholder="Enter job title" >
                        </div>
                      </div> 
					  
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Position</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="position" value="" placeholder="Enter Position" >
                        </div>
                      </div> 
  				 

					 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Profile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							 <input type="text" class="form-control col-md-7 col-xs-12" name="profile" value="" placeholder="Enter profile" >
                        </div>
                      </div>
					 
                       
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Experience<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
								<div class="col-md-6 col-sm-6 col-xs-12" style="margin-left: -8px;">  
								<select name="exp_from" class="form-control col-md-7 col-xs-12">
								<option value="">Exp From</option>
								<?php for($i=0; $i<=12; $i++){ ?>
								<option value="{{$i}}">{{$i}} Exp</option>
								<?php } ?>
								 						  
								</select>							
								</div>	

								<div class="col-md-6 col-sm-6 col-xs-12" style="margin-right: -10px;margin-left: 17px;">  
								<select name="exp_to" class="form-control col-md-7 col-xs-12">
								<option value="">Exp To</option>
								<?php for($i=0; $i<=12; $i++){ ?>
								<option value="{{$i}}">{{$i}} Exp</option>
								<?php } ?>					  
								</select>							
								</div>						

							</div>
                      </div> 
					  
					  
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="description" ></textarea>
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