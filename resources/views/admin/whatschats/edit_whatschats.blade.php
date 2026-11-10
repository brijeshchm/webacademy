@extends('admin.layouts.app')
@section('title')
Edit whatschats
@endsection
@section('content')
 
<div class="right_col" role="main">
          <div class="">
            			<div class="page-title">
			<div class="title_left">
			<h3>Edit whatschats</h3>
			<div class="succesmessage"></div><div class="errormessage"></div>
			@if(Session::has('success')) 	
				<div class="row">
				<div class="col-md-10 col-md-offset-4">
				<div class="alert alert-success">
				<strong>Success!</strong> {{Session::get('success')}}.
				</div>
				</div>
				</div>
				@endif
				@if(Session::has('failed')) 	
				<div class="row">
				<div class="col-md-10 col-md-offset-4">
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
			<a href="/admin/whatschats/add"  class="btn btn-info"> Add whatschats</a>

			</div>
			</div>
			</div>
			</div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return WhatschatsController.editSaveWhatschats(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">	

					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Caption <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="caption" value="{{ old('caption',(isset($edit_data)) ? $edit_data->caption:"")}}" placeholder="Enter Caption" >
                        </div>
                      </div> 
					  
				  
					  
					 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Image<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">

						
                         @if(isset($edit_data) && $edit_data->image_data !='')									 
							<?php $vimage= json_decode($edit_data->image_data);  ?>
							<div >
							<img src="<?php echo asset($vimage->image_data->src); ?>" style="max-width:100px;" height="100" width="100">	
							<a href="/admin/whatschats/del_icon/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="" name="image_data" value="{{ $edit_data->image_data }}" >
							</div>
							@else											 
							<input type="file" dir="auto" name="image_data" accept="image/*">


							@endif
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
			

 


@endsection
