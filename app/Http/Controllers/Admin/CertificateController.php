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
use App\Models\Courses;
use App\CourseCity;
use App\Models\Category;
use App\Certificate;
use App\Helpers;
class CertificateController extends Controller
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
	
        return view('admin.certificate.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {	  
		$course_list= Course::select('id','title')->get();
		$cetegories= Category::select('id','category')->get();
		$citys= CourseCity::orderBy('city','asc')->get();	 
        return view('admin.certificate.add_certificate',['course_list'=>$course_list,'citys'=>$citys,'cetegories'=>$cetegories]);
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCertificateTitle(Request $request)
    {	  
	
        if($request->ajax()){ 
	//	echo "<pre>";print_r($_POST);print_r($_FILES);die;
			
  
		  $validator = Validator::make($request->all(),[				 
				'title'=>'required',
				'sub_title'=>'required',
				//'slug'=>'required',
				'course_name'=>'required',
				'course_overview'=>'required',
				'curriculum_text'=>'required',
				'course_content'=>'required',
				'meta_description'=>'required',
				'category'=>'required',
				'subcategory'=>'required',
				'rating'=>'required',
				'total_rating'=>'required',
				'course_image'=>'required',	
				'alt'=>'required',	
				'meta_keyword'=>'required',	
				'why_learn'=>'required',	
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
		$alt = $request->input('alt');	
		$citycourse = $request->input('citycourse');	
		if(!empty($citycourse)){
			//echo count($citycourse);die;
				if ($request->hasFile('course_image')) {
				$image = [];
				$filePath = getCertificateFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('course_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['course_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				} 
				$related_courses= $request->input('related_courses');
				if(!empty($related_courses)){
					$related_courses= serialize($related_courses);
				
				}else{
					$related_courses="";
				}				
				$why_learn= $request->input('why_learn');
				if(!empty($why_learn)){
					$why_learn= serialize($why_learn);				
				}else{
					$why_learn="";
				}
				
				
				
				
				
				
				
				
				
				
			for($i=0; $i<count($citycourse); $i++){
		
		


			// GENERATING SLUG
			// ***************
			$business_slug = NULL;
			$business_slug = generate_slug($request->input('title').' in '.$citycourse[$i]);
			if(is_null($business_slug)){
			return redirect("/admin/certificate/add");

			}
			$slugExists = DB::table('webcertificate')
			->select(DB::raw('slug'))
			->where('slug', 'like', '%'.$business_slug.'%')
			->orderBy('id','desc')
			->get();
			if(count($slugExists)>0){
			$business_slug = $slugExists[0]->slug;
			$business_slug = explode("-",$business_slug);
			$end = end($business_slug);
			reset($business_slug);
			if(!is_numeric($end)){
			$business_slug[] = 1;
			}else{
			++$end;
			$business_slug[count($business_slug)-1] = $end;
			}
			$business_slug = implode("-",$business_slug);
			}


		
		
		
		
				
				$courses = New Certificate;
				$courses->title = $request->input('title');	
				$courses->sub_title = $request->input('sub_title');	
				$courses->slug  =$business_slug;				
				$courses->course_name = ucfirst($request->input('course_name'));
				$courses->category = trim($request->input('category'));
				$courses->subcategory = trim($request->input('subcategory'));
				$courses->rating = $request->input('rating');
				$courses->total_rating = $request->input('total_rating');	
				$courses->meta_keyword = $request->input('meta_keyword');	
				$courses->meta_description = $request->input('meta_description');	
				$courses->course_overview = $request->input('course_overview');	
				$courses->curriculum_text = $request->input('curriculum_text');	
				$courses->course_content = $request->input('course_content');	
				$courses->related_courses = $related_courses;	
				$courses->course_image = serialize($image);					
				$courses->why_learn = $why_learn;					
				$courses->status = '1';				 
				$courses->created_by =1;	
				$courses->save();				
				$add= 1;
			}
 		}else{
			if ($request->hasFile('course_image')) {
				$image = [];
				$filePath = getCertificateFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('course_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['course_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				} 
				
				

			// GENERATING SLUG
			// ***************
			$business_slug = NULL;
			$business_slug = generate_slug($request->input('title'));
			if(is_null($business_slug)){
			return redirect("/admin/certificate/add");

			}
			$slugExists = DB::table('webcertificate')
			->select(DB::raw('slug'))
			->where('slug', 'like', '%'.$business_slug.'%')
			->orderBy('id','desc')
			->get();
			if(count($slugExists)>0){
			$business_slug = $slugExists[0]->slug;
			$business_slug = explode("-",$business_slug);
			$end = end($business_slug);
			reset($business_slug);
			if(!is_numeric($end)){
			$business_slug[] = 1;
			}else{
			++$end;
			$business_slug[count($business_slug)-1] = $end;
			}
			$business_slug = implode("-",$business_slug);
			}



				
				$related_courses= $request->input('related_courses');
				if(!empty($related_courses)){
					$related_courses= serialize($related_courses);
				
				}else{
					$related_courses="";
				}				
				$why_learn= $request->input('why_learn');
				if(!empty($why_learn)){
					$why_learn= serialize($why_learn);				
				}else{
					$why_learn="";
				}
				
				$courses = New Course;
				$courses->title = $request->input('title');	
				$courses->sub_title = $request->input('sub_title');	
				$courses->slug  = $business_slug;				
				$courses->course_name = ucfirst($request->input('course_name'));
				$courses->category = trim($request->input('category'));
				$courses->subcategory = trim($request->input('subcategory'));
				$courses->rating = $request->input('rating');
				$courses->total_rating = $request->input('total_rating');	
				$courses->meta_keyword = $request->input('meta_keyword');	
				$courses->meta_description = $request->input('meta_description');	
				$courses->course_overview = $request->input('course_overview');	
				$courses->curriculum_text = $request->input('curriculum_text');	
				$courses->course_content = $request->input('course_content');	
				$courses->related_courses = $related_courses;	
				$courses->course_image = serialize($image);					
				$courses->why_learn = $why_learn;					
				$courses->status = '1';				 
				$courses->created_by =1;	
				$courses->save();
				
				$add= 1;
			
			
		}
			if(!empty($add)){
				$status=1;							 
				$msg="Certificate Successfully !";	
				
			}else{
				$status=0;							 
				$msg="Not Certificate Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 


	/**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCertificateTitle(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		//echo "<pre>";print_r($_POST);print_r($_FILES);die;
			
  
		  $validator = Validator::make($request->all(),[				 
				'title'=>'required',
				'sub_title'=>'required',
				'course_name'=>'required',
				'rating'=>'required',
				'total_rating'=>'required',
				'course_image'=>'required',	
				'category'=>'required',	
				'subcategory'=>'required',	
				'alt'=>'required',	
				'meta_keyword'=>'required',	
				'meta_description'=>'required',	
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				$alt= $request->input('alt');
			
				
				$courses = Certificate::findOrFail($id);
				$courses->title = $request->input('title');	
				$courses->sub_title = ucwords($request->input('sub_title'));	
				$courses->slug  = $request->input('slug');				
				$courses->course_name = ucwords($request->input('course_name'));
				$courses->rating = $request->input('rating');
				$courses->category = $request->input('category');
				$courses->subcategory = $request->input('subcategory');
				$courses->total_rating = $request->input('total_rating');	
				$courses->meta_keyword = $request->input('meta_keyword');	
				$courses->meta_description = $request->input('meta_description');	
				
				if ($request->hasFile('course_image')) {
				$image = [];
				$filePath = getCertificateFolderStructure();
				//	$file = Input::file('course_image');
				$file =  $request->file('course_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['course_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				$courses->course_image = serialize($image);		
				}else{
				$courses->course_image = $courses->course_image;			  

				} 
			 			 
				$courses->updated_by =1;		
 		
			if($courses->save()){
				$status=1;							 
				$msg="Certificate Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Certificate Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	

	/**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCertificateOverview(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		//echo "<pre>";print_r($_POST);die;
			
  
		  $validator = Validator::make($request->all(),[				 
				'course_overview'=>'required',
				 
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				 
				
				$courses = Certificate::findOrFail($id);
				$courses->course_overview = $request->input('course_overview');					 			 			 
				$courses->updated_by =1;		
 		
			if($courses->save()){
				$status=1;							 
				$msg="Certificate Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Certificate Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	

	/**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCertificateCurriculum(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		//echo "<pre>";print_r($_POST);die;
			
  
		  $validator = Validator::make($request->all(),[				 
				'course_curriculum'=>'required',
				
				 
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				 
				
				$courses = Certificate::findOrFail($id);
				$courses->course_curriculum = $request->input('course_curriculum');					 			 			 
				$courses->updated_by =1;		
 		
			if($courses->save()){
				$status=1;							 
				$msg="Certificate Curriculum Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Certificate Curriculum Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
 
	/**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCertificateRelated(Request $request,$id)
    {	  
	
        if($request->ajax()){ 	
		  $validator = Validator::make($request->all(),[				 
				'related_courses_side'=>'required',
				'related_certifications'=>'required',
				'show_certification_tab'=>'required',
				'show_front_page'=>'required',				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				 if(!empty($request->input('related_courses_side'))){
					 $related_courses_side = serialize($request->input('related_courses_side'));					 
				 }else{
					 $related_courses_side="";					 
				 } 
				 
				 if(!empty($request->input('related_certifications'))){
					 $related_certifications = serialize($request->input('related_certifications'));					 
				 }else{
					 $related_certifications="";					 
				 }
				 if(!empty($request->input('related_courses'))){
					 $related_courses = serialize($request->input('related_courses'));					 
				 }else{
					 $related_courses="";					 
				 }				
			$courses = Certificate::findOrFail($id);
			$courses->related_courses_side = $related_courses_side;					 			 			 
			$courses->related_certifications = $related_certifications;
			$courses->related_courses = $related_courses;				
			$courses->show_certification_tab = $request->input('show_certification_tab');				 			 			 
			$courses->show_front_page = $request->input('show_front_page');					 			 
					 			 			 
				$courses->updated_by =1;		
 		
			if($courses->save()){
				$status=1;							 
				$msg="Certificate Related Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Certificate Related Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
	/**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveFAQ(Request $request,$id)
    {	  
	//echo "<pre>";print_r($_POST);die;
        if($request->ajax()){  
		  $validator = Validator::make($request->all(),[				 
				'faqq'=>'required',
				'faqa'=>'required',			 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}				
			$courses = Certificate::findOrFail($id);
			if(!empty($request->input('faqq'))){
				$faqq= serialize($request->input('faqq'));
			}else{
				$faqq="";
			}			
			if(!empty($request->input('faqa'))){
				$faqa= serialize($request->input('faqa'));
			}else{
				$faqa="";
			}
			$FAQs= array(
			'faqq'=>$faqq,
			'faqa'=>$faqa
			);
			$courses->FAQs = $FAQs;	  
			$courses->updated_by =1;  
			if($courses->save()){
				$status=1;							 
				$msg="Certificate FAQs Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Certificate FAQs Successfully !";	
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
		$edit_data= Certificate::findOrFail(base64_decode($id));
		$course_list= Course::select('id','title')->get();
		$cetegories= Category::select('id','category')->get();
//echo "<pre>";print_r($course_list);die;
        return view('admin.certificate.edit_certificate',['edit_data'=>$edit_data,'course_list'=>$course_list,'cetegories'=>$cetegories]);
    } 
	
 
	// GET  Course pagination
	public function getCertificatePagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$courses= 	Certificate::orderBy('id','desc');		 
		if($request->input('search.value')!==''){
				$courses = $courses->where(function($query) use($request){
					$query->orWhere('course_name','LIKE','%'.$request->input('search.value').'%')
					      ->orWhere('title','LIKE','%'.$request->input('search.value').'%')						   
						  ->orWhere('slug','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$courses = $courses->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $courses->total();
			$returnLeads['recordsFiltered'] = $courses->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($courses as $course){				 
				$action="";
				$seperate="";
				 
				$action .='<a href="admin/certificate/course-view/'.base64_encode($course->id).'" title="View certificate Content" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>';					 
				$action .='<a href="/admin/certificate/edit/'.base64_encode($course->id).'" title="Edit certificate Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				$action .='<a href="javascript:certificateController.delete('.$course->id.')" title="Delete certificate Content" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>  ';	
				$vimage= json_decode($course->course_image); 
				$image='<img src="'.asset($vimage['course_image']['src']).'" type="'.$vimage['course_image']['alt'].'" width="100">'; 				 
					$data[] = [		 		 		 
						$course->course_name,					 	
						$course->title,						
						$course->slug,						
						$course->rating,
						$image,						
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $course->id;				 
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
    public function del_icon($id)
    {
       	 
		$delet_data = Certificate::findOrFail($id);	 
		if($delet_data->course_image!='')
		{		
			 
			$image = json_decode($delet_data->course_image);
			
			$large = $image['course_image']['src'];
			if(!empty($image['course_image']['src'])){
			$thumbnail = $image['course_image']['src'];
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
 
		$edit_data = array('course_image'  =>"",);	 
		$del = Certificate::where('id',$id)->update($edit_data);			 		
		return redirect('admin/certificate/edit/'.base64_encode($id))->with("success","image deleted successfully.");
			
    }
  
 
 
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
		public function delete($id)
		{
 
			$courses = Certificate::findOrFail($id);	
			if($courses->course_image!='')
			{		

			$image = json_decode($courses->course_image);

			$large = $image['course_image']['src'];
			if(!empty($image['course_image']['src'])){
			$thumbnail = $image['course_image']['src'];
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
			if($courses->delete()){
			$status=1;							 
			$msg="Certificate Delete Successfully !";		

			}else{
			$status=0;							 
			$msg="Not Certificate Delete Successfully !";	
			}

			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		}
  
 
 
 
 
}
