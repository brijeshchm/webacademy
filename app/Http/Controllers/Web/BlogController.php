<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  
use Auth;
use Hash;
use Validator;
use DB;
use Session;
use Carbon\Carbon; 
use App\Models\Courses;
use App\Models\CoursesMaster;
use App\Models\Category;
use App\Models\FAQs;
use App\Models\Social;
use App\Speciality;
use App\Models\Reviews;
use App\Models\Blog;
use App\Models\Testimonial;
 
class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        
	   
    }
 
 /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function blog(Request $reques)
    {	 
		$keyword="";
		$blogs =DB::table('web_blog as blog'); 
		$blogs  =$blogs->join('web_categories as category','blog.category','=','category.id','left');
		$blogs =$blogs->select('blog.*','category.category as categoryname','category.id as categoryid');
    	$blogs =$blogs->orderby('blog.id','desc');
    	$blogs =$blogs->where('blog.status',1);
		$blogs =$blogs->get();
		 
		$categoryes =DB::table('web_blog as blog'); 
		$categoryes  =$categoryes->join('web_categories as category','blog.category','=','category.id','left');
		$categoryes =$categoryes->select('category.*','blog.id as blogid','blog.title','blog.sub_title','blog.slug','category.category as categoryname','category.id as categoryid');
		$categoryes =$categoryes->groupby('blog.category');
		$categoryes =$categoryes->where('blog.status',1);
	//	$categoryes =$categoryes->limit('6');
		$categoryes =$categoryes->get();
		 
		//echo "<pre>";print_r($blogs);die;
        return view('site.blog',['blogs'=>$blogs,'categoryes'=>$categoryes]);
    } 
	
 
 /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function blogdetails(Request $reques,$url)
    {	 
		//echo $url;die;
	//	$blog_details =Blog::where('slug',$url)->first();
		
		$blogcategory =DB::table('web_blog as blog'); 
		$blogcategory  =$blogcategory->join('web_categories as category','blog.category','=','category.id','left');
		$blogcategory =$blogcategory->select('blog.*','category.category as categoryname','category.id as categoryid');
    	$blogcategory =$blogcategory->orderby('blog.id','desc');
    	$blogcategory =$blogcategory->where('blog.status','1');
		$blogcategory =$blogcategory->get();
	
	//	echo "<pre>";print_r($blogcategory);die;
$blog_details = DB::table('web_blog as blog')
    ->leftJoin('web_categories as category', 'blog.category', '=', 'category.id')
    ->select('blog.*', 'category.category as categoryname', 'category.id as categoryid')
    ->where('blog.slug', $url)
    ->where('blog.status', 1) // re-enabled — see flag below
    ->orderBy('blog.id', 'desc')
    ->first();

if (!$blog_details) {
    abort(404); // see flag below
}
			$countblog =Blog::where('category',$blog_details->category)->where('status',1)->count();
		
	//	echo "<pre>";print_r($countblog);die;
		
		$previous = Blog::where('id', '<', $blog_details->id)->orderBy('id','desc')->first();
	//	$previous = Blog::where('id', '<', $blog_details->id)->max('id');
		// get next user id
		$next = Blog::select('*')->where('id', '>', $blog_details->id)->orderBy('id','asc')->first();
		//$next = Blog::select('*')->where('id', '>', $blog_details->id)->min('id');
	//	return View::make('users.show')->with('previous', $previous)->with('next', $next);
	//echo "<pre>";print_r($previous); print_r($next); 
	$blogs =Blog::limit(6)->get();
	
	
	
	
        return view('site.blog-details',['blog_details'=>$blog_details,'blogcategory'=>$blogcategory,'countblog'=>$countblog,'blogs'=>$blogs])->with('previous', $previous)->with('next', $next);
    } 
	 
 
 
 
 
 /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function blogCategory(Request $reques,$url)
    {	 
		//echo $url;die;
		
		$url =str_replace('-',' ',$url);
 
		$blog_category =Category::where('category',$url)->first();
 

		$bloglists = Blog::where('category', '=', $blog_category->id)->orderBy('id','desc')->get();
		
	//	echo "<pre>";print_r($bloglists);die;
	//	$previous = Blog::where('id', '<', $blog_details->id)->max('id');

		// get next user id
	//	$next = Blog::select('*')->where('id', '>', $blog_details->id)->orderBy('id','asc')->first();
		//$next = Blog::select('*')->where('id', '>', $blog_details->id)->min('id');

	//	return View::make('users.show')->with('previous', $previous)->with('next', $next);
	
	//echo "<pre>";print_r($previous); print_r($next); 
        return view('site.blog-category',['bloglists'=>$bloglists,'url'=>$url]);
    } 
	 
 
 
 /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function blogLoadData(Request $request)
    {	 
		 
     if($request->ajax())
     {
      if($request->id > 0)
      {
     
	   
	$blogs =DB::table('web_blog as blog'); 		
	$blogs  =$blogs->join('web_categories as category','blog.category','=','category.id','left');
	$blogs =$blogs->select('blog.*','category.category as categoryname','category.id as categoryid'); 
	$blogs= $blogs->where('blog.status',1)
	->where('blog.id', '<', $request->id)
	->orderby('blog.id','desc')
	->limit(4)
	->get();
	
 
      }
      else
      {
		$blogs =DB::table('web_blog as blog'); 		
		$blogs  =$blogs->join('web_categories as category','blog.category','=','category.id','left');
		$blogs =$blogs->select('blog.*','category.category as categoryname','category.id as categoryid');
		$blogs= $blogs->where('blog.status',1) 
		->orderby('blog.id','desc')
		->limit(8)
		->get();
		  
		  
		  
		  
      }
      $output = '';
      $html = '';
      $last_id = '';
      
      if(!$blogs->isEmpty())
      {
		 $html .='<div class="blog-list-details">';
		  
       foreach($blogs as $blog)
       {	
		
		$html .= '<div class="image-crs an-column-blog col-lg-3 col-md-4 col-sm-4 col-xs-6 filter">';
					
		$html .='<div class="content"><div class="an-blog-img"><a href="'.url('blog/'.$blog->slug).'" >';
			$vblogimage= unserialize($blog->blog_icons); 
			if(!empty($vblogimage)){
			$html .='<img src="'.asset('public/'.$vblogimage['blog_icons']['src']).'" alt="'.$vblogimage['blog_icons']['alt'].'">'; 
			}else{
				$html .='';				
			} 
			$html .='</a></div><div class="an-bg-co"><div class="an-blog-page-heading"><strong>'.substr($blog->title,0,25).'</strong></div><div class="an-blog-page-desc"><p>';
			if(!empty($blog->blog_description)){
			$html .=substr($blog->blog_description,0,84);
			} 			  
			$html .='<a href="'.url('blog/'.$blog->slug).'"> Read More</a> </p></div><div class="an-blog-page-footer"><div class="blog-footer-left"><div class="an-blog-author"><p>Last Updated on</p><strong>'.date('M d, Y',strtotime($blog->created_at)).'</strong></div></div><div class="an-blog-footer-right"><span><img src="'.asset('img/svg/View_Icon.svg').'" alt=""> 150</span><span><img src="'.asset('img/svg/message.svg').'" alt=""> 150</span></div></div></div></div></div>';

		
		 $last_id = $blog->id;
	   }
	 
        $html .='</div>'; 
    	$html .= '<div id="load_more" class="see-more-review"><button type="button" name="load_more_button" data-id="'.$last_id.'" id="load_more_button">More</button></div>';
	    }
      else
      {
       $html .= '
       <div id="load_more" class="see-more-review"> 
        <button type="button" name="load_more_button" >Not Found Data</button>
       </div>
       ';
      }
      echo $html;
     }
    
    } 
	
	
	
		
 /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function blogLoadCategoryData(Request $request,$url)
    {	 
		  
     if($request->ajax())
     {
      if($request->id > 0)
      {
     
	   
	/* $blogs =DB::table('web_blog as blog'); 		
	$blogs  =$blogs->join('web_category as category','blog.category','=','category.id','left');
	$blogs =$blogs->select('blog.*','category.category as categoryname','category.id as categoryid'); 
	$blogs= $blogs->where('blog.status',1);
	$blogs= $blogs->where('category.categoryname',str_replace('-',' ',$url));
	$blogs= $blogs->where('blog.id', '<', $request->id);
	$blogs= $blogs->orderby('blog.id','desc');
	$blogs= $blogs->limit(4);
	$blogs= $blogs->get();
	 */
	
		$url =str_replace('-',' ',$url); 
		$blog_category =Category::where('category',$url)->first();
 		$blogs = Blog::where('category', '=', $blog_category->id)->orderBy('id','desc');
		$blogs= $blogs->where('id', '<', $request->id);
		$blogs= $blogs->limit(4);
		$blogs= $blogs->get();
 
      }
      else
      {
		  
		  
		/* $blog_category =Category::where('category',str_replace('-',' ',$url))->first();
		  //echo str_replace('-',' ',$url);
		$blogs =DB::table('web_blog as blog'); 		
		$blogs  =$blogs->join('web_category as category','blog.category','=','category.id','left');
		$blogs =$blogs->select('blog.*','category.*','category.category as categoryname','category.id as categoryid');
		$blogs= $blogs->where('categoryname',str_replace('-',' ',$url));
		$blogs= $blogs->where('blog.status',1); 
		$blogs= $blogs->orderby('blog.id','desc');
		//$blogs= $blogs->limit(4);
		$blogs= $blogs->get(); */
		  
		$url =str_replace('-',' ',$url); 
		$blog_category =Category::where('category',$url)->first();
 		$blogs = Blog::where('category', '=', $blog_category->id)->orderBy('id','desc');
		$blogs= $blogs->limit(4);
		$blogs= $blogs->get();
		  
		  
		  //echo "<pre>";print_r($blogs);die;
		  
		  
      }
      $output = '';
      $html = '';
      $last_id = '';
      
      if(!$blogs->isEmpty())
      {
		 $html .='<div class="blog-list-category-details">';
		  
       foreach($blogs as $blog)
       {	
		
		$html .= '<div class="image-crs an-column-blog col-lg-3 col-md-4 col-sm-4 col-xs-6 filter">';
					
		$html .='<div class="content"><div class="an-blog-img"><a href="'.url('blog/'.$blog->slug).'" >';
			$vblogimage= unserialize($blog->blog_icons); 
			if(!empty($vblogimage)){
			$html .='<img src="'.asset('public/'.$vblogimage['blog_icons']['src']).'" alt="'.$vblogimage['blog_icons']['alt'].'">'; 
			}else{
				$html .='';				
			} 
			$html .='</a></div><div class="an-bg-co"><div class="an-blog-page-heading"><strong>'.substr($blog->title,0,25).'</strong></div><div class="an-blog-page-desc"><p>';
			if(!empty($blog->blog_description)){
			$html .=substr($blog->blog_description,0,84);
			} 			  
			$html .='<a href="'.url('blog/'.$blog->slug).'">  More</a> </p></div><div class="an-blog-page-footer"><div class="blog-footer-left"><div class="an-blog-author"><p>Last Updated on</p><strong>'.date('M d, Y',strtotime($blog->created_at)).'</strong></div></div><div class="an-blog-footer-right"><span><img src="'.asset('img/svg/View_Icon.svg').'" alt=""> 150</span><span><img src="'.asset('img/svg/message.svg').'" alt=""> 150</span></div></div></div></div></div>';

		
		 $last_id = $blog->id;
	   }
	 
        $html .='</div>'; 
    	$html .= '<div id="load_more" class="see-more-review"><button type="button" name="load_more_button" data-id="'.$last_id.'" id="load_more_button">More</button></div>';
	    }
      else
      {
       $html .= '
       <div id="load_more" class="see-more-review"> 
        <button type="button" name="load_more_button" >Not Found Data</button>
       </div>
       ';
      }
      echo $html;
     }
    
    } 
	
	
 
 
}
