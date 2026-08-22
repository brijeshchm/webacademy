@extends('admin.layouts.app')
@section('title')
Add Batch Date & Time
@endsection
@section('content')

<div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Add Batch Date & Time <small></small></h3><div class="succesmessage"></div><div class="errormessage"></div>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form id="course-form" class="form-horizontal form-label-left" action="" autocomplete="off" onsubmit="return offerController.saveOffer(this)" > 

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
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Amount To de decide<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="amount_to_decide" id="amount_to_decide" value="" placeholder="Enter Amount To de decide" >
                        </div>
                      </div> 
					  
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Offer Percentage<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="offer_percentage" id="offer_percentage" value="" placeholder="Enter Offer in Number" onblur="handlingOffer()">
                        </div>
                      </div> 
					  
  				 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Total Amount</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="total_amount" id="total_amount" value="" readonly>
                        </div>
                      </div> 
  				 

					 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Day Occurrence<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="occurrence" >
							<option value="">Select Occurrence</option>
							<option value="WEEKDAY">WEEKDAY</option>
							<option value="WEEKEND">WEEKEND</option>
							<option value="FASTRACK">FASTRACK</option>
							 
							</select>
                        </div>
                      </div>
					 
						
						<div class="form-group">
						 <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Batch Start Date And Time<span class="required">*</span></label>
						 <div class="col-md-4 col-sm-4 col-xs-12">   						 
						<input type="text" class="form-control start_date" name="start_date"  value="">						 
						</div> 
						
						<div class="col-md-4 col-sm-4 col-xs-12">   						 
						<input type="text" class="form-control start_time" name="start_time"  value="">						 
						</div>
						 
						</div>
					 
						 		
						<div class="form-group">
						 <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Discount Call<span class="required">*</span></label>
						 <div class="col-md-4 col-sm-4 col-xs-12">   Yes						 
						<input type="radio" name="discount_call"  value="1">						 
						</div> 
						
						<div class="col-md-4 col-sm-4 col-xs-12">   No						 
						<input type="radio" name="discount_call"  value="0">						 
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