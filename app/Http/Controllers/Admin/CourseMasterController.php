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
use App\CoursesMaster;
use App\CourseCity;
use App\Models\Category;
use App\Models\SubCategory;
use App\Helpers;
use App\Models\ToolsCovered;
use App\Client;
use App\MasterCurriculumExcel;
class CourseMasterController extends Controller
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
	
        return view('admin.course_master.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {	  
		$course_list= Course::select('id','title')->get();
		$cetegories= DB::table('web_coursepdf as pdf');		 
		$cetegories  =$cetegories->join('web_categories as category','pdf.category','=','category.id','left');
		$cetegories= $cetegories->select('pdf.*','category.id as categoryid','category.category as categoryname');
		$cetegories= $cetegories->groupby('pdf.category');
		$cetegories= $cetegories->orderBy('category.category');
		$cetegories= $cetegories->where('pdf.status',1)->get();
		$citys= CourseCity::orderBy('city','asc')->get();
		//echo "<pre>";print_r($cetegories);die;
        return view('admin.course_master.add_master',['course_list'=>$course_list,'citys'=>$citys,'cetegories'=>$cetegories]);
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCourseMasterTitle(Request $request)
    {	  
	
        if($request->ajax()){ 
		// echo "<pre>";print_r($_POST);die;
			
  
		  $validator = Validator::make($request->all(),[				 
				'title'=>'required|unique:web_coursemaster,title|min:10|max:75',
				'sub_title'=>'required|min:10|max:48',				 
				'course_name'=>'required|string|regex:/^[\pL\s\-]+$/u|min:3|max:32',				 
			//	'meta_keyword'=>'required|min:20|max:160',	
				'meta_description'=>'required|min:10|max:160',
				'category'=>'required',
				'subcategory'=>'required',
				'course_pdf_text'=>'required',
				'rating'=>'required',
				'total_rating'=>'required',
				'course_duration'=>'required',
			//	'live_project'=>'required',
				'fees'=>'required',
				'course_description'=>'required|min:10|max:200',	
				 
				
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
		$citycourse = $request->input('citycourse');	
	 	
		if(!empty($citycourse)){
			 
				 			
				
				
			for($i=0; $i<count($citycourse); $i++){
			// GENERATING SLUG			 
			$business_slug = NULL;
			$business_slug = $this->generate_slug(str_replace('?','',$request->input('title')).' in '.$citycourse[$i]);
			if(is_null($business_slug)){
			return redirect("/admin/coursemaster/add");

			}
			$slugExists = DB::table('web_coursemaster')
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
				$courses = New CourseMaster;
				$courses->title = ucfirst($request->input('title'));	
				$courses->sub_title = ucfirst($request->input('sub_title'));	
				$courses->slug  =$business_slug;				
				$courses->course_name = ucfirst($request->input('course_name'));
				$courses->category = trim($request->input('category'));
				$courses->subcategory = trim($request->input('subcategory'));
				$courses->course_pdf_text = trim($request->input('course_pdf_text'));
				$courses->rating = $request->input('rating');
				$courses->total_rating = $request->input('total_rating');	
				$courses->course_duration = $request->input('course_duration');	
			//	$courses->live_project = $request->input('live_project');	
				$courses->fees = $request->input('fees');
				$courses->meta_keyword = ucfirst($request->input('meta_keyword'));	
				$courses->meta_description = ucfirst($request->input('meta_description'));	
				$courses->course_description = ucfirst($request->input('course_description'));				 			
				$courses->status = '1';				 
				$courses->created_by =1;	
				$courses->save();				
				$add= 1;
			}
 		}else{			

			// GENERATING SLUG
			// ***************
			$business_slug = NULL;
			$business_slug = $this->generate_slug(str_replace('?','',$request->input('title')));
			if(is_null($business_slug)){
			return redirect("/admin/coursemaster/add");

			}
			$slugExists = DB::table('web_coursemaster')
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



				 
				$courses = New CourseMaster;
				$courses->title = ucfirst($request->input('title'));	
				$courses->sub_title = ucfirst($request->input('sub_title'));	
				$courses->slug  = $business_slug;				
				$courses->course_name = ucfirst($request->input('course_name'));
				$courses->category = trim($request->input('category'));
				$courses->subcategory = trim($request->input('subcategory'));
				$courses->course_pdf_text = trim($request->input('course_pdf_text'));
				$courses->rating = $request->input('rating');
				$courses->total_rating = $request->input('total_rating');
				$courses->course_duration = $request->input('course_duration');	
			//	$courses->live_project = $request->input('live_project');	
				$courses->fees = $request->input('fees');
				$courses->meta_keyword = ucfirst($request->input('meta_keyword'));	
				$courses->meta_description = ucfirst($request->input('meta_description'));	
				$courses->course_description = ucfirst($request->input('course_description'));	  			
				$courses->status = '1';				 
				$courses->created_by =1;	
				$courses->save();
				//echo "<pre>";print_r($courses);die;
				$add= 1;
			
			
		}
			if(!empty($add)){
				$status=1;							 
				$msg="Course master submitted successfully!";	
				//return redirect("/admin/coursemaster");
			}else{
				$status=0;							 
				$msg="Course master could not be submitted!";	
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
     
       public function editSaveCourseCurriculumExcel(Request $request,$id)
    {			
		if($request->isMethod('post')){	

				$validator = Validator::make($request->all(),[				 
				'course_about'=>'required',
				]);
				if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
				}
			 
			$allowedFileType = [		 
			'text/csv',	
			'application/vnd.ms-excel',			
			];
		 	if (in_array($_FILES["course_about"]["type"], $allowedFileType)) {
				$coursesexcel = CoursesMaster::findOrFail($id);			 
			if($request->hasFile('course_about')){
				$filePath = "excell";
				$file =  $request->file('course_about');
				$filename =str_replace(' ', '_', trim($file->getClientOriginalName()));			 
				$destinationPath = public_path($filePath); 			
				if(file_exists($destinationPath.'/'.$filename)){
					$filename = $filename;
				}
				$file->move($destinationPath,$filename);	
				$fileTextName= str_replace(' ', '_', trim($file->getClientOriginalName()));
				$coursesexcel->coursemasterexcel = $fileTextName;	

				$csvFile = fopen($destinationPath.'/'.$filename, 'r');
				fgetcsv($csvFile);
				$i=0;
				while(($row = fgetcsv($csvFile)) !== FALSE){ 
			 
				$heading = trim($row[0]);				
				if ($heading !="") {				 
						$courseAboutHeading  = New MasterCurriculumExcel;
						$courseAboutHeading->course_id = $id;
						$courseAboutHeading->heading = trim(str_replace('?','',$heading));
						$courseAboutHeading->save();
						$add= 1;
					}else if($heading==""){
						$level1 = trim($row[1]); 
						if($level1 !=""){

							$courseAboutLevel1  = New MasterCurriculumExcel;	 
							$courseAboutLevel1->heading_id = $courseAboutHeading->id;
							$courseAboutLevel1->level1 = trim(str_replace('?','',$level1));
							$courseAboutLevel1->save();
							$add= 1;	
							}else if($level1==""){
								$level2 = trim($row[2]);
								if($level2 !=""){				
								$courseAboutLevel2  = New MasterCurriculumExcel;	 
								$courseAboutLevel2->level1_id = $courseAboutLevel1->id;
								$courseAboutLevel2->level2 = trim(str_replace('?','',$level2));						
								$courseAboutLevel2->save();
								$add= 1;

								}else if($level2==""){
									$level3 = trim($row[3]);
									if($level3 !=""){					
										$courseAboutLevel3  = New MasterCurriculumExcel;	 
										$courseAboutLevel3->level2_id = $courseAboutLevel2->id;
										$courseAboutLevel3->level3 = trim(str_replace('?','',$level3));						 
										if($courseAboutLevel3->save()){
											$add= 1;
										}				 

									}else if($level3==""){
										$level4 = trim($row[4]);
										if($level4 !=""){					
											$courseAboutLevel4  = New MasterCurriculumExcel;	 
											$courseAboutLevel4->level3_id = $courseAboutLevel3->id;
											$courseAboutLevel4->level4 = trim(str_replace('?','',$level4));						 
											if($courseAboutLevel4->save()){
												$add= 1;
											}				 

									}else if($level4==""){
										$level5 = trim($row[5]);
										if($level5 !=""){					
											$courseAboutLevel5  = New MasterCurriculumExcel;	 
											$courseAboutLevel5->level4_id = $courseAboutLevel4->id;
											$courseAboutLevel5->level5 = trim(str_replace('?','',$level5));						 
											if($courseAboutLevel5->save()){
												$add= 1;
											}				 

										}else if($level5==""){
											$level6 = trim($row[6]);
											if($level6 !=""){					
												$courseAboutLevel6  = New MasterCurriculumExcel;	 
												$courseAboutLevel6->level5_id = $courseAboutLevel5->id;
												$courseAboutLevel6->level6 = trim(str_replace('?','',$level6));						 
												if($courseAboutLevel6->save()){
													$add= 1;
												}				 

											}else if($level6==""){
												$level7 =trim($row[7]);
												if($level7 !=""){					
													$courseAboutLevel7  = New MasterCurriculumExcel;	 
													$courseAboutLevel7->level6_id = $courseAboutLevel6->id;
													$courseAboutLevel7->level7 = trim(str_replace('?','',$level7));						 
														if($courseAboutLevel7->save()){
														$add= 1;
														}	
												}
											}
										} 
									}

								}  
							}
						}	 
				
					} 
				}						
			}else{
				$coursesexcel->coursemasterexcel = $coursesexcel->coursemasterexcel;	
			} 				 	 				 								
			$coursesexcel->save(); 
				
				
			}
		 
		 
			 
			
			if(!empty($add)){
				$status=1;							 
				$msg="Course about submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Course about could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
				
			
		}
		
	}
	
     
     
     
     
     
    public function editSaveCourseCurriculumExcelold(Request $request,$id)
    {			
		if($request->isMethod('post') )		
//echo "<pre>";print_r($_POST);die;
				$validator = Validator::make($request->all(),[				 
				'course_about'=>'required',
				]);
				if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
				}
					
					
			$allowedFileType = [
			'application/vnd.ms-excel',
			'text/xls',
			'text/xlsx',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			];
		 
			if (in_array($_FILES["course_about"]["type"], $allowedFileType)) {				 
				$targetPath = $_FILES["course_about"]["tmp_name"];				 
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);		 
			$spreadsheet->setActiveSheetIndex(0);
			$sheet = $spreadsheet->getActiveSheet();
			$highestColumn =$sheet->getHighestRow();
	 
			for($row=2; $row<=$highestColumn; $row++)
			{			 
				$heading = $sheet->getCell('A'.$row)->getValue();	
				 
				
				 if($heading !=""){				 
				$courseAboutHeading  = New MasterCurriculumExcel;
				$courseAboutHeading->course_id = $id;
				$courseAboutHeading->heading = str_replace('?','',$heading);
				$courseAboutHeading->save();
				 $add= 1;
				}else if($heading==""){
					$level1 = $sheet->getCell('B'.$row)->getValue(); 
					if($level1 !=""){
				 
						$courseAboutLevel1  = New MasterCurriculumExcel;	 
						$courseAboutLevel1->heading_id = $courseAboutHeading->id;
						$courseAboutLevel1->coursescontent = str_replace('?','',$level1);
						$courseAboutLevel1->save();
						$add= 1;	
					}else if($level1==""){
					$level2 = $sheet->getCell('C'. $row)->getValue();
					if($level2 !=""){				
						$courseAboutLevel2  = New MasterCurriculumExcel;	 
						$courseAboutLevel2->content_id = $courseAboutLevel1->id;
						$courseAboutLevel2->subcontent = str_replace('?','',$level2);						
						$courseAboutLevel2->save();
						$add= 1;
					
					}else if($level2==""){
					$level3 = $sheet->getCell('D'.$row)->getValue();
					if($level3 !=""){					
						$courseAboutLevel3  = New MasterCurriculumExcel;	 
						$courseAboutLevel3->subcontent_id = $courseAboutLevel2->id;
						$courseAboutLevel3->lastcontent = str_replace('?','',$level3);						 
						if($courseAboutLevel3->save()){
							$add= 1;
						}				 
					
					}else if($level3==""){
					$level4 = $sheet->getCell('E'.$row)->getValue();
					if($level4 !=""){					
						$courseAboutLevel4  = New MasterCurriculumExcel;	 
						$courseAboutLevel4->endcontent_id = $courseAboutLevel3->id;
						$courseAboutLevel4->endcontent = str_replace('?','',$level4);						 
						if($courseAboutLevel4->save()){
							$add= 1;
						}				 
					
					}
					}else if($level4==""){
					$level5 = $sheet->getCell('F'.$row)->getValue();
					if($level5 !=""){					
						$courseAboutLevel5  = New MasterCurriculumExcel;	 
						$courseAboutLevel5->endcontent_id = $courseAboutLevel4->id;
						$courseAboutLevel5->lastlevel = str_replace('?','',$level5);						 
						if($courseAboutLevel5->save()){
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
				$status=1;							 
				$msg="Course about submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Course about could not be submitted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
				
			
		}	 
	

	/**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseMasterTitle(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
	 
			
  
		  $validator = Validator::make($request->all(),[				 
		    	'title' => 'required|min:10|max:75|unique:web_coursemaster,title,'.$id.',id',	
				'sub_title'=>'required|min:10|max:45',
		    	'slug' => 'required|unique:web_coursemaster,slug,'.$id.',id',
				'course_name'=>'required|string|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'rating'=>'required',
				'total_rating'=>'required',				 	
				'category'=>'required',	
				'subcategory'=>'required',	
				'course_pdf_text'=>'required',	
					'fees'=>'required|numeric',		
			//	'meta_keyword'=>'required|min:20|max:160',	
				'meta_description'=>'required|min:10|max:160',
				'course_description'=>'required|min:10|max:200',
				 				
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				$updatemaster = array(
	 'title'=>ucfirst($request->input('title')),
	 'sub_title'=>ucfirst($request->input('sub_title')),
	 'slug'=>$this->generate_slug(trim(str_replace('?','',$request->input('slug')))),	
	 'course_name'=>ucfirst($request->input('course_name')),
	 'category'=>trim($request->input('category')),
	 'subcategory'=>trim($request->input('subcategory')),
	 'course_pdf_text'=>trim($request->input('course_pdf_text')),
	 'fees'=>trim($request->input('fees')),
	 'rating'=>trim($request->input('rating')),
	 'total_rating'=>trim($request->input('total_rating')),
	 'course_duration'=>trim($request->input('course_duration')),
	 'meta_keyword'=>ucfirst($request->input('meta_keyword')),
	 'meta_description'=>ucfirst($request->input('meta_description')),
	 'course_description'=>ucfirst($request->input('course_description')),
	 'salary_heading'=>trim($request->input('salary_heading')),
	 'salary_details'=>trim($request->input('salary_details')),
	 'job_heading'=>trim($request->input('job_heading')),
	 'job_details'=>trim($request->input('job_details')),
	 'analytics_heading'=>trim($request->input('analytics_heading')),
	 'analytics_details'=>trim($request->input('analytics_details')),
	 'updated_by'=>Auth()->user()->id,
	 );
	 
 
	 $update  =DB::table('web_coursemaster')->where('id',$id)->update($updatemaster);		
 	 
			if(!empty($update)){
				$status=1;							 
				$msg="Course master title updated successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course master title could not be updated!";	
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
    public function editSaveCourseMasterAbout(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
	//	echo "<pre>";print_r($_POST);die;  
		  $validator = Validator::make($request->all(),[				 
				'course_heading1'=>'required',				 				
				'course_heading_details1'=>'required',	
				'course_heading2'=>'required',				 				
				'course_heading_details2'=>'required',
				'course_heading3'=>'required',				 				
				'course_heading_details3'=>'required',
				'course_heading4'=>'required',				 				
				'course_heading_details4'=>'required',				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}				 
		 
		 
		  if(!empty($request->input('paragraph'))){
				 $paragraph = serialize($request->input('paragraph'));
				 
			 }else{
				 $paragraph="";
			 }
			  if(!empty($request->input('masterparagraph'))){
				 $masterparagraph = serialize($request->input('masterparagraph'));
				 
			 }else{
				 $masterparagraph="";
			 }
			    
			    $course_heading =array(
			        'paragraph'=>$paragraph,
				'masterparagraph'=>$masterparagraph,
			'course_heading1'=>$request->input('course_heading1'),
			'course_heading_details1'=>$request->input('course_heading_details1'),
			'course_heading2'=>$request->input('course_heading2'),
			'course_heading_details2'=>$request->input('course_heading_details2'),
			'course_heading3'=>$request->input('course_heading3'),
			'course_heading_details3'=>$request->input('course_heading_details3'),			
			'course_heading4'=>$request->input('course_heading4'),
			'course_heading_details4'=>$request->input('course_heading_details4'),			
			'course_heading5'=>$request->input('course_heading5'),
			'course_heading_details5'=>$request->input('course_heading_details5'),
			'professionals'=>$request->input('professionals'),
			'beginners'=>$request->input('beginners'),
			'polygon'=>$request->input('polygon'),
			'scope'=>$request->input('scope'),
			'growth'=>$request->input('growth'),
			'analytic'=>$request->input('analytic'),
			'structure'=>$request->input('structure'),
			);
				 
			$update  =DB::table('web_coursemaster')->where('id',$id)->update($course_heading);
			
			
			if(!empty($update)){
				$status=1;							 
				$msg="Course master about submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course master about could not be submitted!";	
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
    public function editSaveCourseMasterPlacement(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		//echo "<pre>";print_r($_POST);die;  
		  $validator = Validator::make($request->all(),[				 
				'careers_salaries'=>'required',				 				
				
				'placement1'=>'required',				 				
				'placement_details1'=>'required',
				'placement2'=>'required',				 				
				'placement_details2'=>'required',
				'placement3'=>'required',				 				
				'placement_details3'=>'required',
				'placement4'=>'required',				 				
				'placement_details4'=>'required',
				'placement5'=>'required',				 				
				'placement_details5'=>'required',
				
				/* 'placement6'=>'required',				 				
				'placement_details6'=>'required',
				'placement7'=>'required',				 				
				'placement_details7'=>'required',				
				'placement8'=>'required',				 				
				'placement_details8'=>'required',	 */

				 			 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}				
				$courses = CoursesMaster::findOrFail($id);
				
				$courses->careers_salaries = $request->input('careers_salaries');					 			 			 
				
				$courses->placement1 = $request->input('placement1');				 			 			 
				$courses->placement_details1 = $request->input('placement_details1');	
				
 	             $courses->placement2 = $request->input('placement2');				 			 			 
				$courses->placement_details2 = $request->input('placement_details2');		
				
 	             $courses->placement3 = $request->input('placement3');				 			 			 
				$courses->placement_details3 = $request->input('placement_details3');		
 	             $courses->placement4= $request->input('placement4');				 			 			 
				$courses->placement_details4 = $request->input('placement_details4');		
 	             $courses->placement5 = $request->input('placement5');				 			 			 
				$courses->placement_details5 = $request->input('placement_details5');		
 	             $courses->placement6 = $request->input('placement6');				 			 			 
				$courses->placement_details6 = $request->input('placement_details6');		
 	             $courses->placement7 = $request->input('placement7');				 			 			 
				$courses->placement_details7 = $request->input('placement_details7');		
 	             
				$courses->placement8 = $request->input('placement8');				 			 			 
				$courses->placement_details8 = $request->input('placement_details8');		
 	

            //echo "<pre>";print_r($courses);die;
				
				$courses->updated_by =1;		
				 
 		
			if($courses->save()){
				$status=1;							 
				$msg="Placement & Recruitment submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Placement & Recruitment could not be updated!";	
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
    public function editSaveCourseMasterRelated(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		//echo "<pre>";print_r($_POST);die;
			
  
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
					 $related_courses_side=serialize($request->input('related_courses_side'));
					 
				 }else{
					 $related_courses_side="";
				 }			 
				 
				 if(!empty($request->input('related_certifications'))){
					 $related_certifications=serialize($request->input('related_certifications'));
					 
				 }else{
					 $related_certifications="";
				 }
				 
				if(!empty($request->input('related_courses'))){
					 $related_courses=serialize($request->input('related_courses'));					 
				 }else{
					 $related_courses="";
				 }
				
			$courses = CoursesMaster::findOrFail($id);
			$courses->related_courses_side =$related_courses_side;					 			 			 
			$courses->related_certifications = $related_certifications;
			$courses->related_courses = $related_courses;				
			$courses->show_certification_tab = $request->input('show_certification_tab');				 			 			 
			$courses->show_front_page = $request->input('show_front_page');					 			 			 
					 			 			 
				$courses->updated_by =1;		
 		
			if($courses->save()){
				$status=1;							 
				$msg="Course master related submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course master related could not be updated!";	
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
	
        if($request->ajax()){ 			
   
		  $validator = Validator::make($request->all(),[				 
				'faqq'=>'required',
				'faqa'=>'required',				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	
	
			$courses = CoursesMaster::findOrFail($id);
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
				$msg="Course master FAQs submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course masted FAQs could not be updated!";	
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
    public function editSaveTestimonial(Request $request,$id)
    {	  
	
        if($request->ajax()){ 		
		 $validator = Validator::make($request->all(),[				 
				'name'=>'required',
				'comment'=>'required',
				'testimonial_visibility'=>'required',
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}

				
			$courses = CoursesMaster::findOrFail($id);
			if(!empty($request->input('name'))){
				$name= serialize($request->input('name'));
			}else{
				$name="";
			}
			
			if(!empty($request->input('comment'))){
				$comment= serialize($request->input('comment'));
			}else{
				$comment="";
			}
			
			$testimonial= array(
			'name'=>$name,
			'comment'=>$comment
			);
		 
			$courses->testimonial = $testimonial;	
			$courses->testimonial_visibility = $request->input('testimonial_visibility');
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
	
  
	/**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseToolsCovered(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		//echo "<pre>";print_r($_POST);die;		
  
		  $validator = Validator::make($request->all(),[				 
		 
				'tools_covered'=>'required',			 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				  if(!empty($request->input('tools_covered'))){
					 $tools_covered=serialize($request->input('tools_covered'));
					 
				 }else{
					 $tools_covered="";
				 }
				 
				 $tools_covered =array('tools_covered'=>$tools_covered);
				//echo "<pre>";print_r($tools_covered);die;
			 	$updated =DB::table('web_coursemaster')->where('id',$id)->update($tools_covered);
 		
			if(!empty($updated)){
				$status=1;							 
				$msg="Course master tools covered submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course master tools covered could not be updated!";	
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
    public function editSaveCourseClients(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		//echo "<pre>";print_r($_POST);die;		
  
		  $validator = Validator::make($request->all(),[				 
		 
				'clients'=>'required',			 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				  if(!empty($request->input('clients'))){
					 $clients=serialize($request->input('clients'));
					 
				 }else{
					 $clients="";
				 }
				 
				 $update_clients =array('clients'=>$clients);
				//echo "<pre>";print_r($update_clients);die;
			 	$updated =DB::table('web_coursemaster')->where('id',$id)->update($update_clients);
 		
			if(!empty($updated)){
				$status=1;							 
				$msg="Course master Client submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course master Client could not be updated!";	
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
    public function editSaveCourseStructure(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		//echo "<pre>";print_r($_POST);die;		
  
		  $validator = Validator::make($request->all(),[				 
		 
				'duration_hours'=>'required|numeric',			 				
				'assigment'=>'required|numeric',			 				
				'project'=>'required|numeric',			 				
				'live_project'=>'required|numeric',			 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}
				 $duration_hours= $request->input('duration_hours');
				 $assigment= $request->input('assigment');
				 $project= $request->input('project');
				 $live_project= $request->input('live_project');
				 $course_structure =array('duration_hours'=>$duration_hours,'assigment'=>$assigment,'project'=>$project,'live_project'=>$live_project);
				//echo "<pre>";print_r($course_structure);die;
			 	$updated =DB::table('web_coursemaster')->where('id',$id)->update($course_structure);
 		 
			if(!empty($updated)){
				$status=1;							 
				$msg="Master course structure submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Master course structure could not be submitted!";	
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
		$edit_data= CoursesMaster::findOrFail(base64_decode($id));
		
		$cetegories= DB::table('web_coursepdf as pdf');		 
		$cetegories  =$cetegories->join('web_categories as category','pdf.category','=','category.id','left');
		$cetegories= $cetegories->select('pdf.*','category.id as categoryid','category.category as categoryname');
		$cetegories= $cetegories->groupby('pdf.category');
		$cetegories= $cetegories->orderBy('category.category');
		$cetegories= $cetegories->where('pdf.status',1)->get();
		
		$course_list= Course::select('id','title')->get();
        $tools_covered_list= ToolsCovered::select('id','name')->where('status',1)->get();
          $client_list= Client::select('id','name')->where('status',1)->get();
        $course_curriculum = MasterCurriculumExcel::where('course_id',base64_decode($id))->get();	
        return view('admin.course_master.edit_master',['edit_data'=>$edit_data,'course_list'=>$course_list,'client_list'=>$client_list,'cetegories'=>$cetegories,'tools_covered_list'=>$tools_covered_list,'course_curriculum'=>$course_curriculum]);
    } 
	
 
	// GET  Course pagination
	public function getCourseMasterPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$courses= 	CoursesMaster::orderBy('id','DESC');		 
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
				 $image="";
				 	if($course->status=='1'){
				$action .='<a href="/master-program/'.$course->slug.'" title="View Course Content" class="btn btn-primary" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>';	
				 	}else{
				 	    
				 	    	$action .='<a href="/master-preview/'.$course->slug.'" title="View Course Content" class="btn btn-primary" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>';	
				
				 	}
			//	$action .='<a href="admin/coursemaster/course-view/'.base64_encode($course->id).'" title="View Course Content" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>';					 
				$action .='<a href="/admin/coursemaster/edit/'.base64_encode($course->id).'" title="Edit Course Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_master_page') ){
				$action .='<a href="javascript:courseMasterController.delete('.$course->id.')" title="Delete Course Content" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>  ';	
				}
				if($course->subcategory){
					$subcategory = SubCategory::where('id',$course->subcategory)->first();
					if($subcategory){
					    if($subcategory->course_image){
				            $vimage= unserialize($subcategory->course_image); 
				            $image='<img src="'.asset($vimage['course_image']['src']).'" type="'.$vimage['course_image']['alt'].'" width="100">'; 
					    }else{
					        $image= "";
					    }
				}
				}else{
					$image="";
				}
				$status="";
				if($course->status=='1'){
				$status .='<a href="javascript:courseMasterController.status('.$course->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:courseMasterController.status('.$course->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
				}				 
					$data[] = [		 		 		 
						$course->course_name,					 	
						$course->title,						
						$course->slug,						
						$course->rating,
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
		public function delete($id)
		{
 
			$courses = CoursesMaster::findOrFail($id);		
 		
			if($courses->delete()){				
			$status=1;							 
			$msg="Master course deleted successfully !";	

			}else{
			$status=0;							 
			$msg="Master course could not be Deleted!";	
			}

			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		}
  
 
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function masterCurriculumExcelDelete(Request $request,$id){
		  
			$coursesHeading = MasterCurriculumExcel::where('course_id',$id)->get();	
 
			if(count($coursesHeading)>0){
				 
				foreach($coursesHeading as $heading){					 
						$coursesContent = MasterCurriculumExcel::where('heading_id',$heading->id)->get();
						if(count($coursesContent)>0){
							foreach($coursesContent as $content){
								$courselevel1 = MasterCurriculumExcel::where('level1_id',$content->id)->get();
								if(count($courselevel1)>0){
									foreach($courselevel1 as $level1){										
										$courseslevel2 = MasterCurriculumExcel::where('level2_id',$level1->id)->get();
										if(count($courseslevel2)>0){
											foreach($courseslevel2 as $level2){												
											$courseslevel3 = MasterCurriculumExcel::where('level3_id',$level2->id)->get();
												if(count($courseslevel3)>0){
													foreach($courseslevel3 as $level3){
															$courseslevel4 = MasterCurriculumExcel::where('level4_id',$level3->id)->get();
														if(count($courseslevel4)>0){
															foreach($courseslevel4 as $level4){
																$courseslevel5 = MasterCurriculumExcel::where('level5_id',$level4->id)->get();
																
																if(count($courseslevel5)>0){
																	foreach($courseslevel5 as $level5){
																		$courseslevel6 = MasterCurriculumExcel::where('level6_id',$level5->id)->get();
																		if(count($courseslevel6)>0){
															foreach($courseslevel6 as $level6){
																	 
																		
																			$deleteLastContent = MasterCurriculumExcel::where('id',$level6->id)->delete();
															$deleteLastContent = MasterCurriculumExcel::where('id',$level5->id)->delete();
															$deleteLastContent = MasterCurriculumExcel::where('id',$level4->id)->delete();
															$deleteLastContent = MasterCurriculumExcel::where('id',$level3->id)->delete();
															$deleteendContent = MasterCurriculumExcel::where('id',$level2->id)->delete();
															$delsubcontent  =MasterCurriculumExcel::where('id',$level1->id)->delete();
															$delcontent  =MasterCurriculumExcel::where('id',$content->id)->delete();
															$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();
															$status=1;
															$error=200;
															$msg="Course Content Deleted Successfully !";
																 
																	
																
														
															}
															}else{
															$deleteLastContent = MasterCurriculumExcel::where('id',$level5->id)->delete();
															$deleteLastContent = MasterCurriculumExcel::where('id',$level4->id)->delete();
															$deleteLastContent = MasterCurriculumExcel::where('id',$level3->id)->delete();
															$deleteendContent = MasterCurriculumExcel::where('id',$level2->id)->delete();
															$delsubcontent  =MasterCurriculumExcel::where('id',$level1->id)->delete();
															$delcontent  =MasterCurriculumExcel::where('id',$content->id)->delete();
															$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();
															$status=1;
															$error=200;
															$msg="Course Content Deleted Successfully !";
																	}
																	
																} 
															 
															}else{
															 
															$deleteLastContent = MasterCurriculumExcel::where('id',$level4->id)->delete();
															$deleteLastContent = MasterCurriculumExcel::where('id',$level3->id)->delete();
															$deleteendContent = MasterCurriculumExcel::where('id',$level2->id)->delete();
															$delsubcontent  =MasterCurriculumExcel::where('id',$level1->id)->delete();
															$delcontent  =MasterCurriculumExcel::where('id',$content->id)->delete();
															$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();
															$status=1;
															$error=200;
															$msg="Course Content Deleted Successfully !";
																
															}
														} 
													 
												}else{ 
												
												$deleteLastContent = MasterCurriculumExcel::where('id',$level3->id)->delete();
												$deleteendContent = MasterCurriculumExcel::where('id',$level2->id)->delete();
												$delsubcontent  =MasterCurriculumExcel::where('id',$level1->id)->delete();
												$delcontent  =MasterCurriculumExcel::where('id',$content->id)->delete();
												$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();
												$status=1;
												$error=200;
												$msg="Course Content Deleted Successfully !";
														}
												} 
											}else{
												 
												$deleteendContent = MasterCurriculumExcel::where('id',$level2->id)->delete();
												$delsubcontent  =MasterCurriculumExcel::where('id',$level1->id)->delete();
												$delcontent  =MasterCurriculumExcel::where('id',$content->id)->delete();
												$delheading  =MasterCurriculumExcel::where('id',$heading->id)->delete();
												$status=1;
												$error=200;
												$msg="Course Content Deleted Successfully !";
												
											}
										} 										
									}else{
										$delsubcontent  =MasterCurriculumExcel::where('id',$level1->id)->delete();
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
	 
	 
 
	 public function masterCurriculumExcelDeleteold(Request $request,$id){
		  
			$coursesHeading = MasterCurriculumExcel::where('course_id',$id)->get();	
 
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
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCourseFooter(Request $request,$id)
    {	  
	
        if($request->ajax()){ 		
  
		  $validator = Validator::make($request->all(),[		 
				'footer_master'=>'required',				 		 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}		
			 
				
				$updaterelated =array(
				 		 		 	
				'footer_master'=>$request->input('footer_master'),				 				 		 	
				'updated_by'=>1,				 	
				);

				$checkupdate  =DB::table('web_coursemaster')->where('id',$id)->update($updaterelated);	
				if($checkupdate){
				$status=1;							 
				$msg="Course submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Course could not be updated !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
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
		 
		$coursesMaster = CoursesMaster::findOrFail($id);	 
		$coursesMaster->status=$val;
		//echo "<pre>";print_r($courses);die;
		if($coursesMaster->save()){
			$status=1;							 
			$msg="Master course status updated successfully !";					
			}else{
			$status=0;							 
			$msg="Master course status could not be updated!";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
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
