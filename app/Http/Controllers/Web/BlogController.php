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
use DateTime;
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
		$blogs = DB::table('web_blog as blog')
		->leftJoin('web_categories as category', 'blog.category', '=', 'category.id')
		->select(
			'blog.*',
			'category.category as categoryname',
			'category.id as categoryid'
		)
		->where('blog.status', 1)
		->orderBy('blog.id', 'desc')
		->get();



		 // Cache for 1 hour (matches Next.js revalidate: 3600)       
       

		$blogdetails = Blog::where('status', '1')
			->orderBy('id', 'DESC')
			->paginate(100);

		foreach ($blogdetails as $key => $blog) {
			$image = "";
			$alt = "";

			if (!empty($blog->image)) {
				$imgData = unserialize($blog->image);
				if (!empty($imgData['large']['src'])) {
					$image = config('app.website') . $imgData['large']['src'];
					$alt = $blog->name;
				}
			}

			$blogPageList[$key] = [
				'id' => $blog->id,
				'name' => $blog->name,
				'url' => $blog->slug,
				'img' => $image,
				'alt' => $alt,
				'title' => $blog->title,
				'ratingcount' => $blog->ratingcount,
				'ratingvalue' => $blog->ratingvalue,
				'created_at' => date('d, M Y',strtotime($blog->created_at)),
				'updated_at' => $this->get_time(strtotime($blog->created_at)),
				'description' => ucfirst(substr(strip_tags($blog->description), 0, 220)) . '...',

			];
		}


        $featuredArticle     = $blogPageList ?? [];      
    
        $popularArticles = array_slice($featuredArticle, 1, 3);
        $tickerArticles  = array_slice($featuredArticle, 4, 10);
        $listArticles    = array_slice($featuredArticle, 1);   
        $firstBlog    = $featuredArticle['0'];   
        $categories = Blog::select('category_name as name', DB::raw('COUNT(*) as count'))
        ->whereNotNull('category_name')
        ->where('category_name', '!=', '')
        ->groupBy('category_name')
        ->orderBy('count', 'DESC')
        ->get();
 
   
        $tags ="";

        $city = "delhi";
        $metaTitle = "QuickDials Blog | Local Business Tips, Guides & Updates";
        $metaDescription = "Read QuickDials blogs for local business tips, service guides, market updates, and helpful information to find trusted businesses and services near you.";
        $keyword = "Blog";
        return view('pages.blog', compact(
            'featuredArticle',
            'firstBlog',
            'popularArticles',
            'tickerArticles',
            'listArticles',
            'categories',
            'tags','city','metaTitle','metaDescription','keyword'
        ));
        
    } 
	

	
function get_time($time)
{

	$start_date = date('Y-m-d H:i:s');

	$diff = abs(strtotime($start_date) - $time);

	$totalyear = floor($diff / (365 * 60 * 60 * 24));
	$totalmonths = floor(($diff - $totalyear * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
	$days = floor(($diff - $totalyear * 365 * 60 * 60 * 24 - $totalmonths * 30 * 60 * 60 * 24) / (60 * 60 * 24));



	$create_time = $time;
	$current_time = time();
	$dtCurrent = DateTime::createFromFormat('U', $current_time);
	$dtCreate = DateTime::createFromFormat('U', $create_time);
	$diff = $dtCurrent->diff($dtCreate);

	if ($days < 1 && $totalmonths == 0) {
		$interval = $diff->format("%h hrs %i minutes");
		$interval = preg_replace('/(^0| 0) (hrs|minutes)/', '', $interval);

	} else if ($days > 0 && $totalmonths == 0) {
		$interval = $diff->format("%d days %h hrs");
		$interval = preg_replace('/(^0| 0) (days|hrs)/', '', $interval);
	} else if ($totalmonths > 0 && $days > 1 && $totalyear == '0') {

		$interval = $diff->format("%m months %d days");
		$interval = preg_replace('/(^0| 0) (months|days)/', '', $interval);

	} else if ($totalmonths >= 12 && $totalyear > 0) {
		$interval = $diff->format("%y years %m months");
		$interval = preg_replace('/(^0| 0) (years|months)/', '', $interval);
	} else {

		$interval = $diff->format("%h hours %i minutes");
		$interval = preg_replace('/(^0| 0) (hours|minutes)/', '', $interval);
	}

	return $interval;



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
