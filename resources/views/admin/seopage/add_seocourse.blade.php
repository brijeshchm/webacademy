@extends('admin.layouts.app')
@section('title')
Add SEO Course Page
@endsection
@section('content')

<div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Add SEO Course Page<small></small></h3><div class="succesmessage"></div><div class="errormessage"></div>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                    
                    <form id="course-form" class="form-horizontal form-label-left" action="" onsubmit="return SEOController.saveCourseTitle(this)" > 			
						  <div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Type<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
							<select name="course_type" class="form-control col-md-7 col-xs-12 course_type" onchange="get_courseType(this.value);">
							<option value="">Type </option>						 
							<option value="1">Course Type 1</option>
							<option value="2">Course Type 2</option>							 				
							</select>
							</div>
						</div> 
					<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course Category<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">                          
							<select name="category" class="form-control col-md-7 col-xs-12 show_category" onchange="get_courseName(this.value);"></select>
							</div>
					</div> 					
				 
				 
							
					
							<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">Course<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">   
							<select name="course" class="form-control col-md-7 col-xs-12  show_course_name" onchange="get_courseCity(this.value);">

							</select>
							</div>
							</div> 
							 <div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">City Territory <span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">       
 				 
							<select name="city_territory" id="city_territory" class="form-control col-md-7 col-xs-12" >
							 <option value="">Select Territory</option>
							 <option value="Online">Online</option>
							 <option value="cityNCR">City NCR</option>
							 <option value="allcity">All City</option>
							 			
							</select>
							</div>
						</div>  

						<div class="online">
						<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">City<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">    				
							<select name="city-Online" class="form-control col-md-7 col-xs-12 show_city_online" >
							 <option value="">Select City</option>
							 <option value="Online">Online</option>
							 		
							</select>
							</div>
						</div>  
						</div> 
						
						<div class="cityNCR">
						<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">City NCR<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">    				
							<select name="city-cityNCR" class="form-control col-md-7 col-xs-12 show_city_NCR" >
							 <option value="">Select City</option>
							 		
							</select>
							</div>
						</div>  
						</div>  
						
						
						<div class="allcity">
						<div class="form-group">
							<label for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12">City<span class="required">*</span></label>
							<div class="col-md-8 col-sm-8 col-xs-12">    				
							<select name="city-allcity" class="form-control col-md-7 col-xs-12 show_city_name" >
							 <option value="">Select City</option>						 
							</select>
							</div>
						</div>  
						</div>  
						 
						   
							
							 
					  
					  <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						   
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
 
 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
$('.summernote').summernote({
height: 200
});
</script>

  
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
get_courseType(type,category_id);	
//$course_type= $('.course_type option:selected').val();
//alert($course_type);
get_coursecategory(category_id);	 
//get_categoryPDF(subcategory_id,course_pdf_text);	
get_courseName(sid,pid);	
get_courseCity(cid,coid);	
}	 
</script>
<script>
/* function get_courseType(tval,category_id){	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/seopage/get_coursecategoryType')}}",
	data: {tval:tval,cat:category_id},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_cotegory_course").html(data);
	}
	});
}
function get_coursecategory(cid,sid){ 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/seocategory_pdf/get_seocategory_pdf')}}",
	data: {cid:cid,sid:sid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_coursesubcategory").html(data);
	}
	});
}

function get_courseName(sid,pid){	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/get_seocategory_course_pdf/get_seocourse_pdf')}}",
	data: {sid:sid,pid:pid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_course_name").html(data);
	}
	});
	} */
</script>
  <script>
 function get_courseType(tval,category_id){	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/seopage/get_coursecategoryType')}}",
	data: {tval:tval,cat:category_id},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_category").html(data);
	}
	});
}
function get_coursecategory(cid,sid){	
//alert(cid); 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/seopage/get_coursesubcategory')}}",
	data: {cid:cid,sid:sid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_coursesubcategory").html(data);
	}
	});



}

function get_courseName(sid,pid){	 
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/seopage/get_category_course')}}",
	data: {sid:sid,pid:pid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_course_name").html(data);
	}
	});
} 
function get_courseCity(cid,coid){	 
//alert(cid);
	var token = $('input[name=_token]').val();
	
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/seopage/get_courseCityOnline')}}",
	data: {cid:cid,coid:coid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_city_online").html(data);
	}
	});	
	
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/seopage/get_courseCity')}}",
	data: {cid:cid,coid:coid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_city_name").html(data);
	}
	});
	
	$.ajax({
	type: "post",	 
	url: "{{URl('admin/seopage/get_courseNCRCity')}}",
	data: {cid:cid,coid:coid},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{ 		 
		$(".show_city_NCR").html(data);
	}
	});
} 
</script>
  
@endsection
