@extends('admin.layouts.app')
@section('title')
Add Course
@endsection
@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Add Course <small></small></h3><div class="succesmessage"></div><div class="errormessage"></div>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form id="course-form" class="form-horizontal form-label-left" action="" onsubmit="return courseController.saveCourseTitle(this)" > 
                     <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Course Name<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" name="course_name"  class="form-control col-md-7 col-xs-12" placeholder="Enter Course Name"> 
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="title" value="" placeholder="Enter title" >
                        </div>
                      </div> 
  				 
 
					 
                     
					   
					  <div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
							<select name="category" class="form-control col-md-7 col-xs-12 select_category" onchange="get_subcategory(this.value);">
							<option value="">Select Category</option>
							@if(!empty($cetegories))
							@foreach($cetegories as $category)	
							<option value="<?php  echo $category->id; ?>" @if ($category->id== old('category'))
							selected="selected"	
							 @endif> <?php echo $category->category; ?></option>		
							@endforeach
							@endif						
							</select>
							</div>
							</div>  

				 
							
					  
				 
							 
							
						 
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Rating(1-5)<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">                          
						  <select name="rating" class="form-control col-md-7 col-xs-12">
						  <option value="">Select Rating</option>
						  <option value="4">4</option>
						  <option value="4.5">4.5</option>
						  <option value="4.75">4.75</option>
						  <option value="4.8">4.8</option>
						  <option value="4.9">4.9</option>
						  <option value="5">5</option>						  
						  </select>
                        </div>
                      </div> 
					  
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Total Vote Ratings<span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="tel" onkeypress="return isNumericKeyCheck(event);" name="total_rating" placeholder="Enter Total Rating">
                        </div>
                      </div> 
					  
					  
			 
					  <div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Type</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							<select class="form-control col-md-7 col-xs-12 course_type" type="text" name="course_type">
							<option value="">Select Course Type </option>
							<option value="1" @if ('1'== old('course_type'))
							selected="selected"	 @endif >Course Page 1</option>
							<option value="2" @if (2== old('course_type'))
							selected="selected"	
							@endif>Course Page 2</option>

							</select>
							</div>
							</div>
						 
						 
					  
					   
					
					
					  <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit" onclick="check(this)">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
 <!--
 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
$('.summernote').summernote({
height: 200
});
</script>-->

  
<script>   
	  
/* 	  var maxAppend = 0;
$(".add_why_learn").click(function(){
    if (maxAppend >= 8) return;
    var addinput = $(
        '<div><div class="form-group"><label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12"></label><div class="col-md-8 col-sm-8 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" type="text" name="why_learn[]" placeholder="Why should you learn AWS"></textarea> <span class="btn btn-inverse btn-circle m-b-5" onclick="remove(this)" style="margin-right: -38px;color: red;float: right;margin-top: -25px;"><i class="glyphicon glyphicon-trash"></i></span></div></div></div><br />');   
		maxAppend++;

    $(".result_why_learn").append(addinput);
}); */
	  
</script>

<script>
/* function remove(a){
$(a).parent("div").remove();
} */
</script>


<script>	
	window.onload = function()
	{
		  
		get_subcategory(category_id,subcategory_id);	 
		get_categoryPDF(subcategory_id,course_pdf_text);	 
	 
	}	 
</script>
 

<script>

function get_subcategory(cid,sid){	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/subcategory_pdf/get_subcategory_pdf')}}",
	data: {cid:cid,sid:sid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_subcategory_pdf").html(data);
	}
	});

    var cc_id=0;
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/getcategory/get_video_link')}}",
	data: {cid:cid,cc_id:cc_id},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		  
		$("#video_link").val(data);
	}
	});

}

function get_categoryPDF(sid,pid){	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/get_category_course_pdf/get_course_pdf')}}",
	data: {sid:sid,pid:pid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_course_pdf").html(data);
	}
	});



}

</script>
  <script>

function matchYoutubeUrl(url) {
    var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    var matches = url.match(p);
    if(matches){
        return matches[1];
    }
    return false;
}
  function check(sender){
    var url = $('#youtube').val();
    var id = matchYoutubeUrl(url);
    if(id!=false){
      //  alert('True YouTube URL');
    }else{
        alert('Incorrect YouTube URL');
    }
}
</script>
@endsection
