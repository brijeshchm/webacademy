@extends('admin.layouts.app')
@section('title')
Edit Batch Date & Time
@endsection
@section('content')
 
<div class="right_col" role="main">
          <div class="">
            			<div class="page-title">
			<div class="title_left">
			<h3>Edit Batch Date & Time</h3>
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
			<a href="/admin/offer/add"  class="btn btn-info"> Add Batch Date & Time</a>

			</div>
			</div>
			</div>
			</div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return offerController.editSaveOffer(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">	

					 <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="category" class="form-control col-md-7 col-xs-12 select_category category">
						  <option value="">Select Category</option>
							@if(!empty($cetegories))
							@foreach($cetegories as $category)	
							<option value="<?php  echo $category->id; ?>" @if ($category->id== old('category'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->category == $category->id ) ? "selected":"" }} @endif><?php echo $category->category; ?></option>		
							@endforeach
							@endif						
						  </select>
                        </div>
                      </div>  

					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Sub Category<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="subcategory" class="form-control col-md-7 col-xs-12 select_subcategory show_subcategory">
						   			<option value="">Select Sub Category</option>	
						  </select>
                        </div>
                      </div>		 
					   	  		
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Amount To de decide<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="amount_to_decide" id="amount_to_decide" value="{{ old('amount_to_decide',(isset($edit_data)) ? $edit_data->amount_to_decide:"")}}" placeholder="Enter Amount To de decide" >
                        </div>
                      </div> 
					  
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Offer Percentage<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="offer_percentage" id="offer_percentage" value="{{ old('offer_percentage',(isset($edit_data)) ? $edit_data->offer_percentage:"")}}" placeholder="Enter Offer in Number" onblur="handlingOffer()">
                        </div>
                      </div> 
					  
  				 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Total Amount</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="total_amount" id="total_amount" value="{{ old('total_amount',(isset($edit_data)) ? $edit_data->total_amount:"")}}" readonly>
                        </div>
                      </div> 
  				 

					 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Day Occurrence<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="occurrence" >
							<option value="">Select Occurrence</option>
							<option value="WEEKDAY" @if ('WEEKDAY'== old('occurrence'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->occurrence == 'WEEKDAY') ? "selected":"" }} @endif>WEEKDAY</option>
							<option value="WEEKEND" @if ('WEEKEND'== old('occurrence'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->occurrence == 'WEEKEND' ) ? "selected":"" }} @endif>WEEKEND</option>
							<option value="FASTRACK" @if ('FASTRACK'== old('occurrence'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->occurrence == 'FASTRACK' ) ? "selected":"" }} @endif>FASTRACK</option>
							 
							</select>
                        </div>
                      </div>
					  <div class="form-group">
						 <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Batch Start Date And Time<span class="required">*</span></label>
						 <div class="col-md-4 col-sm-4 col-xs-12">   						 
						<input type="text" class="form-control start_date" name="start_date"  value="{{ old('start_date',(isset($edit_data)) ? $edit_data->start_date:"")}}">						 
						</div> 
						
						<div class="col-md-4 col-sm-4 col-xs-12">   						 
						<input type="text" class="form-control start_time" name="start_time"  value="{{ old('start_time',(isset($edit_data)) ? $edit_data->start_time:"")}}">						 
						</div>
						 
						</div>
					  
					 		   	 <div class="form-group">
						 <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Discount Call<span class="required">*</span></label>
						 <div class="col-md-4 col-sm-4 col-xs-12">   Yes						 
						<input type="radio" name="discount_call"  value="1"  @if (1== old('discount_call'))
								checked="checked"	
							@else
							{{ (isset($edit_data) && $edit_data->discount_call == 1 ) ? "checked":"" }} @endif>						 
						</div> 
						
						<div class="col-md-4 col-sm-4 col-xs-12">   No						 
						<input type="radio" name="discount_call"  value="0"  @if(old('discount_call')=='0') checked="checked" @else {{(isset($edit_data) && $edit_data->discount_call=='0')?"checked":"" }} @endif>						 
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
