@extends('admin.layouts.app')
@section('title')
Edit Sub Category
@endsection
@section('content')
 
<div class="right_col" role="main">
          <div class="">
            			<div class="page-title">
			<div class="title_left">
			<h3>Edit Category</h3>
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
			<a href="/admin/subcategory/add"  class="btn btn-info"> Add Sub Category</a>

			</div>
			</div>
			</div>
			</div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   
                  <div class="x_content">                    
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return subCategoryController.editSaveSubCategory(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Category <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           
						  <select class="form-control col-md-7 col-xs-12 select_category" name="category">
						  <option value=""></option>
						  @if(!empty($categories))
							  @foreach($categories as $category)
						  <option value="{{$category->id}}" @if ($category->id== old('category'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->category == $category->id ) ? "selected":"" }} @endif>{{$category->category}}</option>
						  @endforeach
						  @endif
						  </select>
                        </div>
                      </div>  
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">Sub Category <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="subcategory" value="{{ old('subcategory',(isset($edit_data)) ? $edit_data->subcategory:"")}}" placeholder="Enter Sub Category">
                        </div>
                      </div>
					     
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Icon<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12"><span>Original Dimensions 49*49 Max 3kb</span>

							@if(isset($edit_data) && $edit_data->course_icons !='')									 
							<?php $vicons= json_decode($edit_data->course_icons);  ?>
							<div >
							<img src="<?php echo asset('public/'.$vicons['course_icons']['src']); ?>" style="max-width:100px;" height="100" width="100">	
							<a href="/admin/subcategory/del_icon/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="form-control col-md-7 col-xs-12" name="course_icons" value="{{ $edit_data->course_icons }}" accept=".jpeg,.jpg,.png,.svg">
							</div>
							@else											 
							<input type="file" class="form-control col-md-7 col-xs-12" dir="auto" name="course_icons" accept=".jpeg,.jpg,.png,.svg">


							@endif
                           
                        </div>
                      </div>  

					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Image<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12"><span>Original Dimensions 290*196 Max 5kb</span>		

							@if(isset($edit_data) && $edit_data->course_image !='')									 
							<?php $vimage= json_decode($edit_data->course_image);  ?>
							<div >
							<img src="<?php echo asset('public/'.$vimage['course_image']['src']); ?>" style="max-width:100px;" height="100" width="100">	
							<a href="/admin/subcategory/del_image/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="form-control col-md-7 col-xs-12" name="course_image" value="{{ $edit_data->course_image }}" accept=".jpeg,.jpg,.png,.svg">
							</div>
							@else											 
							<input type="file" dir="auto" class="form-control col-md-7 col-xs-12" name="course_image" accept=".jpeg,.jpg,.png,.svg">


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
