@extends('site.layouts.app')
@section('title')
@if(!empty($coursesdetails->title))	 
 {{$coursesdetails->title}}; 
@else
	Corporate Academy India's No.1 Best IT Training Institute in Noida | Delhi | Gurgaon
@endif
@endsection 
@section('keyword')
@if(!empty($coursesdetails->meta_keyword))
	{{$coursesdetails->meta_keywords}};
@else
	Corporate Academy India's No.1 Best IT Training Institute in Noida | Delhi | Gurgaon
@endif
@endsection
@section('description')
@if(!empty($coursesdetails->meta_description))
{{$coursesdetails->meta_description}};
@else
	Corporate Academy India's No.1 Best IT Training Institute in Noida | Delhi | Gurgaon for Industrial Training. We conducts IT Software, Hardware, Network &amp; Security Courses training. Corporate Trainer commands all training program. Week Days, Weekend, 6 Week, 6 Months Industrial Training are available
@endif
@endsection
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<style>
.blog-list-details{
	    display: flex;
    flex-wrap: wrap;
}

</style>
<div class="main">
		 <div class="top-banner">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs">
            <div class="top-banner-title">
                <h1><span>Blogs </span></h1> 
			</div>
            <div class="bread_crums">
                <p id="breadcrumbs"><span><span><a href="{{url('/')}}">Home</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <span><a href="{{url('blog')}}">Blogs</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <strong class="breadcrumb_last" aria-current="page">Blog</strong></span></span></span></p>            </div>
        </div>
    </div>
</div>
		<section class="an-new-blog">
			<div class="an-new-blog-heading">
				<div class="container">
                <div class="row">						
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="title">What are you interested in learning?</h3>
                </div>
                
                </div>
					
			
				</div>
			</div>
			<div class="container">
			    <div class="row">
			        <div class="col-md-12">
			            <div class="blog-heading-all text-center mt-4">
			                <h3>Recent Articles</h3>
			            </div>
			        </div>
			    </div>
			</div>
			<div class="container">
			    
			    <div id="ajax_blog_data"></div>
			    
			</div>
		</section>
		 
	</div>

 
	<script>
		$(document).ready(function(){	
			$(".an-filter-button").click(function(){
				var value = $(this).attr('data-filter');				
				if(value == "all")
				{
					$('.filter').show('1000');
				}
				else
				{
					$(".filter").not('.'+value).hide('3000');
					$('.filter').filter('.'+value).show('3000');
					
				}
			});			
			if ($(".an-filter-button").removeClass("active")) {
			$(this).removeClass("active");
			}
			$(this).addClass("active");			
			});

			var header = document.getElementById("filt");
			var btns = header.getElementsByClassName("an-filter-button");
			for (var i = 0; i < btns.length; i++) {
				btns[i].addEventListener("click", function() {
				var current = document.getElementsByClassName("an-psb");
				current[0].className = current[0].className.replace(" an-psb", "");
				this.className += " an-psb";
				});
			}


	</script>
	
	
<script>
$(document).ready(function(){
 
 var _token = $('input[name="_token"]').val();

 loadBlogData('', _token);

 function loadBlogData(id="", _token)
 {
  $.ajax({
   url:"blog/blogLoadData",
   method:"POST",
   data:{id:id, _token:_token},
   success:function(data)
   {
	   //alert(data);
    $('#load_more_button').remove();
    $('#ajax_blog_data').append(data);
   }
  })
 }

 $(document).on('click', '#load_more_button', function(){
  var id = $(this).data('id');
  $('#load_more_button').html('<b>Loading...</b>');
  loadBlogData(id, _token);
 });

});
</script>
	@endsection