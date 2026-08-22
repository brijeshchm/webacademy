<?php

namespace App\Http\Controllers\admin;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  
use Auth;
use Hash;
use Validator;
use DB;
use Session;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Input;
use Image; 
use App\Models\City;
use App\Models\FAQs;
use App\Models\Blog;
use App\Reviews;
use App\Models\Courses;
use App\Helpers;
class ReviewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        
	    //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {	  
        return view('admin.reviews.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		
		$course_list= Course::select('id','title','course_name')->groupby('course_name')->get();	
        return view('admin.reviews.add_reviews',['course_list'=>$course_list]);
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveReviews(Request $request)
    {	  
	 // echo "<pre>";print_r($_POST);die;
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[	
			 
				'name' => 'required',				
				'course' => 'required',				
				'rating' => 'required',				
				'gender' => 'required',		
				'alt' => 'required',				
				'comment' => 'required',				
				//'company_name' => 'required',				
				//'designation' => 'required',				
				'review_image' => 'required',				
			//	'related_courses' => 'required',				
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
			$alt= $request->input('alt');		
				 

			if ($request->hasFile('review_image')) {
				$image = [];
				$filePath = getReviewsFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('review_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['review_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				} 
				
				$reviews = New Reviews;
				$reviews->name = ucwords(trim($request->input('name')));		
				$reviews->email = $request->input('email');	
				$reviews->gender = $request->input('gender');	
				$coursename= Course::where('id',$request->input('course'))->first()->course_name;	 
				$reviews->course =$request->input('course');					 
				$reviews->coursename =$coursename;					 
				$reviews->rating = trim($request->input('rating'));		 
					 
				$reviews->comment = $request->input('comment');					 
				$reviews->company_name = $request->input('company_name');					 
				$reviews->designation = $request->input('designation');	
				$reviews->related_courses = serialize($request->input('related_courses'));									
				$reviews->review_image = serialize($image);									
				$reviews->created_by = '1';				 
				$reviews->status = '1';		
				
				$course= Course::findOrFail($request->input('course'));
				$course->total_rating = $course->total_rating+1;
				$course->save();	
				$reviews->total_rating = $course->total_rating;	
				 	
			if($reviews->save()){
				$status=1;							 
				$msg="Reviews Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Reviews Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

  
	
	 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {	  
		$edit_data= Reviews::findOrFail(base64_decode($id)); 
		$course_list= Course::select('id','title','course_name')->groupby('course_name')->get();
        return view('admin.reviews.edit_reviews',['edit_data'=>$edit_data,'course_list'=>$course_list]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveReviews(Request $request,$id)
    {	  
	// echo "<pre>";print_r($_POST);die;  
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[				 
				'name' => 'required',				
				'course' => 'required',				
				'rating' => 'required',				
				'gender' => 'required',	
				'alt' => 'required',				
				'comment' => 'required',				
			//	'company_name' => 'required',				
			//	'designation' => 'required',				
				'review_image' => 'required',				
			//	'related_courses' => 'required',				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				$alt= $request->input('alt');	
				$reviews = Reviews::findOrFail($id);				 
				$reviews->name = ucwords(trim($request->input('name')));		
				$reviews->email = $request->input('email');		
				$reviews->gender = $request->input('gender');		
				$coursename= Course::where('id',$request->input('course'))->first()->course_name;	
				$reviews->coursename =$coursename;					
				$reviews->course =$request->input('course');					 
				$reviews->rating = trim($request->input('rating'));	
				$reviews->comment = $request->input('comment');					 
				$reviews->company_name = $request->input('company_name');					 
				$reviews->designation = $request->input('designation');	
				$reviews->related_courses = serialize($request->input('related_courses'));				 			 
			 
				
				if ($request->hasFile('review_image')) {
				$image = [];
				$filePath = getReviewsFolderStructure();
				//	$file = Input::file('course_image');
				$file =  $request->file('review_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['review_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				$reviews->review_image = serialize($image);		
				}else{
				$reviews->review_image = $reviews->review_image;	
				}				
			 	$reviews->updated_by = '1';			
			if($reviews->save()){
				$status=1;							 
				$msg="Reviews Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Reviews Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getReviewsPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$reviews = 	Reviews::orderBy('id','desc');		 
		if($request->input('search.value')!==''){
				$reviews = $reviews->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('company_name','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$reviews = $reviews->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $reviews->total();
			$returnLeads['recordsFiltered'] = $reviews->total();
			$returnLeads['recordCollection'] = [];
// echo "<pre>";print_r($reviews);die;
			foreach($reviews as $review){				 
				$action="";
				$seperate="";				 					 
				$status="";				 					 
				$image="";				 					 
				$action .='<a href="/admin/reviews/edit/'.base64_encode($review->id).'" title="Edit Blog" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_reviews') ){
				$action .='<a href="javascript:reviewsController.delete('.$review->id.')" title="Delete Reviews" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				}				
				if(!empty($review->review_image)){
				 $vimage= json_decode($review->review_image); 
				 if(!empty($vimage)){
					$image ='<img src="'.asset($vimage['review_image']['src']).'" type="'.$vimage['review_image']['alt'].'" width="100">'; 
				 }					
				}else{
					$image="";
				}
				if($review->status=='1'){
				$status .='<a href="javascript:reviewsController.status('.$review->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:reviewsController.status('.$review->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
				}
				$coursename = Course::select('id','course_name')->where('id',$review->course)->first();
				if(!empty($coursename)){
					$coursen = $coursename->course_name;
				}else{
					$coursen="";
				}
					$data[] = [		 		 		 
						$review->name,					 			 			
						$coursen,					 			
						$review->company_name,					 			
						$review->designation,					 			
						$image,	 				 			
						$status,	 				 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $review->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
		}  
		
	}
	
  
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
		 
		$reviews = Reviews::findOrFail($id);			 
		if($reviews->review_image!='')
		{
			$image = json_decode($reviews->review_image);
			$large = $image['review_image']['src'];
			if(!empty($image['review_image']['src'])){
			$thumbnail = $image['review_image']['src'];
			if (file_exists($thumbnail))
			{
				unlink($thumbnail);
			}  
			}
			if (file_exists($large))
			{
				unlink($large);
			} 
		}
	
		if($reviews->delete()){
		$status=1;							 
		$msg="Reviews Delete Successfully !";	
		}else{
		$status=0;							 
		$msg="Not Reviews Delete Successfully !";	
		}
		return response()->json(['status'=>$status,'msg'=>$msg],200); 
    }
  
 
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_icon($id)
    {
       	 
		$delet_data = Reviews::findOrFail($id);	
 	
		if($delet_data->review_image!='')
		{		
			 
			$image = json_decode($delet_data->review_image);
			
			$large = $image['review_image']['src'];
			if(!empty($image['review_image']['src'])){
			$thumbnail = $image['review_image']['src'];
			if (file_exists($thumbnail))
			{
			unlink($thumbnail);
			}  
			}
			if (file_exists($large))
			{
			unlink($large);
			} 
		 
		 
		}
 
		$edit_data = array('review_image' =>"",);	 
		$del = Reviews::where('id',$id)->update($edit_data);			 		
		return redirect('admin/reviews/edit/'.base64_encode($id))->with("success","image deleted successfully.");
			
    }
 /**
     * Remove the specified resource from storage status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(request $request, $id,$val)
    {
       	 if($request->ajax()){	
		 
		$reviews = Reviews::findOrFail($id);	 
		$reviews->status=$val;
		//echo "<pre>";print_r($category);die;
		if($reviews->save()){
			$status=1;							 
			$msg="Reviews Status Successfully !";					
			}else{
			$status=0;							 
			$msg="Not Reviews Status Successfully !";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
 
 
 
 
}
