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
use App\Models\Course;
use App\Models\CourseCity;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Speciality;
use App\Models\ToolsCovered;
use App\Models\CourseAboutExcel;
use App\Models\CourseAbout;
use App\Models\CourseCurriculumExcel;

use App\Models\CoursesPdf;
use App\Helpers;
use App\Exports\excelFormateExport;
use Maatwebsite\Excel\Facades\Excel;
class SeoPageController extends Controller
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
		$categorylist =Category::get();	
		$search = [];
		if($request->has('search')){
		$search = $request->input('search');
		}
        return view('admin.seopage.index',['search'=>$search,'categorylist'=>$categorylist]);
    } 
	
 
   /**
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {	  
	 
		$course_list= Course::select('id','title')->where('course_type','<>','3')->where('status',1)->get();

		$cetegories = Category::get();	
		$citys= CourseCity::orderBy('city','asc')->where('status',1)->get();
		 
        return view('admin.seopage.add_seocourse',['course_list'=>$course_list,'citys'=>$citys,'cetegories'=>$cetegories]);
    } 
	 /**
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCourseTitle_old(Request $request)
    {	  

        if($request->ajax()){   
		
	// echo "<pre>";print_r($_POST);die;
			$course=explode(',',$request->input('course'));
			$courseslist = Course::findOrFail($course[0]);	 
			$category=explode(',',$request->input('category'));
		
			$city_territory= $request->input('city_territory');
			$city = $request->input('city-'.$city_territory);	
			$checkdata = Course::where('category',$category[0])->where('course_type',$category[1])->where('title',$courseslist->title.' in '.$city)->get();

			$checkdataslug = Course::where('category',$category[0])->where('course_type',$category[1])->where('slug',$this->generate_slug($courseslist->slug.'-in-'.$city))->get();
			
			//echo generate_slug($courseslist->slug.'-in-'.$request->input('city'));die;
			 //echo "<pre>";print_r($checkdata);die;
			if((!empty($checkdata) && count($checkdata) >0) || (!empty($checkdataslug) && count($checkdataslug)>0)){			 
			$validator = Validator::make($request->all(),[
				'category'=>'required',			
				'course'=>'required',	
				'city-'.$city_territory=>'required|unique:web_courses,city',				 
			]);
			}else{				
				$validator = Validator::make($request->all(),[
				'category'=>'required',				
				'course'=>'required',				 
				'city-'.$city_territory=>'required',					 
				]);
				
			}
		
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
	
	 
		 
		if(!empty($city)){
				$courseslist = Course::findOrFail($course[0]);
				
				if(!empty($courseslist)){
				$courses = New Course;
				$courses->title = $courseslist->title.' in '.$city;	
				$courses->description = $courseslist->description;	
		    	$courses->slug = $this->generate_slug($courseslist->slug.'-in-'.$city);		
				$courses->course_name = $courseslist->course_name;
				$courses->course_clone_id = $courseslist->id;
				//if($request->input('course_type')=='1'){
				if($request->input('course_type')=='1'){
				$courses->course_curriculum = $courseslist->id;
				}
                if($request->input('course_type')=='2'){
                $courses->courses_module = $courseslist->courses_module;
                }
				
				$courses->seo_type = $category[1];
	
				$courses->city = $city;
				$courses->video_link = $courseslist->video_link;
				$courses->course_defination = $courseslist->course_defination;
				$courses->course_duration = $courseslist->course_duration;
				$courses->course_week_days = $courseslist->course_week_days;
				$courses->course_weekend = $courseslist->course_weekend;
				$courses->course_fasttrack = $courseslist->course_fasttrack;
				$courses->live_project = $courseslist->live_project;
				$courses->professional_trained = $courseslist->professional_trained;
				$courses->batches_every_month = $courseslist->batches_every_month;
				$courses->exam_title = $courseslist->exam_title;
				$courses->exam_text = $courseslist->exam_text;
				$courses->format = $courseslist->format;
				$courses->certification_type = $courseslist->certification_type;
				$courses->delivery_method = $courseslist->delivery_method;
				$courses->certification_time = $courseslist->certification_time;
				$courses->certification_cost = $courseslist->certification_cost;
				$courses->language = $courseslist->language;
				$courses->certification_visibility = $courseslist->certification_visibility;
				$courses->category = $category[0];				
				$courses->rating = $courseslist->rating;
				$courses->total_rating = $courseslist->total_rating;				
				$courses->meta_description = $courseslist->meta_description;		 		 					
				$courses->course_type = '3';				 
				$courses->status = '0';				 
				$courses->created_by =1;	

				//dd($courses);
				$courses->save();				
				$add= 1;
				}
				
				
 		} 
			if(!empty($add)){
				$status=1;							 
				$msg="Course submitted successfully!";	
				
			}else{
				$status=0;							 
				$msg="Course could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 


/**
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseAboutExtra(Request $request,$id)
    {	  
	// echo "<pre>";print_r($_POST);die;
        if($request->ajax()){ 	  
		  $validator = Validator::make($request->all(),[					
				'course_image_name' => 'required',					 
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	
			    
		 
			 
			$updatetitle =array(
			'course_image_name'=>ucfirst($request->input('course_image_name')),				 				 	
			);
		 
			$checkupdate  =DB::table('web_courses')->where('id',$id)->update($updatetitle);	
			if($checkupdate){
				$status=1;							 
				$msg="Course image name updated successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course image name could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
	public function editSaveCourseSeoTopic(Request $request, $id)
	{
		 
		if (!$request->ajax()) {
			return response()->json(['status' => 0, 'msg' => 'Invalid request'], 400);
		}

		$course = Course::find($id);
		if (!$course) {
			return response()->json(['status' => 0, 'msg' => 'Course not found'], 404);
		}

		$validator = Validator::make($request->all(), [
			'enrolled'              => 'nullable|numeric',
			'price'                 => 'nullable|numeric',
			'offer'                 => 'required',
			'duration_hours'        => 'required',
			'certificate'           => 'required',
			'level'                 => 'required',
			'skills'                => 'required',
			'mode'                  => 'required',
			'live_project'          => 'required',
			'professional_trained'  => 'required',
			'batches_every_month'   => 'required|numeric',
		]);



			if($validator->fails()){
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status'=>1,'errors'=>$errorsBag],400);
				}	
				

		try {
			$course->enrolled              = $request->input('enrolled');
			$course->price                 = $request->input('price');
			$course->offer                 = $request->input('offer');
			$course->duration_hours        = $request->input('duration_hours');
			$course->certificate           = $request->input('certificate');
			$course->level                 = $request->input('level');
			$course->skills                = json_encode($request->input('skills'));
			$course->mode                  = $request->input('mode');
			$course->live_project          = $request->input('live_project');
			$course->professional_trained  = $request->input('professional_trained');
			$course->batches_every_month   = $request->input('batches_every_month');
			$course->status                = '1';
			$course->updated_by            = auth()->id() ?? 1;
			$course->save();

			return response()->json([
				'status' => 1,
				'msg'    => 'Course updated successfully!',
			], 200);

		} catch (\Exception $e) {
			\Log::error('editSaveCourseSeoTopic failed: ' . $e->getMessage());

			return response()->json([
				'status' => 0,
				'msg'    => $e->getMessage(),
			], 500);
		}
	}

	/**
	 *add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseTitle(Request $request,$id)
    {	 
		
 
        if($request->ajax()){ 			
  
		  $validator = Validator::make($request->all(),[		 
				
				'title' => 'required|min:5|max:75|unique:web_courses,title,'.$id.',id',	
				'course_defination'=>'required|min:10|max:370',		
				'slug' => 'required|unique:web_courses,slug,'.$id.',id',	
				'course_name'=>'required|min:3|max:50',	
				'rating'=>'required',
				'total_rating'=>'required|numeric',				 
				'category'=>'required',	
				'meta_title'=>'required|min:30|max:61',	
				'meta_description'=>'required|min:70|max:161',
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	
			
			
			 
			$updatetitle =array(
			'title'=>ucfirst($request->input('title')),			 	
			'meta_title'=>ucfirst($request->input('meta_title')),			
	    	'slug'=>$this->generate_slug(trim(str_replace('?','',$request->input('slug')))),	
			'course_name'=>ucfirst($request->input('course_name')),		 	
			'category'=>trim($request->input('category')),	
			'rating'=>trim($request->input('rating')),	
			'total_rating'=>trim($request->input('total_rating')),		
			'meta_description'=>trim($request->input('meta_description')),	
			'course_defination'=>trim($request->input('course_defination')),		
			'updated_by'=>1,				 	
			);
	  
			$checkupdate  =DB::table('web_courses')->where('id',$id)->update($updatetitle);	
			if($checkupdate){
				$status=1;							 
				$msg="Course title updated successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course title could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
 

 

	
  /*
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseExtraContent(Request $request,$id)
    {	  

        if($request->ajax()){   
		  $validator = Validator::make($request->all(),[				 
				'top_heading'=>'required',
				'top_description'=>'nullable|string',		 				 				
			 				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				  
				  
			$courseAbout = 	  CourseAbout::where('course_id',$id)->first();
			if(!empty($courseAbout)){
			$updatelearn =array(
			'top_heading'=>$request->input('top_heading'),	
			'top_description'=>$request->input('top_description'),	
			
	 	
                );


		
				$checkupdate  =DB::table('web_courses')->where('id',$id)->update($updatelearn);	
				if($checkupdate){
				$status=1;							 
				$msg="Course About submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course About could not be submitted!";	
			}
			
			}
		
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 


	/**
	 *add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseLearn(Request $request,$id)
    {	  
	

 
        if($request->ajax()){   
		  $validator = Validator::make($request->all(),[				 
				'why_learn_heading'=>'required',
				'why_learn'=>'required',					 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				  
			$updatelearn =array(
			'why_learn_heading'=>$request->input('why_learn_heading'),	
			'why_learn'=>json_encode($request->input('why_learn')));	

			$checkupdate  =DB::table('web_courses')->where('id',$id)->update($updatelearn);	
			if($checkupdate){
				$status=1;							 
				$msg="Course why learn submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course why learn could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	/**
	 *add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveTrainerAbout(Request $request,$id)
    {	  
	
 
        if($request->ajax()){   
		  $validator = Validator::make($request->all(),[				 
				'trainer_about'=>'required',
				'trainer_paragraph'=>'required',					 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				  
			
			$updatelearn = array(
    'trainer_about' => $request->input('trainer_about'),
);

			if ($request->filled('trainer_paragraph')) {
				$updatelearn['trainer_paragraph'] = json_encode(
					$request->input('trainer_paragraph')
				);
			}
			$checkupdate  =DB::table('web_courses')->where('id',$id)->update($updatelearn);	
			if($checkupdate){
				$status=1;							 
				$msg="Trainer submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Trainer could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

 
 

/*
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseSeoAbout(Request $request,$id)
    {	  
 
        if($request->ajax()){   
		  $validator = Validator::make($request->all(),[				 
				'courseabout'=>'required',
				'heading'=>'required',
			 				 				
			 				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				  
				  
			$courseAbout = 	  CourseAbout::where('course_id',$id)->first();

			
			if(!empty($courseAbout)){
			$updatelearn =array(
			'heading'=>$request->input('heading'),
			'courseabout'=>$request->input('courseabout'),					
			'heading1'=>$request->input('heading1'),	
			'description1'=>$request->input('description1'),	
			'heading2'=>$request->input('heading2'),	
			'description2'=>$request->input('description2'),	
			'heading3'=>$request->input('heading3'),	
			'description3'=>$request->input('description3'),	
			'heading4'=>$request->input('heading4'),	
			'description4'=>$request->input('description4'),	
			'heading5'=>$request->input('heading5'),	
			'description5'=>$request->input('description5'),	
			'heading6'=>$request->input('heading6'),	
			'description6'=>$request->input('description6'),	
	 	
                );

				 
			$checkupdate  = CourseAbout::where('course_id',$id)->update($updatelearn);	
				if($checkupdate){
				$status=1;							 
				$msg="Course About submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course About could not be submitted!";	
			}
			
			}else{
			    	$courseAboutHeading  = New CourseAbout;
			    	
					$courseAboutHeading->course_id = $id;
					$courseAboutHeading->courseabout = $request->input('courseabout');
					$courseAboutHeading->heading = $request->input('heading');
					$courseAboutHeading->heading1 = $request->input('heading1');
					$courseAboutHeading->description1 = $request->input('description1');
					$courseAboutHeading->heading2 = $request->input('heading2');
					$courseAboutHeading->description2 = $request->input('description2');
					$courseAboutHeading->heading3 = $request->input('heading3');
					$courseAboutHeading->description3 = $request->input('description3');
					$courseAboutHeading->heading4 = $request->input('heading4');
					$courseAboutHeading->description4 = $request->input('description4');
					$courseAboutHeading->heading5 = $request->input('heading5');
					$courseAboutHeading->description5 = $request->input('description5');
					$courseAboutHeading->heading6 = $request->input('heading6');
					$courseAboutHeading->description6 = $request->input('description6');

 
			    
			    	if($courseAboutHeading->save()){
				$status=1;							 
				$msg="Course About submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course About could not be submitted!";	
			}
			}
		
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
    
	  

	/*
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseBatchVisibility(Request $request,$id)
    {	  
	
        if($request->ajax()){   
		  $validator = Validator::make($request->all(),[				 
				'batch_visibility'=>'required',				 
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
			

				$updatebatch =array(
				'batch_visibility'=>trim($request->input('batch_visibility')),				 		 	
				'updated_by'=>1,				 	
				);

				$checkupdate  =DB::table('web_courses')->where('id',$id)->update($updatebatch);	
				if($checkupdate){
				$status=1;							 
				$msg="Course Batch visibility updated successfully !";		

				}else{
				$status=0;							 
				$msg="Course Batch visibility could not be update!";	
				}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
 

 
	
	 
 
 /**
 * Add/save Course Title with related courses.
 * Author: Brijesh Chauhan.
 *
 * @return \Illuminate\Http\Response
 */
public function editSaveCourseRelated(Request $request, $id)
{

    if (!$request->ajax()) {
        return response()->json(['status' => 0, 'msg' => 'Invalid request.'], 400);
    }

    $validator = Validator::make($request->all(), [
        'show_front_page'    => 'required',
        'footer_certificate' => 'required',
        'show_front_second'  => 'required',
        // 'show_top_menu'   => 'required',
        // 'show_on_footer'  => 'required',
    ]);

    if ($validator->fails()) {
        $errorsBag = $validator->getMessageBag()->toArray();
        return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
    }

    $course = DB::table('web_courses')->where('id', $id)->first();

    if (!$course) {
        return response()->json(['status' => 0, 'msg' => 'Course not found.'], 404);
    }

    $relatedCourses     = $request->filled('related_courses')
        ? json_encode($request->input('related_courses'))
        : json_encode([]);

    $relatedCoursesSide = $request->filled('related_courses_side')
        ? json_encode($request->input('related_courses_side'))
        : json_encode([]);

    $updateRelated = [
        'related_courses'        => $relatedCourses,
        'related_courses_side'   => $relatedCoursesSide,
        'show_front_page'        => $request->input('show_front_page'),
        'footer_certificate'     => $request->input('footer_certificate'),
        'footer_top_course'      => $request->input('footer_top_course'),
        'show_front_second'      => $request->input('show_front_second'),
        'show_trending_courses'  => $request->input('show_trending_courses'),
        // 'show_top_menu'      => $request->input('show_top_menu'),
        // 'show_on_footer'     => $request->input('show_on_footer'),
        // 'footer_city'        => $request->input('footer_city'),
        'updated_by'              => auth()->id(),
    ];

    DB::table('web_courses')->where('id', $id)->update($updateRelated);

    return response()->json([
        'status' => 1,
        'msg'    => 'Course related submitted successfully!',
    ], 200);
}
	/*
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseCertificate(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
  
		  $validator = Validator::make($request->all(),[				 
				'exam_title'=>'required',
				'exam_text'=>'required',
				'format'=>'required',
				'certification_type'=>'required',
				'delivery_method'=>'required',
				'certification_time'=>'required',
				'certification_cost'=>'required',
				'language'=>'required',
				 
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
			

			$course_cerificate =array(
			'exam_title'=>$request->input('exam_title'),
			'exam_text'=>$request->input('exam_text'),
			'format'=>$request->input('format'),
			'certification_type'=>$request->input('certification_type'),
			'delivery_method'=>$request->input('delivery_method'),
			'certification_time'=>$request->input('certification_time'),			
			'certification_cost'=>$request->input('certification_cost'),
			'language'=>$request->input('language'),			
			'certification_visibility'=>$request->input('certification_visibility'),
			'updated_by'=>1,
			);	
				 
			$update  =DB::table('web_courses')->where('id',$id)->update($course_cerificate);			
				 
	 
			if(!empty($update)){	
				
				$status=1;							 
				$msg="Course certificate update successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course certificate could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
	/*
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveFAQ(Request $request,$id)
    {	  
	
        if($request->ajax()){ 		
		 $validator = Validator::make($request->all(),[				 
				'faqq'=>'required',
				'faqa'=>'required',				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}

				
			$courses = Course::findOrFail($id);
			if(!empty($request->input('faqq'))){
				$faqq= json_encode($request->input('faqq'));
			}else{
				$faqq="";
			}
			
			if(!empty($request->input('faqa'))){
				$faqa= json_encode($request->input('faqa'));
			}else{
				$faqa="";
			}
			
			$FAQs= array(
			'faqq'=>$faqq,
			'faqa'=>$faqa
			);
			$courses->FAQs = json_encode($FAQs);				 
			$courses->updated_by =1; 		 
			if($courses->save()){
				$status=1;							 
				$msg="Course FAQs submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course FAQs could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
	
	/*
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
				'name'=>'required',
				'comment'=>'required',	
				'reviews_visibility'=>'required',
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}

				
			$courses = Course::findOrFail($id);
			if(!empty($request->input('name'))){
				$name= json_encode($request->input('name'));
			}else{
				$name="";
			}
			
			if(!empty($request->input('comment'))){
				$comment= json_encode($request->input('comment'));
			}else{
				$comment="";
			}
			
			if(!empty($request->input('company'))){
				$company= json_encode($request->input('company'));
			}else{
				$company="";
			}
			
			if(!empty($request->input('rating'))){
				$rating= json_encode($request->input('rating'));
			}else{
				$rating="";
			}
			
			
			if(!empty($request->input('linkedinurl'))){
				$linkedinurl= json_encode($request->input('linkedinurl'));
			}else{
				$linkedinurl="";
			}
			$reviews= array(
			'name'=>$name,
			'comment'=>$comment,
			'company'=>$company,
			'rating'=>$rating,
			'linkedinurl'=>$linkedinurl
			);

			$courses->reviews = json_encode($reviews);
			$courses->reviews_visibility = $request->input('reviews_visibility');	
			$courses->updated_by =1; 		 
			if($courses->save()){
				$status=1;							 
				$msg="Course Testimonial submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course Testimonial could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
   /*
     * Get matches trainers based on ajax.
     *
     * @param  string
     * @return JSON Object having matched course details
     */
    public function getCourseAjax(Request $request)
    {
		if($request->ajax()){
			if(null==$request->input('q')){
				$course = Course::where('status',0)->take(6)->get();
			}else{
				$course = Course::where('title','LIKE',"%".$request->input('q')."%")->get();
			}
			return response()->json($course,200);
		}
	}
	
	 
   /*
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {	  
		$edit_data= Course::findOrFail(base64_decode($id));
		
	 	$cetegories= Category::where('status',1)->get();	
    	$course_module= Course::select('id','title')->where('course_type','1')->where('status',1)->get();
		$course_list= Course::select('id','title','slug')->where('course_type','<>','3')->where('status',1)->get();	
			
		$speciality =Speciality::where('id',1)->first();
		
		$aboutHeading = CourseAbout::where('course_id',base64_decode($id))->first();	
			
	   $tools_list = ToolsCovered::get();
    	//$coursecurriculum =CourseCurriculumExcel::where('course_id',base64_decode($id))->get();	
		
		
 
$rows = CourseCurriculumExcel::where('course_id', base64_decode($id))
    ->orderBy('id', 'asc')
    ->get();

// Group children by their parent FK — done once, in memory, no extra queries
$byHeadingId    = $rows->groupBy('heading_id');
$byContentId    = $rows->groupBy('content_id');
$bySubcontentId = $rows->groupBy('subcontent_id');
$byEndcontentId = $rows->groupBy('endcontent_id');

// Root-level rows: real headings, no parent
$headings = $rows->filter(function ($row) {
    return empty($row->heading_id) && !empty($row->heading);
});

$coursecurriculum = $headings->map(function ($heading) use ($byHeadingId, $byContentId, $bySubcontentId, $byEndcontentId) {

    $topics = $byHeadingId->get($heading->id, collect());

    return [
        'title'  => $heading->heading,
        'topics' => $topics->map(function ($topic) use ($byContentId, $bySubcontentId, $byEndcontentId) {

            $subcontents = $byContentId->get($topic->id, collect());

            return [
                'content'     => $topic->coursescontent,
                'subcontents' => $subcontents->map(function ($sub) use ($bySubcontentId, $byEndcontentId) {

                    $lastcontents = $bySubcontentId->get($sub->id, collect());

                    return [
                        'subcontent'   => $sub->subcontent,
                        'lastcontents' => $lastcontents->map(function ($last) use ($byEndcontentId) {

                            $endcontents = $byEndcontentId->get($last->id, collect());

                            return [
                                'lastcontent' => $last->lastcontent,
                                'endcontents' => $endcontents->map(function ($end) {
                                    return ['endcontent' => $end->endcontent];
                                })->values()->toArray(),
                            ];
                        })->values()->toArray(),
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray(),
    ];
})->values()->toArray();
 

		$citys= CourseCity::orderBy('city','asc')->where('status',1)->get();	
        return view('admin.seopage.edit_seocourse',['edit_data'=>$edit_data,'course_list'=>$course_list,'course_module'=>$course_module,'cetegories'=>$cetegories,'speciality'=>$speciality,'coursecurriculum'=>$coursecurriculum,'citys'=>$citys,'aboutHeading'=>$aboutHeading,'tools_list'=>$tools_list]);
    } 
	
 
	// GET  Course pagination
	public function getCoursePagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$courses= 	Course::orderBy('id','DESC');	
			$courses=$courses->where('course_type','3');
		if($request->input('search.value')!==''){
				$courses = $courses->where(function($query) use($request){
					$query->orWhere('course_name','LIKE','%'.$request->input('search.value').'%')
					      ->orWhere('title','LIKE','%'.$request->input('search.value').'%')						   
						  ->orWhere('slug','LIKE','%'.$request->input('search.value').'%');
				});
			}
			
			if(!empty($request->input('search.category'))){				 
			$courses = $courses->where('category','LIKE','%'.$request->input('search.category').'%');
			}			
			if(!empty($request->input('search.course_type'))){		
//echo $request->input('search.course_type');die;			
			$courses = $courses->where('seo_type','LIKE','%'.$request->input('search.course_type').'%');
			}
			$courses = $courses->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $courses->total();
			$returnLeads['recordsFiltered'] = $courses->total();
			$returnLeads['recordCollection'] = [];
//echo "<pre>";print_r($courses);die;
			foreach($courses as $course){				 
				$action="";
				$seperate="";
				$image="";
					if($course->status=='1'){
				  $action .='<a href="/courses/'.$course->slug.'" title="View Course Content" class="btn btn-primary" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>';	
					}else{
					     $action .='<a href="/view/'.$course->slug.'" title="View Course Content" class="btn btn-primary" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>'; 
					    
					}
				//$action .='<a href="admin/course/course-view/'.base64_encode($course->id).'" title="View Course Content" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>';					 
				$action .='<a href="/admin/seopage/edit/'.base64_encode($course->id).'" title="Edit Course Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_course_page') ){
				$action .='<a href="javascript:SEOController.delete('.$course->id.')" title="Delete Course Content" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
				if($course->subcategory){
					$subcategory = SubCategory::where('id',$course->subcategory)->first();
					if($subcategory){
				$vimage= json_decode($subcategory->course_image); 
				$image='<img src="'.asset($vimage['course_image']['src']).'" type="'.$vimage['course_image']['alt'].'" width="100">'; 
				}
				}else{
					$image="";
				}
				$status="";
				if($course->status=='1'){
				$status .='<a href="javascript:SEOController.status('.$course->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:SEOController.status('.$course->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
				}
				
				
				if($course->seo_type=='1'){
					$course_type= "Course Type 1";
				}else if($course->seo_type=='2'){
					$course_type= "Course Type 2";
				}else{
					$course_type= "";
				}
				
				 
					$data[] = [		 		 		 
						$course->course_name,					 	
						$course->title,						
						$course->slug,						
						$course_type,
						$image,			
						$status, 						
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
       	 
		$delet_data = Course::findOrFail($id);	 
		if($delet_data->course_icons!='')
		{			 
			$image = json_decode($delet_data->course_icons);			
			$large = $image['course_icons']['src'];
			if(!empty($image['course_icons']['src'])){
			$thumbnail = $image['course_icons']['src'];
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
		$edit_data = array('course_icons'  =>"",);	 
		$del = Course::where('id',$id)->update($edit_data);			 		
		return redirect('admin/seopage/edit/'.base64_encode($id))->with("success","Icons deleted successfully.");
			
    }
  
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_image($id)
    {
       	 
		$delet_data = Course::findOrFail($id);	 
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
		$del = Course::where('id',$id)->update($edit_data);			 		
		return redirect('admin/seopage/edit/'.base64_encode($id))->with("success","image deleted successfully.");
			
    }
  
 
 
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
		public function delete($id)
		{
 
			$courses = Course::findOrFail($id);	
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
			$msg="Course deleted successfully !";		

			}else{
			$status=0;							 
			$msg="Course could not be deleted!";	
			}

			return response()->json(['status'=>$status,'msg'=>$msg],200); 
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
		 
		$courses = Course::findOrFail($id);	 
		$courses->status=$val;
	
		if($courses->save()){
			$status=1;							 
			$msg="Course status updated successfully!";					
			}else{
			$status=0;							 
			$msg="Course status could not be successfully, Please try again !";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
 
 
 /**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_coursecategoryType(Request $request)
    {
		//echo "<pre>";print_r($_POST);die;
        
		$tval = $request->input('tval'); 
		$cat = $request->input('cat'); 	
//echo $tval.'--'.$cat; 
	$category_data = Course::select('category', 'category_name')
    ->where('course_type', $tval)
    ->where('status', 1)
	 ->whereNotNull('category_slug')
    ->distinct()
    ->orderBy('category_name')
    ->get();
	
	

		// $category_data= DB::table('web_courses as course');		 
		// $category_data  =$category_data->join('web_categories as category','course.category','=','category.id','left');
		// $category_data= $category_data->select('course.id as courseid','course.title as coursetitle','course.slug as slug','course.course_name as course_name','course.category as categoryid','category.category as categoryname');
		// $category_data= $category_data->groupby('course.category');
		// $category_data= $category_data->orderBy('category.category');
		
		// $category_data= $category_data->where('course.course_type','=',$tval);
		// $category_data= $category_data->where('course.seo_page','=','1');
	
		// $category_data= $category_data->where('course.status',1)->get();
		
		
	//	echo "<pre>";print_r($category_data);die;
		
		/* $subcategory_data= DB::table('web_coursepdf as pdf');		 
		$subcategory_data  =$subcategory_data->join('web_subcategory as subcategory','pdf.subcategory','=','subcategory.id','left');
		$subcategory_data= $subcategory_data->select('pdf.*','subcategory.id as subcategoryid','subcategory.subcategory as subcategoryname','subcategory.category as categoryname');
		$subcategory_data= $subcategory_data->groupby('pdf.subcategory');
		$subcategory_data= $subcategory_data->orderBy('subcategory.subcategory');
		
		$subcategory_data= $subcategory_data->where('pdf.category',$id);
		$subcategory_data= $subcategory_data->where('pdf.status',1)->get(); */	
		//echo "<pre>";print_r($category_data);die;
		if($category_data){ 
		echo '<option value="">Select Category</option>';
		foreach($category_data as $category){ 
		$selected = ($cat==$category->category)?"selected":'';
		echo'<option value="'.$category->category.','.$tval.'" '.$selected.' >'.$category->category_name.'</option>';
		}
		}else { 
		echo'<option value="">No record found</option>';
		}
		
	}
	
	
 
	/**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCourseSubCategory(Request $request)
    {        
		 
		$id = explode(',',$request->input('cid')); 
	//	echo "<pre>";print_r($id);echo $id[0];echo $id[1];die;
		$sid = $request->input('sid'); 		
//echo $id.'--'.$sid;die;		
	//	$subcategory_data =SubCategory::where('category',$id)->where('status',1)->get();		
		$subcategory_data= DB::table('web_courses as course');		 
		$subcategory_data  =$subcategory_data->join('web_subcategory as subcategory','course.subcategory','=','subcategory.id','left');
		$subcategory_data= $subcategory_data->select('course.id as courseid','course.title as coursetitle','course.slug as slug','course.course_name as course_name','course.category as categoryid','subcategory.id as subcategoryid','subcategory.subcategory as subcategoryname');
		$subcategory_data= $subcategory_data->groupby('course.subcategory');
		$subcategory_data= $subcategory_data->orderBy('subcategory.subcategory');
		$subcategory_data= $subcategory_data->where('course.category',$id[0]);
		$subcategory_data= $subcategory_data->where('course.course_type','=',$id[1]);
		$subcategory_data= $subcategory_data->where('course.seo_page','=',1);
		$subcategory_data= $subcategory_data->where('course.status',1)->get();
		
		
		//echo "<pre>";print_r($subcategory_data);die;
		
		/* $subcategory_data= DB::table('web_coursepdf as pdf');		 
		$subcategory_data  =$subcategory_data->join('web_subcategory as subcategory','pdf.subcategory','=','subcategory.id','left');
		$subcategory_data= $subcategory_data->select('pdf.*','subcategory.id as subcategoryid','subcategory.subcategory as subcategoryname','subcategory.category as categoryname');
		$subcategory_data= $subcategory_data->groupby('pdf.subcategory');
		$subcategory_data= $subcategory_data->orderBy('subcategory.subcategory');
		
		$subcategory_data= $subcategory_data->where('pdf.category',$id);
		$subcategory_data= $subcategory_data->where('pdf.status',1)->get(); */


		
		//echo "<pre>";print_r($subcategory_data);die;
		if($subcategory_data){ 
		echo '<option value="">Select Sub Category</option>';
		foreach($subcategory_data as $subcategory){ 
		$selected = ($sid==$subcategory->subcategoryid)?"selected":'';
		echo'<option value="'.$id[0].','.$subcategory->subcategoryid.','.$id[1].'" '.$selected.' >'.$subcategory->subcategoryname.'</option>';
		}
		}else { 
		echo'<option value="">No record found</option>';
		}
		
	}
 
 /**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCourseName(Request $request)
    {
        
		$id = $request->input('sid'); 
		//echo "<pre>";print_r($_POST);die;
		
		$id=explode(',',$id);
		$pid = $request->input('pid'); 


		$course_data= DB::table('web_courses as course')	 		
		->select('course.*','course.id as courseid')
		->where('course.category',$id[0])
	
		->where('course.course_type','=',$id[1])
		
		->where('course.seo_page','=','1')
		->where('course.status',1)->get();
		

		
		
		//echo "<pre>";print_r($subcategory_data);die;
		if($course_data){ 
		echo '<option value="">Select Course</option>';
		foreach($course_data as $course){ 
		$selected = ($pid==$course->id)?"selected":'';

		echo'<option value="'.$course->id.','.$id[0].','.$id[1].'" '.$selected.' >'.$course->course_name.'</option>';

		}
		} else { 
		echo'<option value="">No record found</option>';
		}
		
		
	 	
		  
    } 
	
	
	/**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

	public function getCourseCity(Request $request)
{
    $id  = explode(',', $request->input('cid'));
    $pid = $request->input('pid');

    $courseCloneId = $id[0];
    $categoryId    = $id[1] ?? null;

    // Cities already used for this course clone
    $usedCities = Course::where('category', $categoryId)
        ->where('course_clone_id', $courseCloneId)
        ->where('city', '<>', '')
        ->pluck('city')
        ->unique()
        ->toArray();

    // Master active city list
    $allCities = CourseCity::where('status', '1')->pluck('city')->toArray();

    // Remove already-used cities
    $availableCities = array_diff($allCities, $usedCities);

    if (!empty($availableCities)) {
        echo '<option value="">Select City</option>';
        foreach ($availableCities as $city) {
            $selected = ($pid == $city) ? 'selected' : '';
            echo '<option value="' . e($city) . '" ' . $selected . '>' . e($city) . '</option>';
        }
    } else {
        echo '<option value="">No record found</option>';
    }
}
     
 	
	/**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSEOCategoryPDF(Request $request)
    {        
		$id = $request->input('cid'); 
		$sid = $request->input('sid'); 		 
	//	$subcategory_data =SubCategory::where('category',$id)->where('status',1)->get();	
		
		$subcategory_data= DB::table('web_coursepdf as pdf');		 
		$subcategory_data  =$subcategory_data->join('web_subcategory as subcategory','pdf.subcategory','=','subcategory.id','left');
		$subcategory_data= $subcategory_data->select('pdf.*','subcategory.id as subcategoryid','subcategory.subcategory as subcategoryname','subcategory.category as categoryname');
		$subcategory_data= $subcategory_data->groupby('pdf.subcategory');
		$subcategory_data= $subcategory_data->where('pdf.category',$id);
		$subcategory_data= $subcategory_data->where('pdf.status',1)->get();


		
		//echo "<pre>";print_r($subcategory_data);die;
		if($subcategory_data){ 
		echo '<option value="">Select sub Category</option>';
		foreach($subcategory_data as $subcategory){ 
		$selected = ($sid==$subcategory->subcategoryid)?"selected":'';

		echo'<option value="'.$subcategory->subcategoryid.'" '.$selected.' >'.$subcategory->subcategoryname.'</option>';

		}
		} else { 
		echo'<option value="">No record found</option>';
		}
		
	}
	/**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSEOCoursePdf(Request $request)
    {
        
		$id = $request->input('sid'); 
		$pid = $request->input('pid'); 
		 
	//	$subcategory_data =SubCategory::where('category',$id)->where('status',1)->get();
		
		
		$subcategory_data= DB::table('web_coursepdf as pdf');	 		
		$subcategory_data= $subcategory_data->select('pdf.*','pdf.id as pdfid');
 
		$subcategory_data= $subcategory_data->where('pdf.status',1)->get();


		
		//echo "<pre>";print_r($subcategory_data);die;
		if($subcategory_data){ 
		echo '<option value="">Select Course PDF</option>';
		foreach($subcategory_data as $subcategory){ 
		$selected = ($pid==$subcategory->coursePdfText)?"selected":'';

		echo'<option value="'.$subcategory->coursePdfText.'" '.$selected.' >'.$subcategory->coursePdfText.'</option>';

		}
		} else { 
		echo'<option value="">No record found</option>';
		}
		  
    }
 
 
 /** Select subcategory wise show of course module onlu type 1
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSEOCourseReletedEdit(Request $request)
    {	 
	
	 
		$cid = $request->input('cid');  		 
		$cr = $request->input('cr'); 		
		$subcategory_data= DB::table('web_courses as course');	 		
		$subcategory_data= $subcategory_data->select('course.*','course.id as courseid');	 
		//$subcategory_data= $subcategory_data->where('course.category','=',$cid);	 
		$subcategory_data= $subcategory_data->where('course.course_type','=',3);	 
		$subcategory_data= $subcategory_data->where('course.status',1)->get();
		
		//echo "<pre>";print_r($subcategory_data);die;


		if(!empty($cr)){	
		$related_courses = json_decode($cr);	
		}else{
		$related_courses=array();
		}
		
		if(!empty($subcategory_data) && count($subcategory_data)>0){ 
		foreach($subcategory_data as $subcategory){ 
		if(in_array($subcategory->courseid, $related_courses)){		 
			echo'<option value="'.$subcategory->courseid.'" selected>'.$subcategory->title.'</option>';
		}else{
			echo'<option value="'.$subcategory->courseid.'" >'.$subcategory->title.'</option>';
		}
		}
		}else{ 
		echo'<option value="">No record found</option>';
		}
		
		
		 
    } 
 
 
	/**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function getcourseCityOnline(Request $request)
{
    $id  = explode(',', $request->input('cid'));
    $pid = $request->input('pid');

    $courseCloneId = $id[0];
    $categoryId    = $id[1] ?? null;

    // Cities already used for this course clone (exclude these)
    $usedCities = Course::where('category', $categoryId)
        ->where('course_clone_id', $courseCloneId)
        ->where('city', '<>', '')
        ->pluck('city')
        ->unique()
        ->toArray();

    // Full master city list — replace with your actual source
    $allCities = ['Online'];
    // or if it's a static list: $allCities = ['Online', 'Delhi', 'Mumbai', 'Pune', ...];

    // Remove cities already used — this replaces your broken in_array loop
    $availableCities = array_diff($allCities, $usedCities);

    if (!empty($availableCities)) {
        echo '<option value="">Select City</option>';
        foreach ($availableCities as $city) {
            $selected = ($pid == $city) ? 'selected' : '';
            echo '<option value="' . e($city) . '" ' . $selected . '>' . e($city) . '</option>';
        }
    } else {
        echo '<option value="">No record found</option>';
    }
}

    
	/**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

	public function getcourseNCRCity(Request $request)
{
    $id  = explode(',', $request->input('cid'));
    $pid = $request->input('pid');

    $courseCloneId = $id[0];
    $categoryId    = $id[1] ?? null;

    // Cities already used for this course clone
    $usedCities = Course::where('category', $categoryId)
        ->where('course_clone_id', $courseCloneId)
        ->where('city', '<>', '')
        ->pluck('city')
        ->unique()
        ->toArray();

    // Fixed NCR city list
    $ncrCities = ['Delhi', 'Noida', 'Gurgaon'];

    // Remove already-used cities
    $availableCities = array_diff($ncrCities, $usedCities);

    if (!empty($availableCities)) {
        echo '<option value="">Select City</option>';
        foreach ($availableCities as $city) {
            $selected = ($pid == $city) ? 'selected' : '';
            echo '<option value="' . e($city) . '" ' . $selected . '>' . e($city) . '</option>';
        }
    } else {
        echo '<option value="">No record found</option>';
    }
}
    
 
 function generate_slug($slug=null){
	if(is_null($slug)){
		return null;
	}
	$slug = explode(" ",$slug);
	$slug = array_map('trim',$slug);
	//$slug = array_map('remove_splchars',$slug);
	$slug = array_map('strtolower',$slug);
	$slug = implode("-",$slug);
	return $slug;
}
 
 
 
 
}
