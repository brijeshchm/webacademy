@extends('admin.layouts.app')
@section('title')
Edit Course PDF
@endsection
@section('content')
 
<div class="right_col" role="main">
          <div class="">
            			<div class="page-title">
			<div class="title_left">
			<h3>Edit Course PDF</h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			@if(Session::has('success')) 	
				<div class="row">
				<div class="col-md-10 col-md-offset-4">
				<div class="alert alert-success">
				<strong></strong> {{Session::get('success')}}.
				</div>
				</div>
				</div>
				@endif
				@if(Session::has('failed')) 	
				<div class="row">
				<div class="col-md-10 col-md-offset-4">
				<div class="alert alert-danger">
				<strong></strong> {{Session::get('failed')}}.
				</div>
				</div>
				</div>
				@endif
			</div>

			<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
			<a href="/admin/coursepdf/add"  class="btn btn-info"> Add Course PDF</a>

			</div>
			</div>
			</div>
			</div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   
                  <div class="x_content">                    
                    <form  class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return coursePdfController.editSaveCoursePdf(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multipart/form-data">	

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
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course PDF<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12"><span></span>

							@if(isset($edit_data) && $edit_data->coursePdfText !='')									 
							 
							<div >
							<?php echo  $edit_data->coursePdfText; ?>							 	
							<a href="/admin/coursepdf/del_icon/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="form-control col-md-7 col-xs-12" name="course_pdf" value="{{ $edit_data->coursePdfText }}" accept=".pdf">
							</div>
							@else											 
							<input type="file" class="form-control col-md-7 col-xs-12" dir="auto" name="course_pdf" accept=".pdf">


							@endif
                           
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
