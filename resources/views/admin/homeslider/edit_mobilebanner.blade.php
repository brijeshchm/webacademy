@extends('admin.layouts.app')
@section('title')
Edit Mobile Banner
@endsection
@section('content')
 
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Edit Mobile Banner</h3>
				<div class="succesmessage"></div><div class="errormessage"></div>
			@if(Session::has('success')) 	
				<div class="row">
				<div class="col-md-9 col-md-offset-3">
				<div class="alert alert-success">
				<strong>Success!</strong> {{Session::get('success')}}.
				</div>
				</div>
				</div>
				@endif
				@if(Session::has('failed')) 	
				<div class="row">
				<div class="col-md-9 col-md-offset-3">
				<div class="alert alert-danger">
				<strong>!</strong> {{Session::get('failed')}}.
				</div>
				</div>
				</div>
				@endif
			</div>

			</div>

            <div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
                   
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" enctype="multipart/form-data" onsubmit="return homesliderController.editMobilebanner(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" method="post">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile Banner Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="banner_name" value="{{ old('banner_name',(isset($edit_data)) ? $edit_data->banner_name:"")}}" placeholder="Mobile Banner Name">
                        </div>
                      </div>
					 <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile Banner Image</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							@if(isset($edit_data) && $edit_data->image_banner !='')									 
							<?php $vimage= json_decode($edit_data->image_banner);  ?>
							<div >
							<img src="<?php echo asset('public/'.$vimage['image_banner']['src']); ?>" style="max-width:100px;" height="100" width="100">	
							<a href="/admin/mobilebanner/del_icon/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="" name="image_banner" value="{{ $edit_data->image_banner }}" accept=".jpeg,.jpg,.png,.svg" >
							</div>
							@else											 
							<input type="file" dir="auto" name="image_banner" accept=".jpeg,.jpg,.png,.svg" >
							@endif
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
 
 

 


@endsection
