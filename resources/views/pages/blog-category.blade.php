@extends('site.layouts.app')
@section('title')
@if(!empty($blog_details->title))	 
 {{$blog_details->title}}; 
@else
	India's No.1 IT Training Institute in Noida | Delhi | Gurgaon
@endif
@endsection 
@section('keyword')
@if(!empty($blog_details->meta_keyword))
	{{$blog_details->meta_keywords}};
@else
 India's No.1 IT Training Institute in Noida | Delhi | Gurgaon
@endif
@endsection
@section('description')
@if(!empty($blog_details->meta_description))
{{$blog_details->meta_description}};
@else
	Best IT Training Institute in Noida | Delhi | Gurgaon for Industrial Training. We conducts IT Software, Hardware, Network &amp; Security Courses training. Corporate Trainer commands all training program. Week Days, Weekend, 6 Week, 6 Months Industrial Training are available
@endif
@endsection
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<div class="main">
	    	<style>
.blog-list-category-details{
	    display: flex;
    flex-wrap: wrap;
}
</style>
	    	    <section class="blog-cat-details-section">
			    	<div class="container">
				 
					<div class="row d-flex align-items-center">
			       <div class="col-md-8">
				        <div class="details-blogs-catag">
						<div class="breadcum-search mb-0">
							<div class="breadcum blog-det-breadcum">
								<span>Home</span>
								<i class="fa fa-angle-right"></i>
							    <span><a href="{{url('blog')}}">Blog</a></span><i class="fa fa-angle-right"></i>
								<span><a href="{{url('blog/category/'.generate_slug($url))}}" ><?php if(!empty($url)){ echo ucwords($url); } ?></a></span>
							</div>
						
						</div>
						
						
					</div>
				</div>
				
				</div>
				</div>
			</section>
		<section class="an-new-blog-heading">
			
			<div class="container">
		
				<div class="row">	
				
				<div class="col-lg-12">
				    				<h1 class="title mb-3"> <a href="#0"><i class="icon-blog-left-arrow d-md-none d-lg-none"></i></a> What do you want to learn in <?php if(!empty($url)){ echo ucwords($url); } ?> ?</h1>

				</div>
				</div>
				
				<div id="ajax_blog_category_data"></div>
				 
						 
			</div>
		</section>
		
		</div>
		
<?php function generate_slug($slug=null){
	if(is_null($slug)){
		return null;
	}
	$slug = explode(" ",$slug);
	$slug = array_map('trim',$slug);
	//$slug = array_map('remove_splchars',$slug);
	$slug = array_map('strtolower',$slug);
	$slug = implode("-",$slug);
	return $slug;
} ?>	
		
<script>

jQuery(document).ready(function(){
 
 var _token = $('input[name="_token"]').val();
var url= '<?php echo generate_slug($url); ?>';
 
 loadBlogCategoryData('', _token);

 function loadBlogCategoryData(id="", _token)
 {
  $.ajax({
   url:"/blog/blogLoadCategoryData/"+url,
   method:"POST",
   data:{id:id, _token:_token},
   success:function(data)
   {
	   //alert(data);
    $('#load_more_button').remove();
    $('#ajax_blog_category_data').append(data);
   }
  })
 }

 $(document).on('click', '#load_more_button', function(){
  var id = $(this).data('id');
  $('#load_more_button').html('<b>Loading...</b>');
  loadBlogCategoryData(id, _token);
 });

});
</script>
		@endsection