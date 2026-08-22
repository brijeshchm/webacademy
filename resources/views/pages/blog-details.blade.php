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
	{{$blog_details->meta_keyword}};
@else
	India's No.1: IT Training Institute in Noida | Delhi | Gurgaon
@endif
@endsection
@section('description')
@if(!empty($blog_details->meta_description))
{{$blog_details->meta_description}};
@else
	India's No.1 IT Training Institute in Noida | Delhi | Gurgaon for Industrial Training. We conducts IT Software, Hardware, Network &amp; Security Courses training. Corporate Trainer commands all training program. Week Days, Weekend, 6 Week, 6 Months Industrial Training are available
@endif
@endsection
@section('content')
<div class="main">
			<div class="top-banner">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs">
            <div class="top-banner-title">
                <h1><span>Blogs Details </span></h1> 
			</div>
            <div class="bread_crums">
                <p id="breadcrumbs"><span><span><a href="{{url('/')}}">Home</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <span><a href="{{url('blog')}}">Blogs</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <strong class="breadcrumb_last" aria-current="page">Blog</strong></span></span></span></p>            </div>
        </div>
    </div>
</div>
		 
		
			<section class="blog-cnt-id">
			   
				<div class="container">
				 
					<div class="row">
						<div class="col-md-8">
						    <div class="blog-title-box">
							<div class="blog-cnt-id-heading">
								<h3>{{$blog_details->title}}</h3>
								<?php 
$rating=$blog_details->rating;
$stars = '<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star-half"></i>';

switch($rating){
case 4:
$stars = '<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>';
break;
case 4.5:
$stars = '<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star-half"></i>';
break;
case 4.75:
$stars = '<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star-half"></i>';
break;
case 4.8:
$stars = '<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star-half"></i>';
break;
case 4.9:
$stars = '<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star-half"></i>';
break;
case 5:
$stars = '<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star"></i>';
break;
} ?>

{!!$stars!!}
   
<span>{{$blog_details->rating}} out of 5 based on {{$blog_details->total_rating}} votes  </span>
 
 
<div class="tsm-dec"> 
 <?php $vcategoryimage= unserialize($blog_details->blog_icons); 
    if(!empty($vcategoryimage)){
    ?>
    <img src="{{asset('public/'.$vcategoryimage['blog_icons']['src'])}}" alt="{{($vcategoryimage['blog_icons']['alt'])}}" class="avatar avatar-96 photo author-avatar border rounded-circle blur-up lazyloaded" height="96" width="96">  
    <?php } ?>
 
<div class="name-and-date"> 

<span class="tstm-name"><a href="#0" title="tstm-name" rel="author">{{$blog_details->categoryname}}</a>
 
</span> 


</div>
 
	<div class="social-link soci-right">
			<p><i class="fa fa-share-alt" aria-hidden="true"></i></p>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			<a href="https://www.facebook.com/sharer.php?u=<?php echo url()->full(); ?>" target="_blank"><i class="fa fa-facebook" style="background: #4267B2;color:#fff;"></i></a>
			
			<a href="https://twitter.com/share"  class="" data-url="<?php echo url()->full(); ?>" data-via="<?php  echo $blog_details->title;?>" target="_blank" data-related="realdannys" data-hashtags="<?php echo $blog_details->title; ?>"><i class="fa fa-twitter mr-0" style="background: rgba(29,161,242,1.00);color:#fff;"></i></a>
			
			 <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php  echo url()->full(); ?>&title=<?php echo $blog_details->title; ?>" target="_blank"> <i class="fa fa-linkedin" style="background: #0a66c2;color:#fff;"></i></a>
			</div>

</div>
							</div>
					
						
							<div class="pi-desc">
								<div class="pi-desc-requirement">
								  {!!$blog_details->blog_content!!}						
								 
								</div>
								 
							</div>
						</div>
						</div>
						<div class="col-md-4">
							<div class="col-blog-right-section blog-categ">
								<div class="corptab tab-blogs">
							<div class="heading-category" onclick="mycategory()">
								<strong>Top Categories</strong>
								<i class="fa fa-angle-up" id="croptabicon"></i>
							</div>
                            <div class="corp-tablink-group" id="myLinks">
                                @if(!empty($blogcategory))
                                @foreach($blogcategory as $category)
                            <a href="{{url('blog/category/'.generate_slug($category->categoryname))}}" >{{$category->categoryname}}</a>
                            @endforeach
                            @endif                                                       
                            
                            </div>



							
						</div>
								
								<div class="an-pi-right" style="margin-top: 40px;background: #f9f9f9;">
									<div class="blog-course-inner">
										<h3>Recent Post</h3>
										<div class="course-inner">
										    <?php  if($blogs){
										    foreach($blogs as $blog){
										       
										    ?>
											<div class="course-inner-section">
												<img src="{{url('blog/'.$blog->slug)}}" alt="">
												<span>{{$blog->title}}</span>
											</div>
											<?php  } } ?>
											
										</div>
									</div>
								</div>	
								
								<div class="an-pi-right" style="margin-top: 40px;background: #f9f9f9;">
									<div class="blog-course-inner">
										<h3>Trending Course</h3>
										<div class="course-inner">
											<div class="course-inner-section">
											  
											 <a href="{{url('courses/aws-certification-training')}}">AWS</a>
												 
											</div>
											<div class="course-inner-section">
												<a href="{{url('courses/cloud-computing-certification-training')}}">Cloud</a>
											</div>
											<div class="course-inner-section">
												<a href="{{url('courses/data-science-certification-training')}}">Data Science</a>
											</div>
											<div class="course-inner-section">
											<a href="{{url('courses/python-certification-training')}}">Python</a>
											</div>
											<div class="course-inner-section">
												<a href="{{url('courses/machine-learning-certification-training')}}">Machine Learning</a>
											</div>
											<div class="course-inner-section">
											<a href="{{url('courses/full-stack-data-science-course')}}">Full Stack</a>
											</div>
										</div>
									</div>
								</div>	
									<div class="an-pi-right" style="margin-top: 40px;background: #f9f9f9;">
									<div class="blog-course-inner">
										<h3>Master Program</h3>
										<div class="course-inner">
											<div class="course-inner-section">
											  
											 <a href="{{url('courses/aws-certification-training')}}">AWS</a>
												 
											</div>
											<div class="course-inner-section">
												<a href="{{url('courses/cloud-computing-certification-training')}}">Cloud</a>
											</div>
											<div class="course-inner-section">
												<a href="{{url('courses/data-science-certification-training')}}">Data Science</a>
											</div>
											<div class="course-inner-section">
											<a href="{{url('courses/python-certification-training')}}">Python</a>
											</div>
											<div class="course-inner-section">
												<a href="{{url('courses/machine-learning-certification-training')}}">Machine Learning</a>
											</div>
											<div class="course-inner-section">
											<a href="{{url('courses/full-stack-data-science-course')}}">Full Stack</a>
											</div>
										</div>
									</div>
								</div>	
								
								
								
								
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
			
	<?php function generate_slug($slug=null){
	if(is_null($slug)){
		return null;
	}
	$slug = explode(" ",$slug);
	$slug = array_map('trim',$slug);
 
	$slug = array_map('strtolower',$slug);
	$slug = implode("-",$slug);
	return $slug;
} ?>
		
@endsection