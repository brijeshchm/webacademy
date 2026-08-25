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
use Symfony\Component\HttpFoundation\StreamedResponse;
use Image;
use App\Models\Course;
use App\Models\CourseCity;
use App\Models\Category;
use App\Models\ToolsCovered;
use App\Models\Speciality;

use App\Models\CourseAboutExcel;
use App\Models\CourseAbout;
use App\Models\CourseCurriculumExcel;

 
use App\Models\CoursesPdf;
use App\Helpers;
use App\Exports\excelFormateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
 
class CourseController extends Controller implements HasMiddleware
{

 	public static function middleware(): array
    {
        return [
            'auth',
        ];
    }



    /*
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        
	 //$this->middleware('auth');
	   
    }

    /*
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
        return view('admin.course.index',['search'=>$search,'categorylist'=>$categorylist]);
    } 
	
 
   /*
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {	  
		$course_module= Course::select('id','title')->where('course_type','1')->where('status',1)->get();
		$course_list= Course::select('id','title')->where('course_type','<>','3')->where('status',1)->get();	
		$cetegories= Category::where('status',1)->get();	
			
		 	
	 
		 
 
		$citys= CourseCity::orderBy('city','asc')->where('status',1)->get();
		 
        return view('admin.course.add_course',['course_list'=>$course_list,'course_module'=>$course_module,'citys'=>$citys,'cetegories'=>$cetegories]);
    } 
	 /*
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCourseTitle(Request $request)
    {	  

        if($request->ajax()){   
		  	$validator = Validator::make($request->all(),[
		      	'course_name'=>'required|min:3|max:160',	
				'title'=>'required|unique:web_courses,title|min:5|max:175',
				'category'=>'required',
				'rating'=>'required',				
				'total_rating'=>'required|numeric', 
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
      
        
		
			 // GENERATING SLUG
			// ***************
			$business_slug = NULL;
			$business_slug = $this->generate_slug(str_replace('?','',$request->input('title')));
			if(is_null($business_slug)){
			return redirect("/admin/course/add");

			}
			$slugExists = DB::table('web_courses')
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

								
				$courses = New Course;
				$courses->title = $request->input('title');	
				
				$courses->slug  = $business_slug;				
				$courses->course_name = ucfirst($request->input('course_name'));
				
				$category = Category::where('id',$request->input('category'))->first();
				if(!empty($category)){
					$courses->category = $request->input('category');
					$courses->category_slug = $category->category_slug;
					$courses->category_name = ucfirst($category->category);
				}
				$courses->rating = $request->input('rating');
				$courses->total_rating = $request->input('total_rating');			 		 					 
 
				$courses->course_type=trim($request->input('course_type'));
				$courses->status = '1';				 
				$courses->created_by =1;	
				$courses->save();
				
				$add= 1;
			
			
		
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


	

		/*
	 add save Course Title with slug
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
				'description'=>'required|min:10|max:370',		
				'slug' => 'required|unique:web_courses,slug,'.$id.',id',	
				'course_name'=>'required|min:3|max:160',	
				'rating'=>'required',
				'total_rating'=>'required|numeric',				 
				'category'=>'required',				
				'course_defination'=>'required|max:360',				
				'meta_title'=>'required|min:30|max:61',	
				'meta_description'=>'required|min:70|max:161',
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	
			
			
			if(!empty($request->input('courses_module'))){
					 $courses_module=json_encode($request->input('courses_module'));					 
				 }else{
					 $courses_module="";
			}
			
            	$category = Category::where('id',$request->input('category'))->first();
			 
				
			$updatetitle =array(
			'title'=>ucfirst($request->input('title')),	
			'description'=>ucfirst($request->input('description')),			
	    	'slug'=>$this->generate_slug(trim(str_replace('?','',$request->input('slug')))),	
			'course_name'=>ucfirst($request->input('course_name')),	
			'category'=>trim($request->input('category')),	
			'category_slug'=>trim($category->category_slug),	
			'category_name'=>trim($category->category),			 
			'rating'=>trim($request->input('rating')),	
			'total_rating'=>trim($request->input('total_rating')),
			'courses_module'=>trim($courses_module),	
			'course_type'=>trim($request->input('course_type')),
			'course_duration'=>trim($request->input('course_duration')),
			'meta_title'=>trim($request->input('meta_title')),		 
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
	

	//dd($request);
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

	public function editSaveCourseTopic(Request $request, $id)
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
        'featured'                 => 'required',
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
        $course->featured                 = $request->input('featured');
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
	 
	/*
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseAbout_old(Request $request,$id)
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
	

/*
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseAbout(Request $request,$id)
    {	  
 

	//dd($request);
        if($request->ajax()){   
		  $validator = Validator::make($request->all(),[				 
				'courseabout'=>'required',
				'paragraph1'=>'required',
			 				 				
			 				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				  
				  
			$courseAbout = 	  CourseAbout::where('course_id',$id)->first();

			
			if(!empty($courseAbout)){
			$updatelearn =array(
			'courseabout'=>$request->input('courseabout'),	
			'heading'=>$request->input('heading'),	
			'paragraph1'=>$request->input('paragraph1'),	
			'paragraph2'=>$request->input('paragraph2'),	
			'paragraph3'=>$request->input('paragraph3'),	
			'paragraph4'=>$request->input('paragraph4'),	
			'paragraph5'=>$request->input('paragraph5'),	
			'paragraph6'=>$request->input('paragraph6'),	
	 	
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
					$courseAboutHeading->paragraph1 = $request->input('paragraph1');
					$courseAboutHeading->paragraph2 = $request->input('paragraph2');
					$courseAboutHeading->paragraph3 = $request->input('paragraph3');
					$courseAboutHeading->paragraph4 = $request->input('paragraph4');
					$courseAboutHeading->paragraph5 = $request->input('paragraph5');
					$courseAboutHeading->paragraph6 = $request->input('paragraph6');
			    
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
	
	public function editSaveCurriculum(Request $request, $id)
	{


    if ($request->isMethod('post')) {

        try {

            $validator = Validator::make($request->all(), [
                'course_curriculum' => 'required|file|mimes:csv,txt|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 1,
                    'errors' => $validator->getMessageBag()->toArray()
                ], 400);
            }

            if (!$request->hasFile('course_curriculum')) {
                return response()->json(['status' => 0, 'msg' => 'No file uploaded.'], 400);
            }

            $file      = $request->file('course_curriculum');
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, ['csv'])) {
                return response()->json(['status' => 0, 'msg' => 'Only CSV files are allowed.'], 400);
            }

            $filePath        = "excell";
            $filename        = str_replace(' ', '_', trim($file->getClientOriginalName()));
            $destinationPath = public_path($filePath);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            $fileTextName = $filename;

            // Delete old curriculum before re-inserting
            CourseCurriculumExcel::where('course_id', $id)->delete();

                    
            
                        // ✅ Read entire file and fix line endings first
            $csvContent = file_get_contents($destinationPath . '/' . $filename);
            
            // Fix BOM + Windows/Mac line endings
            $csvContent = preg_replace('/\x{FEFF}/u', '', $csvContent);        // remove BOM
            $csvContent = str_replace(["\r\n", "\r"], "\n", $csvContent);       // normalize line endings
            
            // Write cleaned file back
            file_put_contents($destinationPath . '/' . $filename, $csvContent);
            
            // Now open cleaned file
            $csvFile = fopen($destinationPath . '/' . $filename, 'r');
            
            if ($csvFile === false) {
                throw new \Exception('Failed to open CSV file.');
            }
            
            fgetcsv($csvFile, 0, ','); // skip header row
            
            $add                = 0;
            $coursesHeading     = null;
            $coursesContent     = null;
            $coursesSubContent  = null;
            $coursesLastcontent = null;
            
            while (($row = fgetcsv($csvFile, 0, ',')) !== FALSE) {
            
                $row = array_pad($row, 5, '');
            
                // Clean each cell
                foreach ($row as &$cell) {
                    $cell = trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\xFF]/', '', $cell));
                }
                unset($cell);
            
                $heading = $row[0];
                $level1  = $row[1];
                $level2  = $row[2];
                $level3  = $row[3];
                $level4  = $row[4];
            
                // Skip completely empty rows
                if ($heading == "" && $level1 == "" && $level2 == "" && $level3 == "" && $level4 == "") {
                    continue;
                }
            
                \Log::info('CSV Row', compact('heading', 'level1', 'level2', 'level3', 'level4'));
            
                if ($heading != "") {
            
                    $coursesHeading            = new CourseCurriculumExcel;
                    $coursesHeading->course_id = $id;
                    $coursesHeading->heading   = str_replace('?', '', $heading);
                    $coursesHeading->save();
                    $add = 1;
            
                } elseif ($level1 != "") {
            
                    if (!$coursesHeading) {
                        \Log::warning('level1 found but no heading parent', ['level1' => $level1]);
                        continue;
                    }
            
                    $coursesContent                 = new CourseCurriculumExcel;
					$coursesContent->course_id = $id;
                    $coursesContent->heading_id     = $coursesHeading->id;
                    $coursesContent->coursescontent = str_replace('?', '', $level1);
                    $coursesContent->save();
                    $add = 1;
            
                } elseif ($level2 != "") {
            
                    if (!$coursesContent) {
                        \Log::warning('level2 found but no content parent', ['level2' => $level2]);
                        continue;
                    }
            
                    $coursesSubContent             = new CourseCurriculumExcel;
					$coursesSubContent->course_id = $id;
                    $coursesSubContent->content_id = $coursesContent->id;
                    $coursesSubContent->subcontent = str_replace('?', '', $level2);
                    $coursesSubContent->save();
                    $add = 1;
            
                } elseif ($level3 != "") {
            
                    if (!$coursesSubContent) {
                        \Log::warning('level3 found but no subcontent parent', ['level3' => $level3]);
                        continue;
                    }
            
                    $coursesLastcontent                = new CourseCurriculumExcel;
					$coursesLastcontent->course_id = $id;
                    $coursesLastcontent->subcontent_id = $coursesSubContent->id;
                    $coursesLastcontent->lastcontent   = str_replace('?', '', $level3);
                    $coursesLastcontent->save();
                    $add = 1;
            
                } elseif ($level4 != "") {
            
                    if (!$coursesLastcontent) {
                        \Log::warning('level4 found but no lastcontent parent', ['level4' => $level4]);
                        continue;
                    }
            
                    $courseEndContent                = new CourseCurriculumExcel;
					$courseEndContent->course_id = $id;
                    $courseEndContent->endcontent_id = $coursesLastcontent->id;
                    $courseEndContent->endcontent    = str_replace('?', '', $level4);
                    $courseEndContent->save();
                    $add = 1;
                }
            }
            
            fclose($csvFile);

            if (!empty($add)) {

                $coursesexcel                        = Course::findOrFail($id);
                $coursesexcel->coursecurriculumexcel = $fileTextName;
                $coursesexcel->save();

                return response()->json([
                    'status' => 1,
                    'msg'    => 'Course curriculum updated successfully!'
                ], 200);

            } else {

                return response()->json([
                    'status' => 0,
                    'msg'    => 'Course curriculum could not be updated! Check CSV format.'
                ], 200);
            }

        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'status' => 0,
                'msg'    => 'Database error: ' . $e->getMessage()
            ], 500);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 0,
                'msg'    => 'Validation error.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'msg'    => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
	 

	 public function editSaveCurriculum_old(Request $request,$id)
	{  	
		  
		if($request->isMethod('post') )
		{	
			$validator = Validator::make($request->all(),[				 
			'course_curriculum'=>'required',
			]);
			if($validator->fails()){
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
			$allowedFileType = [			 
			'text/csv',
// 			'application/vnd.ms-excel'
			];		 
			if (in_array($_FILES["course_curriculum"]["type"], $allowedFileType))
				{			
					$filePath = "excell";
					$file =  $request->file('course_curriculum');
					$filename =str_replace(' ', '_', trim($file->getClientOriginalName()));			 
					$destinationPath = public_path($filePath); 			
					if(file_exists($destinationPath.'/'.$filename)){
						$filename = $filename;
					}
					$file->move($destinationPath,$filename);	
					$fileTextName= str_replace(' ', '_', trim($file->getClientOriginalName()));
					 
					$csvFile = fopen($destinationPath.'/'.$filename, 'r');
					fgetcsv($csvFile);
					$i=0;
						while(($row = fgetcsv($csvFile)) !== FALSE){
										 
							$heading = trim(ltrim($row[0]));	  	

							if($heading !="")
							{				 
								$coursesHeading  = New CourseCurriculumExcel;
								$coursesHeading->course_id = $id;
								$coursesHeading->heading = trim(str_replace('?','',$heading));
								$coursesHeading->save();
								$add= 1;
							}else 
								if($heading=="")
								{
									$level1 = trim(ltrim($row[1])); 
									if($level1 !="")
									{

										$coursesContent  = New CourseCurriculumExcel;	 
										$coursesContent->heading_id = $coursesHeading->id;
										$coursesContent->coursescontent = ltrim(str_replace('?','',$level1));
										$coursesContent->save();
										$add= 1;	
									}else
										if($level1=="")
										{
											$level2 = trim(ltrim($row[2]));
											if($level2 !="")
											{				
											$coursesSubContent  = New CourseCurriculumExcel;	 
											$coursesSubContent->content_id = $coursesContent->id;
											$coursesSubContent->subcontent = ltrim(str_replace('?','',$level2));						
											$coursesSubContent->save();
											$add= 1;

											}else 
												if($level2=="")
												{
													$level3 = trim(ltrim($row[3]));
													if($level3 !=""){					
													$coursesLastcontent  = New CourseCurriculumExcel;	 
													$coursesLastcontent->subcontent_id = $coursesSubContent->id;
													$coursesLastcontent->lastcontent = ltrim(str_replace('?','',$level3));						 
													if($coursesLastcontent->save()){
													$add= 1;
													}				 

													}else if($level3=="")
													{
														$level4 = trim(ltrim($row[4]));
														if($level4 !="")
														{					
															$courseEndContent  = New CourseCurriculumExcel;	 
															$courseEndContent->endcontent_id = $coursesLastcontent->id;
															$courseEndContent->endcontent = ltrim(str_replace('?','',$level4));						 
															if($courseEndContent->save()){
															$add= 1;
															}				 
														}
													}
												}	   
										}
								}	
							
						}
				 



					 			 
				} 		
			if(!empty($add)){
			    
			    $coursesexcel = Course::findOrFail($id);			 
				if($request->hasFile('course_curriculum')){					 				
					$coursesexcel->coursecurriculumexcel = '.$fileTextName.';					
				}else{
					$coursesexcel->coursecurriculumexcel = $coursesexcel->coursecurriculumexcel;	
				} 				 	 				 								
				$coursesexcel->save(); 
			    
				$status=1;							 
				$msg="Course curriculum updated successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course curriculum could not be updated!";	
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
        return view('admin.course.edit_course',['edit_data'=>$edit_data,'course_list'=>$course_list,'course_module'=>$course_module,'cetegories'=>$cetegories,'speciality'=>$speciality,'coursecurriculum'=>$coursecurriculum,'citys'=>$citys,'aboutHeading'=>$aboutHeading,'tools_list'=>$tools_list]);
    } 
	
 
	// GET  Course pagination
	public function getCoursePagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$courses= 	Course::orderBy('id','DESC');	
		$courses=$courses->where('course_type','<>','3');	
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
			    
			$courses = $courses->where('course_type','LIKE','%'.$request->input('search.course_type').'%');
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
				$action .='<a href="/admin/course/edit/'.base64_encode($course->id).'" title="Edit Course Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_course_page') ){
				$action .='<a href="javascript:courseController.delete('.$course->id.')" title="Delete Course Content" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
				if($course->subcategory){
					$subcategory = SubCategory::where('id',$course->subcategory)->first();
					if($subcategory){
					    if($subcategory->course_image){
				$vimage= json_decode($subcategory->course_image); 
				$image='<img src="'.asset($vimage['course_image']['src']).'" type="'.$vimage['course_image']['alt'].'" width="100">'; 
					    }else{
					        $image="";
					        
					    }
				}
				}else{
					$image="";
				}
				$status="";
				if($course->status=='1'){
				$status .='<a href="javascript:courseController.status('.$course->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:courseController.status('.$course->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
				}
				
				
				if($course->course_type=='1'){
					$course_type= "Course Type 1";
				}else if($course->course_type=='2'){
					$course_type= "Course Type 2";
				}else{
					$course_type= "";
				}
				
				if($course->seo_page=='1'){
					$seo_page="checked";					
				}else{
					$seo_page="";
				}
				
				
					$data[] = [	
					    "<th><input type='checkbox' class='seo-visible' data-bid='$course->id' value='$course->seo_page' $seo_page></th>",
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
		return redirect('admin/course/edit/'.base64_encode($id))->with("success","Icons deleted successfully.");
			
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
		return redirect('admin/course/edit/'.base64_encode($id))->with("success","image deleted successfully.");
			
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
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
		 public function courseContentDelete(Request $request,$id){
		  
		  
		  
			$coursesHeading = CourseCurriculumExcel::where('course_id',$id)->get();	
 //echo "<pre>";print_r($coursesHeading);die;
			if(count($coursesHeading)>0){
				 
				foreach($coursesHeading as $heading){					 
						$coursesContent = CourseCurriculumExcel::where('heading_id',$heading->id)->get();
						if(count($coursesContent)>0){
							foreach($coursesContent as $content){
								$coursesSubContent = CourseCurriculumExcel::where('content_id',$content->id)->get();
								if(count($coursesSubContent)>0){
									foreach($coursesSubContent as $subcontent){										
										$coursesLastContent = CourseCurriculumExcel::where('subcontent_id',$subcontent->id)->get();
										if(count($coursesLastContent)>0){
											foreach($coursesLastContent as $lastContent){
												$deleteLastContent = CourseCurriculumExcel::where('id',$lastContent->id)->delete();
												$deleteendContent = CourseCurriculumExcel::where('endcontent_id',$lastContent->id)->delete();
												$delsubcontent  =CourseCurriculumExcel::where('id',$subcontent->id)->delete();
												$delcontent  =CourseCurriculumExcel::where('id',$content->id)->delete();
												$delheading  =CourseCurriculumExcel::where('id',$heading->id)->delete();
												$status=1;
												$error=200;
												$msg="Course Content Deleted Successfully !";
											}
										}else{											
											$delsubcontent  =CourseCurriculumExcel::where('id',$subcontent->id)->delete();
											$delcontent  =CourseCurriculumExcel::where('id',$content->id)->delete();
											$delheading  =CourseCurriculumExcel::where('id',$heading->id)->delete();
											$status=1;
											$error=200;
											$msg="Course Content Deleted Successfully !";											
										}										
									}									
								}else{
									$delcontent  =CourseCurriculumExcel::where('id',$content->id)->delete();
									$delheading  =CourseCurriculumExcel::where('id',$heading->id)->delete();	
									$status=1;
									$error=200;
									$msg="Course Content Deleted Successfully !";
								}								
							}							
						}else{
							$delheading  =CourseCurriculumExcel::where('id',$heading->id)->delete();	
							$status=1;
							$error=200;
							$msg="Course Content Deleted Successfully !";
						}							
				}
				
									 
			
			}else{	 		
				$error=404;
				$status=0;
				$msg="Not Record found!";				
			}
		 return response()->json(['status'=>$status,'msg'=>$msg],200);
	}
	 
 
	 public function courseContentDeletedd(Request $request,$id){
		  
			$coursesHeading = CoursesHeading::where('course_id',$id)->get();	
 
			if(count($coursesHeading)>0){
				 
				foreach($coursesHeading as $heading){					 
						$coursesContent = MasterCurriculumExcel::where('heading_id',$heading->id)->get();
						if(count($coursesContent)>0){
							foreach($coursesContent as $content){
								$coursesSubContent = MasterCurriculumExcel::where('content_id',$content->id)->get();
								if(count($coursesSubContent)>0){
									foreach($coursesSubContent as $subcontent){										
										$coursesLastContent = MasterCurriculumExcel::where('subcontent_id',$subcontent->id)->get();
										if(count($coursesLastContent)>0){
											foreach($coursesLastContent as $lastContent){
												$deleteLastContent = MasterCurriculumExcel::where('id',$lastContent->id)->delete();
												$deleteendContent = MasterCurriculumExcel::where('endcontent_id',$lastContent->id)->delete();
												$delsubcontent  =MasterCurriculumExcel::where('id',$subcontent->id)->delete();
												$delcontent  =MasterCurriculumExcel::where('id',$content->id)->delete();
												$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();
												$status=1;
												$error=200;
												$msg="Course Content Deleted Successfully !";
											}
										}else{											
											$delsubcontent  =MasterCurriculumExcel::where('id',$subcontent->id)->delete();
											$delcontent  =MasterCurriculumExcel::where('id',$content->id)->delete();
											$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();
											$status=1;
											$error=200;
											$msg="Course Content Deleted Successfully !";											
										}										
									}									
								}else{
									$delcontent  =MasterCurriculumExcel::where('id',$content->id)->delete();
									$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();	
									$status=1;
									$error=200;
									$msg="Course Content Deleted Successfully !";
								}								
							}							
						}else{
							$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();	
							$status=1;
							$error=200;
							$msg="Course Content Deleted Successfully !";
						}							
				}
				
									 
			
			}else{	 		
				$error=404;
				$status=0;
				$msg="Not Record found!";				
			}
		 return response()->json(['status'=>$status,'msg'=>$msg],200);
	}
	 
 
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
 
	 public function courseAboutExcelDelete(Request $request,$id){
		  
			$courseAboutHeading = CourseAboutExcel::where('course_id',$id)->get();	

			if(count($courseAboutHeading)>0){
				 
				foreach($courseAboutHeading as $heading){					 
						$courseAboutLevel1 = CourseAboutExcel::where('heading_id',$heading->id)->get();
						if(count($courseAboutLevel1)>0){
							foreach($courseAboutLevel1 as $content){
								$courseAboutLevel2 = CourseAboutExcel::where('content_id',$content->id)->get();
								if(count($courseAboutLevel2)>0){
									foreach($courseAboutLevel2 as $subcontent){										
										$courseAboutLevel3 = CourseAboutExcel::where('subcontent_id',$subcontent->id)->get();
										if(count($courseAboutLevel3)>0){
											foreach($courseAboutLevel3 as $lastContent){
												$deleteLastContent = CourseAboutExcel::where('id',$lastContent->id)->delete();
												$deleteendContent = CourseAboutExcel::where('endcontent_id',$lastContent->id)->delete();
												$delsubcontent  =CourseAboutExcel::where('id',$subcontent->id)->delete();
												$delcontent  =CourseAboutExcel::where('id',$content->id)->delete();
												$delheading  =CourseAboutExcel::where('id',$heading->id)->delete();
												$status=1;
												$error=200;
												$msg="Course About Deleted Successfully !";
											}
										}else{											
											$delsubcontent  =CourseAboutExcel::where('id',$subcontent->id)->delete();
											$delcontent  =CourseAboutExcel::where('id',$content->id)->delete();
											$delheading  =CourseAboutExcel::where('id',$heading->id)->delete();
											$status=1;
											$error=200;
											$msg="Course About Deleted Successfully!";											
										}										
									}									
								}else{
									$delcontent  =CourseAboutExcel::where('id',$content->id)->delete();
									$delheading  =CourseAboutExcel::where('id',$heading->id)->delete();	
									$status=1;
									$error=200;
									$msg="Course About Deleted Successfully!";
								}								
							}							
						}else{
							$delheading  =CourseAboutExcel::where('id',$heading->id)->delete();	
							$status=1;
							$error=200;
							$msg="Course About Deleted Successfully!";
						}							
				}
				
									 
			
			}else{	 		
				$error=404;
				$status=0;
				$msg="Not Record found!";				
			}
		 return response()->json(['status'=>$status,'msg'=>$msg],200);
	}
	 
 
	  
	  /* dowload excel formate add lead */
	  public function downloadExcelFormate_old(request $request){
		 
		  $arr[] = [
						"Heading"=>'',
						"Level1"=>'',
						"Level2"=>'',
						"Level3"=>'',			 
						 
					];		

/* 
header('Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0'); 

	header('Pragma: no-cache'); 

	header('Content-Type: application/x-msexcel; format=attachment;'); 

	header('Content-Disposition: attachment; filename=Fees_File_'.date('d-m-Y H:i:s').'.xls');  */
 /* 
		 	 $excel = \App::make('excel');
			 
			Excel::create('add_demos_'.date('Y-m-d H:i a'), function($excel) use($arr) {
				$excel->sheet('Sheet 1', function($sheet) use($arr) {
					$sheet->fromArray($arr);
				});
			})->download('xls');    */
			//return (new excelFormateExport)->download('invoices.xlsx', \Maatwebsite\Excel\Excel::XLSX);
			//return Excel::download(new excelFormateExport, 'employee_dashboard_'.date('d-m_H:i:s').'.xls');
		  
	  } 
			  
		/**
		 * Download a blank CSV template for bulk lead import.
		 */
		public function downloadExcelFormate(Request $request): StreamedResponse
		{
			$columns = ['Heading', 'Level1', 'Level2', 'Level3'];

				$filename = 'course_curriculum_' . date('Y-m-d-h-s-i') . '.csv';

			$headers = [
				'Content-Type'        => 'text/csv',
				'Content-Disposition' => "attachment; filename=\"{$filename}\"",
				'Pragma'               => 'no-cache',
				'Cache-Control'        => 'must-revalidate, post-check=0, pre-check=0',
				'Expires'              => '0',
			];

			$callback = function () use ($columns) {
				$file = fopen('php://output', 'w');

				// Write header row
				fputcsv($file, $columns);

				// One blank example row so users see the expected structure
				fputcsv($file, array_fill(0, count($columns), ''));

				fclose($file);
			};

			return response()->stream($callback, 200, $headers);
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
	seovisible
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function seovisible(Request $request)
    {	  

        if($request->ajax()){ 		
		  
			$course_id= $request->input('course_id');				
			$courses = Course::findOrFail($course_id);	 
			$courses->seo_page = $request->input('visib');
			 		
			if($courses->save()){
				$status=1;							 
				$msg="SEO Course Change Successfully !";		
				
			}else{
				$status=0;							 
				$msg="SEO Course could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
	
	
	
	/* Select subcategory wise show of course module onlu type 1
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCourseMadul(Request $request)
    {	  
		$sid = $request->input('sid');  
		
 
		$cid = $request->input('cid'); 	
    	$subcategory_data= DB::table('web_courses as course');	 		
		$subcategory_data= $subcategory_data->select('course.*','course.id as courseid');	 
		$subcategory_data= $subcategory_data->where('course.category','=',$sid);	 
		$subcategory_data= $subcategory_data->where('course.course_type','=',1);	 
		$subcategory_data= $subcategory_data->where('course.status',1)->get();				
		
		$related_courses_list=array();
		if(!empty($subcategory_data)){	
		foreach($subcategory_data as $courses_list){
		array_push($related_courses_list,$courses_list->courseid);		 
		}		
		}else{
		$related_courses_list=array();
		}
		
		
		$related_courses= DB::table('web_courses as course');	 		
		$related_courses= $related_courses->select('course.*','course.id as courseid');	 		 
		$related_courses= $related_courses->where('course.course_type','=',1);	 
		$related_courses= $related_courses->where('course.status',1)->get();
		 
	 
		
		if(!empty($related_courses) && count($related_courses)>0){ 
		foreach($related_courses as $subcategory){ 
		if(in_array($subcategory->courseid,$related_courses_list)){			 
			echo'<option value="'.$subcategory->courseid.'" selected>'.$subcategory->title.'</option>';		
		 }else{
			echo'<option value="'.$subcategory->courseid.'" >'.$subcategory->title.'</option>';
		}
		 
		
		
		
		}
		}else{ 
		echo'<option value="">No record found</option>';
		}
		
		
		
    } 
    
    
    /** Select subcategory wise show of course module onlu type 1
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCourseMadulEdit(Request $request)
    {	 
	
		//echo "<pre>";print_r($_GET);die;
		$cid = $request->input('cid');  		 
		$cm = $request->input('cm'); 		
		$subcategory_data= DB::table('web_courses as course');	 		
		$subcategory_data= $subcategory_data->select('course.*','course.id as courseid');	 
		$subcategory_data= $subcategory_data->where('course.category','=',$cid);	 
		$subcategory_data= $subcategory_data->where('course.course_type','=',1);	 
		$subcategory_data= $subcategory_data->where('course.status',1)->get();
		
		//echo "<pre>";print_r($subcategory_data);die;
		/* if(!empty($subcategory_data) && count($subcategory_data)>0){ 
		foreach($subcategory_data as $subcategory){ 
		$selected = ($cid==$subcategory->courseid)?"selected":'';
		echo'<option value="'.$subcategory->courseid.'" '.$selected.'>'.$subcategory->title.'</option>';
		}
		} else { 
		echo'<option value="">No record found</option>';
		}
		 */
		
		if(!empty($cm)){	
		$related_courses = json_decode($cm);	
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
 /** Select subcategory wise show of course module onlu type 1
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCourseReletedEdit(Request $request)
    {	 
	
	 
		$cid = $request->input('cid');  		 
		$cr = $request->input('cr'); 		
		$subcategory_data= DB::table('web_courses as course');	 		
		$subcategory_data= $subcategory_data->select('course.*','course.id as courseid');	 
	//	$subcategory_data= $subcategory_data->where('course.category','=',$cid);	 
		$subcategory_data= $subcategory_data->where('course.course_type','=',1);	 
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
