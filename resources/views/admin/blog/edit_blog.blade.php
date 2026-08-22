@extends('admin.layouts.app')
@section('title')
Edit Blog 
@endsection 
@section('content')
 
<div class="right_col" role="main">
          <div class="">
            			<div class="page-title">
			<div class="title_left">
			<h3>Edit Blog</h3>
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
			<a href="/admin/blog/add"  class="btn btn-info"> Add Blog</a>

			</div>
			</div>
			</div>
			</div>

            <div class="clearfix"></div>
			
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return blogController.editSaveBlog(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">	


                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Titile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="title" value="{{ old('title',(isset($edit_data)) ? $edit_data->title:"")}}" placeholder="Enter Blog title" >
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Slug <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="slug" value="{{ old('slug',(isset($edit_data)) ? $edit_data->slug:"")}}" placeholder="Enter Blog slug" >
                        </div>
                      </div> 
  				 

					 <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Sub Titile <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="sub_title" value="{{ old('sub_title',(isset($edit_data)) ? $edit_data->sub_title:"")}}" placeholder="Enter Blog Sub Title" >
                        </div>
                      </div>
					 
                       
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Rating(1-5)<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						    <select name="rating" class="form-control col-md-7 col-xs-12">
						  <option value="">Select Rating</option>
						  <option value="4" @if (4== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4 ) ? "selected":"" }} @endif >4</option>
						  <option value="4.5" @if (4.5== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.5 ) ? "selected":"" }} @endif >4.5</option>
						  <option value="4.75" @if (4.75== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.75 ) ? "selected":"" }} @endif >4.75</option>
						  <option value="4.8" @if (4.8== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.8 ) ? "selected":"" }} @endif >4.8</option>
						  <option value="4.9" @if (4.9== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 4.9 ) ? "selected":"" }} @endif >4.9</option>
						  <option value="5" @if (5== old('rating'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->rating == 5 ) ? "selected":"" }} @endif >5</option>						  
						  </select>
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Total Ratings<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="number" name="total_rating" value="{{ old('total_rating',(isset($edit_data)) ? $edit_data->total_rating:"")}}" placeholder="Enter Total Rating">
                        </div>
                      </div> 
					  
					    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="category" class="form-control col-md-7 col-xs-12 select_category" >
						  <option value="">Select Category</option>
							@if(!empty($cetegories))
							@foreach($cetegories as $category)	
							<option value="<?php  echo $category->id; ?>" @if ($category->id== old('category'))
								selected="selected"	
							@else
							{{ (isset($edit_data) && $edit_data->category == $category->id ) ? "selected":"" }} @endif> <?php echo $category->category; ?></option>		
							@endforeach
							@endif						
						  </select>
                        </div>
                      </div> 
				 
					     <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Title<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_title" placeholder="Enter Meta Title">{{ old('meta_title',(isset($edit_data)) ? $edit_data->meta_title:"")}}</textarea>
                        </div>
                      </div>
					  
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Keyword<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_keywords" placeholder="Enter Meta Keyword">{{ old('meta_keywords',(isset($edit_data)) ? $edit_data->meta_keywords:"")}}</textarea>
                        </div>
                      </div>
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Meta Description<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" type="text" name="meta_description" placeholder="Enter Meta Description">{{ old('meta_description',(isset($edit_data)) ? $edit_data->meta_description:"")}}</textarea>
                        </div>
                      </div>	


					  
						  					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Blog Defination<span class="required">*</span></label>					
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12" name="blog_defination" placeholder="Enter blog defination">{{ old('blog_defination',(isset($edit_data)) ? $edit_data->blog_defination:"")}}</textarea>
                        </div>
                    </div> 	
					  	<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Heading<span class="required">*</span></label>					
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="heading" value="{{ old('heading',(isset($edit_data)) ? $edit_data->heading:"")}}" placeholder="Enter heading"> 
                        </div>
                    </div> 	
						  					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Blog About<span class="required">*</span></label>					
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 summernote" name="blog_about" placeholder="Enter Blog Content">{{ old('blog_about',(isset($edit_data)) ? $edit_data->blog_about:"")}}</textarea>
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


			<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   		<div class="title_left">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-left top_search">
			<div class="input-group">
			<h3> Blog Content</h3>

			</div>
			</div>
			</div>
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return blogController.editSaveContent(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">	

   	


					  
						  					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Top heading<span class="required">*</span></label>					
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12" name="top_heading" placeholder="Enter top heading">{{ old('top_heading',(isset($edit_data)) ? $edit_data->top_heading:"")}}</textarea>
                        </div>
                    </div> 	
					  
						  					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Top Content<span class="required">*</span></label>					
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 summernote" name="top_content" placeholder="Enter top Content">{{ old('top_content',(isset($edit_data)) ? $edit_data->top_content:"")}}</textarea>
                        </div>
                    </div> 		

					
					
							  					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Bottom heading<span class="required">*</span></label>					
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12" name="bottom_heading" placeholder="Enter Bottom heading">{{ old('bottom_heading',(isset($edit_data)) ? $edit_data->bottom_heading:"")}}</textarea>
                        </div>
                    </div> 	
					  
						  					
					<div class="form-group">       
					<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Bottom Content<span class="required">*</span></label>					
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <textarea type="text" class="form-control col-md-7 col-xs-12 summernote" name="bottom_content" placeholder="Enter bottom Content">{{ old('bottom_content',(isset($edit_data)) ? $edit_data->bottom_content:"")}}</textarea>
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
			
			
			<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   		<div class="title_left">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-left top_search">
			<div class="input-group">
			<h3> Blog Image</h3>

			</div>
			</div>
			</div>
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return blogController.editSaveImage(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">	

   	

 
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Blog Image<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12"><span>Origanal dimensions 320*238</span>
                         @if(isset($edit_data) && !empty($edit_data->blog_image))									 
							<?php $vicons= json_decode($edit_data->blog_image);  ?>
							<div >
							<img src="<?php echo asset('public/'.$vicons->blog_image->src); ?>" style="max-width:100px;" height="100" width="100">	
							<a href="/admin/blog/del_icon/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="" name="blog_image" value="{{ $edit_data->blog_image }}" >
							</div>
							@else											 
							<input type="file" dir="auto" name="blog_image" accept=".jpeg,.jpg,.png,.svg">
							@endif
                        </div>
                      </div>    
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Blog banner<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12"><span>Origanal dimensions 730*432</span>
                         @if(isset($edit_data) && !empty($edit_data->image_banner))									 
							<?php $vimage= json_decode($edit_data->image_banner);  ?>
							<div >
							<img src="<?php echo asset('public/'.$vimage->image_banner->src); ?>" style="max-width:100px;" height="100" width="100">	
							<a href="/admin/blog/del_image/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5 deleteIcon"><i class="glyphicon glyphicon-trash"></i></a>
							<input type="hidden" class="" name="image_banner" value="{{ $edit_data->image_banner }}" >
							</div>
							@else											 
							<input type="file" dir="auto" name="image_banner" accept=".jpeg,.jpg,.png,.svg">
							@endif
                        </div>
                      </div>   
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Image alt<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                         <?php 
						if(isset($edit_data) && $edit_data->blog_image !=''){	
						$altname= json_decode($edit_data->blog_image);   
						$alt =$altname->blog_image->alt;
						}else{
						$alt=""; 
						}
						?> 
                          <input class="form-control col-md-7 col-xs-12" type="text" name="alt" value="<?php if($alt){ echo $alt; } ?>" placeholder="Enter image alt name">
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
			
			
			<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   		<div class="title_left">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-left top_search">
			<div class="input-group">
			<h3> Blog Faq</h3>

			</div>
			</div>
			</div>
                  <div class="x_content">                    
                    <form  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return blogController.editSaveFaq(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">	

   	
 
					  
				 	
					   <div class="section-border">
            <h4>FAQ Section</h4>
       
                {{ csrf_field() }}

        <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 1</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq1" placeholder="Enter FAQ Question 1" value="{{ $edit_data->faqq1 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 1</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa1" placeholder="Enter FAQ Answer 1">{{ $edit_data->faqa1 }}</textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 2</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq2" placeholder="Enter FAQ Question 2" value="{{ $edit_data->faqq2 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 2</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa2" placeholder="Enter FAQ Answer 2">{{ $edit_data->faqa2 }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 3</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq3" placeholder="Enter FAQ Question 3" value="{{ $edit_data->faqq3 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 3</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa3" placeholder="Enter FAQ Answer 3">{{ $edit_data->faqa3 }}</textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 4</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq4" placeholder="Enter FAQ Question 4" value="{{ $edit_data->faqq4 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 4</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa4" placeholder="Enter FAQ Answer 4">{{ $edit_data->faqa4 }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 5</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq5" placeholder="Enter FAQ Question 5" value="{{ $edit_data->faqq5 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 5</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa5" placeholder="Enter FAQ Answer 5">{{ $edit_data->faqa5 }}</textarea>
                </div>
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script type="text/javascript">
$('.summernote').summernote({
height: 200
});
</script>
 
<script>	
	window.onload = function()
	{
		var category_id 	='<?php echo $edit_data->category; ?>';
	 	 
	 
	}	 
</script>
  


@endsection
