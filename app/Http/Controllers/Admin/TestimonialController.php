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
use App\Testimonial;
use App\Models\Courses;
use App\Helpers;
class TestimonialController extends Controller
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
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {	  
        return view('admin.testimonial.index');
    } 
	
 
   /**
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		
		$course_list= Course::select('id','title','course_name')->get();	
        return view('admin.testimonial.add_testimonial',['course_list'=>$course_list]);
    } 
	 /**
	 add save Testimonial Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveTestimonial(Request $request)
    {	  
	  
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[	
			 
				'name' => 'required',				
				'course' => 'required',				
				'rating' => 'required',				
				'total_rating' => 'required',					 			
				'comment' => 'required',				
				'company_name' => 'required',				
				'designation' => 'required',			 	
				'related_courses' => 'required',				
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
			
					
				 

			if ($request->hasFile('testimonial_image')) {
				$alt= $request->input('alt');
				$image = [];
				$filePath = getTestimonialFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('testimonial_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['testimonial_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				$image=serialize($image);
				
				}else{
					$image="";
				} 
				if($request->input('related_courses')){
					$related_courses=serialize($request->input('related_courses'));
					
				}else{
					$related_courses="";
				}
				$testimonial = New Testimonial;
				$testimonial->name = ucwords(trim($request->input('name')));		
				$testimonial->email = $request->input('email');					 					
				$testimonial->course =$request->input('course');					 
				$testimonial->linkedin_url =$request->input('linkedin_url');					 
				$testimonial->facebook_url =$request->input('facebook_url');					 
				$testimonial->rating = trim($request->input('rating'));					 
				$testimonial->total_rating = trim($request->input('total_rating'));					 
				$testimonial->comment = $request->input('comment');					 
				$testimonial->company_name = $request->input('company_name');					 
				$testimonial->designation = $request->input('designation');	
				$testimonial->related_courses = $related_courses;									
				$testimonial->testimonial_image = $image;									
				$testimonial->created_by = '1';				 
				$testimonial->status = '1';				 
				 	
			if($testimonial->save()){
				$status=1;							 
				$msg="Testimonial submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Testimonial could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

  
	
	 
   /**
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {	  
		$edit_data= Testimonial::findOrFail(base64_decode($id)); 
		$course_list= Course::select('id','title','course_name')->get();
        return view('admin.testimonial.edit_testimonial',['edit_data'=>$edit_data,'course_list'=>$course_list]);
    } 
	
 /**
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveTestimonial(Request $request,$id)
    {	  
	   
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[				 
				'name' => 'required',				
				'course' => 'required',				
				'rating' => 'required',				
				'total_rating' => 'required',				 		
				'comment' => 'required',				
				'company_name' => 'required',				
				'designation' => 'required',					 			
				'related_courses' => 'required',				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				
				$testimonial = Testimonial::findOrFail($id);				 
				$testimonial->name = ucwords(trim($request->input('name')));		
				$testimonial->email = $request->input('email');	
				$testimonial->linkedin_url =$request->input('linkedin_url');					 
				$testimonial->facebook_url =$request->input('facebook_url');				
				$testimonial->course =$request->input('course');					 
				$testimonial->rating = trim($request->input('rating'));					 
				$testimonial->total_rating = trim($request->input('total_rating'));					 
				$testimonial->comment = $request->input('comment');					 
				$testimonial->company_name = $request->input('company_name');					 
				$testimonial->designation = $request->input('designation');	
				$testimonial->related_courses = serialize($request->input('related_courses'));				 			 
			 
				
				if ($request->hasFile('testimonial_image')) {
					$alt= $request->input('alt');	
				$image = [];
				$filePath = getTestimonialFolderStructure();
				 
				$file =  $request->file('testimonial_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['testimonial_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				$testimonial->testimonial_image = serialize($image);		
				}else{
				$testimonial->testimonial_image = $testimonial->testimonial_image;	
				}				
			 	$testimonial->updated_by = '1';			
			if($testimonial->save()){
				$status=1;							 
				$msg="Testimonial updated successfully!";		
				
			}else{
				$status=0;							 
				$msg="Testimonial could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getTestimonialPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$testimonials = Testimonial::orderBy('id','desc');		 
		if($request->input('search.value')!==''){
				$testimonials = $testimonials->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('company_name','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$testimonials = $testimonials->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $testimonials->total();
			$returnLeads['recordsFiltered'] = $testimonials->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($testimonials as $testimonial){				 
				$action="";
				$seperate="";				 					 
				$action .='<a href="/admin/testimonial/edit/'.base64_encode($testimonial->id).'" title="Edit testimonial" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_testimonial') ){
				$action .='<a href="javascript:testimonialController.delete('.$testimonial->id.')" title="Delete testimonial" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
				if(!empty($testimonial->testimonial_image)){
				 $vimage= json_decode($testimonial->testimonial_image); 
					$image='<img src="'.asset($vimage['testimonial_image']['src']).'" type="'.$vimage['testimonial_image']['alt'].'" width="100">'; 	
				}else{
					$image="";
				}
				
				$coursename = Course::select('id','course_name')->where('id',$testimonial->course)->first();
				if(!empty($coursename)){
					$coursen = $coursename->course_name;
				}else{
					$coursen="";
				}
				
				$status="";
				if($testimonial->status=='1'){
				$status .='<a href="javascript:testimonialController.status('.$testimonial->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:testimonialController.status('.$testimonial->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
				}
					$data[] = [		 		 		 
						$testimonial->name,					 			
						$coursen,					 			
						$testimonial->company_name,					 			
						$testimonial->designation,					 			
						$image,	 				 			
						$status,	 				 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $testimonial->id;				 
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
		 
		$testimonial = testimonial::findOrFail($id);			 
		if($testimonial->testimonial_image!='')
		{
			$image = json_decode($testimonial->testimonial_image);
			$large = $image['testimonial_image']['src'];
			if(!empty($image['testimonial_image']['src'])){
			$thumbnail = $image['testimonial_image']['src'];
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
	
		if($testimonial->delete()){
		$status=1;							 
		$msg="Testimonial delete successfully !";	
		}else{
		$status=0;							 
		$msg="Testimonial could not be deleted!";	
		}
		return response()->json(['status'=>$status,'msg'=>$msg],200); 
    }
  
 
	 /**
     * Remove the specified resource from storage del_icon.
     * Author: Brijesh Chauhan.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_icon($id)
    {
       	 
		$delet_data = Testimonial::findOrFail($id);	
 	
		if($delet_data->testimonial_image!='')
		{		
			 
			$image = json_decode($delet_data->review_image);
			
			$large = $image['testimonial_image']['src'];
			if(!empty($image['testimonial_image']['src'])){
			$thumbnail = $image['testimonial_image']['src'];
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
 
		$edit_data = array('testimonial_image' =>"",);	 
		$del = Testimonial::where('id',$id)->update($edit_data);			 		
		return redirect('admin/testimonial/edit/'.base64_encode($id))->with("success","Image deleted successfully.");
			
    }
 
 
	  
	 /**
     * Remove the specified resource from storage status.
     * Author: Brijesh Chauhan.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(request $request, $id,$val)
    {
       	 if($request->ajax()){	
		 
		$testimonial = Testimonial::findOrFail($id);	 
		$testimonial->status=$val;
	
		if($testimonial->save()){
			$status=1;							 
			$msg="Testimonial status updated successfully !";					
			}else{
			$status=0;							 
			$msg="Testimonial status could not be updated!";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
 
 
 
 
}
