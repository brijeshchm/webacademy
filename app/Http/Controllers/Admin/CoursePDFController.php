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
use App\Models\Placement;
use App\Models\Courses;
use App\Offer;
use App\Models\Category;
use App\Models\SubCategory;
use App\Helpers;
use App\CoursesPdf;
class CoursePDFController extends Controller
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
        $categorylist =Category::get();
		$search = [];
		if($request->has('search')){
		$search = $request->input('search');
		}
        return view('admin.coursepdf.index',['search'=>$search,'categorylist'=>$categorylist]);
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		
		$cetegories= Category::select('id','category')->get();
		$course_list= Course::select('id','title','course_name')->get();	
        return view('admin.coursepdf.add_coursepdf',['course_list'=>$course_list,'cetegories'=>$cetegories]);
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCoursePDF(Request $request)
    {	  
	// echo "<pre>";print_r($_POST);print_r($_FILES);die;
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[				 
				'category' => 'required',				
				'subcategory' => 'required',				
				'course_pdf' => 'required',				
				 		 		
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
		 		 
					
				if ($request->hasFile('course_pdf')) {
				$filePath = "download";
				$file =  $request->file('course_pdf');
				$filename =str_replace(' ', '_', trim($file->getClientOriginalName()));			 
				$destinationPath = public_path($filePath); 
				
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $filename;
				}
				$file->move($destinationPath,$filename);	
				$fileTextName= str_replace(' ', '_', trim(substr($file->getClientOriginalName(),0,-4)));
				}else{
					$fileTextName="";
				}
				
				
				
				$coursesPdf = New CoursePdf;
				$coursesPdf->category = $request->input('category');		
				$coursesPdf->subcategory = $request->input('subcategory');					 					
				$coursesPdf->coursePdfText = $fileTextName;				 				 								
				$coursesPdf->created_by = '1';				 
				$coursesPdf->status = '1';				 
				 
			if($coursesPdf->save()){
				$status=1;							 
				$msg="Course PDF submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Course PDF could not be submitted!";	
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
		$edit_data= CoursesPdf::findOrFail(base64_decode($id)); 
		$cetegories= Category::select('id','category')->get();
		$course_list= Course::select('id','title','course_name')->get();
        return view('admin.coursepdf.edit_coursepdf',['edit_data'=>$edit_data,'course_list'=>$course_list,'cetegories'=>$cetegories]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCoursePDF(Request $request,$id)
    {	  
	//echo "<pre>";print_r($_POST);die;  
	
	//echo $id;die;
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[			 
				'category' => 'required',				
				'subcategory' => 'required',				
				'course_pdf' => 'required',			
				 		
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 
				 
				
				
				$coursesPdf = CoursesPdf::findOrFail($id);				 
				$coursesPdf->category = $request->input('category');		
				$coursesPdf->subcategory = $request->input('subcategory');		
				
				if($request->hasFile('course_pdf')){
				$filePath = "download";
				$file =  $request->file('course_pdf');
				$filename =str_replace(' ', '_', trim($file->getClientOriginalName()));			 
				$destinationPath = public_path($filePath); 
			
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $filename;
				}
				$file->move($destinationPath,$filename);	
				$fileTextName= str_replace(' ', '_', trim(substr($file->getClientOriginalName(),0,-4)));
				$coursesPdf->coursePdfText = $fileTextName;					
				}else{
					$coursesPdf->coursePdfText = $coursesPdf->coursePdfText;	
				}

				
				 	 				 								
				$coursesPdf->created_by = '1';				 
				$coursesPdf->status = '1';	
 			
			if($coursesPdf->save()){
				$status=1;							 
				$msg="Course PDF updated successfully!";		
				
			}else{
				$status=0;							 
				$msg="Course PDF could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getCoursePDFPagination(Request $request)
	{
		   
		if($request->ajax()){		

		$coursesPdf= DB::table('web_coursepdf as pdf');		 
		$coursesPdf  =$coursesPdf->join('web_categories as category','pdf.category','=','category.id','left');
		$coursesPdf= $coursesPdf->select('pdf.*','category.id as categoryid','category.category as categoryname');		
		$coursesPdf = 	$coursesPdf->orderBy('category.category','ASC');		 
		$coursesPdf = 	$coursesPdf->groupBy('pdf.subcategory');		 
	 		 
		if($request->input('search.value')!==''){
				$coursesPdf = $coursesPdf->where(function($query) use($request){
					$query->orWhere('category.category','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('pdf.coursePdfText','LIKE','%'.$request->input('search.value').'%');
				});
			}
			
			
			if(!empty($request->input('search.category'))){				 
			$coursesPdf = $coursesPdf->where('pdf.category','LIKE','%'.$request->input('search.category').'%');
			}			
			if(!empty($request->input('search.subcategory'))){				 
			$coursesPdf = $coursesPdf->where('pdf.subcategory','LIKE','%'.$request->input('search.subcategory').'%');
			}
			
			$coursesPdf = $coursesPdf->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $coursesPdf->total();
			$returnLeads['recordsFiltered'] = $coursesPdf->total();
			$returnLeads['recordCollection'] = [];

			foreach($coursesPdf as $pdf){				 
				$action="";
				$seperate="";				 					 
				$status="";				 					 
				$action .='<a href="/admin/coursepdf/edit/'.base64_encode($pdf->id).'" title="Edit pdf" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_course_pdf') ){
				$action .='<a href="javascript:coursePdfController.delete('.$pdf->id.')" title="Delete placement" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
					}				
				 $category= Category::where('id',$pdf->category)->first();
				 if(!empty($category)){
					 $categoryname= $category->category;
				 }else{
					 $categoryname="";
				 }
				 
				 $subcategory= SubCategory::where('id',$pdf->subcategory)->first();
				 if(!empty($subcategory)){
					 $subcategoryname= $subcategory->subcategory;
				 }else{
					 $subcategoryname="";
				 }
				 
				 	if($pdf->status=='1'){
					$status .='<a href="javascript:coursePdfController.status('.$pdf->id.',0)" title="Course status" class="btn btn-success" >Active</a>';	
					}else{
					$status .='<a href="javascript:coursePdfController.status('.$pdf->id.',1)" title="Course status" class="btn btn-danger" >Inactive</a>';	
					}
				$coursePdfText= CoursesPdf::where('subcategory',$pdf->subcategory)->get();
				// echo "<pre>";print_r($coursePdfText);die;
				
				 $PdfText= "";
				 $linkhtml= "";
				if($coursePdfText){
					$PdfText .='<ul>';
					foreach($coursePdfText as $text){
						
						
						
						$linkhtml ='<div class="lo" style="margin-top: -18px;text-align: right;    margin-bottom: 10px;"><div class="ip">';
						if($text->status=='1'){ 
						$linkhtml .='<a href="javascript:coursePdfController.coursepdfstatus('.$text->id.',0)" title="Active" ><span style="color:green;    margin-right: 5px;"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span></a>';																	
						}else{
						$linkhtml .='<a href="javascript:coursePdfController.coursepdfstatus('.$text->id.',1)" title="Inactive"><span style="color:red;    margin-right: 5px;"><i class="fa fa-thumbs-down" aria-hidden="true"></i></span></a>';
							} 									
																			 																			
						$linkhtml .='<a href="/download/'.$text->coursePdfText.'.pdf" target="_blank" class="cnt-dwnss lms-pdf" title="'.ucwords(str_replace('-',' ',$text->coursePdfText)).'" data-stud_id="'.$text->id.'" style="margin-right: 5px;"><span class="course-pdf"> <i class="fa fa-file-pdf-o"></i> </span></a>';
						$linkhtml .='<a href="javascript:coursePdfController.delete('.$text->id.')" title="PDF deleted" class="deleteIcon lms-delete" onclick="return ConfirmDelete()" ><i class="fa fa-trash" style="color:red"></i></a></div></div>';
						
						
						
						
						
						
						
						$PdfText .= '<li>'.$text->coursePdfText.''.$linkhtml.'</li>';
					}
					
						$PdfText .='</ul>';
				}
				
					$data[] = [		
						$categoryname,					 			
						$subcategoryname,						
						$PdfText,					 			 			
						//$status, 			 			 			
						//$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $pdf->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
		}  
		
	}
	
			
	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function coursepdfstatus(Request $request, $id,$val)
    {
		
		//echo $id;$val;die;
		try{
				$coursePdf = CoursesPdf::findorFail($id);
				$coursePdf->status = $val;
				
				//echo "<pre>";print_r($coursePdf);die;
				if($coursePdf->save()){
					return response()->json(['status'=>1],200);
				}else{
					return response()->json(['status'=>0],400);
				}
			}catch(\Exception $e){
				return response()->json(['status'=>0,'errors'=>'Course not found'],200);
			}
		 
    }
	
	
	
	// GET  Course pagination
	public function getCoursePDFPaginationold(Request $request)
	{
		   
		if($request->ajax()){		

		$coursesPdf= DB::table('web_coursepdf as pdf');		 
		$coursesPdf  =$coursesPdf->join('web_categories as category','pdf.category','=','category.id','left');
		$coursesPdf= $coursesPdf->select('pdf.*','category.id as categoryid','category.category as categoryname');		
		$coursesPdf = 	$coursesPdf->orderBy('category.category','ASC');		 
	//	$coursesPdf = 	$coursesPdf->groupBy('pdf.subcategory');		 
	 		 
		if($request->input('search.value')!==''){
				$coursesPdf = $coursesPdf->where(function($query) use($request){
					$query->orWhere('category.category','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('pdf.coursePdfText','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$coursesPdf = $coursesPdf->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $coursesPdf->total();
			$returnLeads['recordsFiltered'] = $coursesPdf->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($coursesPdf as $pdf){				 
				$action="";
				$seperate="";				 					 
				$status="";				 					 
				$action .='<a href="/admin/coursepdf/edit/'.base64_encode($pdf->id).'" title="Edit pdf" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_course_pdf') ){
				$action .='<a href="javascript:coursePdfController.delete('.$pdf->id.')" title="Delete placement" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
					}				
				 $category= Category::where('id',$pdf->category)->first();
				 if(!empty($category)){
					 $categoryname= $category->category;
				 }else{
					 $categoryname="";
				 }
				 
				 $subcategory= SubCategory::where('id',$pdf->subcategory)->first();
				 if(!empty($subcategory)){
					 $subcategoryname= $subcategory->subcategory;
				 }else{
					 $subcategoryname="";
				 }
				 
				 	if($pdf->status=='1'){
					$status .='<a href="javascript:coursePdfController.status('.$pdf->id.',0)" title="Course status" class="btn btn-success" >Active</a>';	
					}else{
					$status .='<a href="javascript:coursePdfController.status('.$pdf->id.',1)" title="Course status" class="btn btn-danger" >Inactive</a>';	
					}
				 
				 
					$data[] = [		
						$categoryname,					 			
						$subcategoryname,						
						$pdf->coursePdfText,					 			 			
						$status, 			 			 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $pdf->id;				 
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
		 
		$CoursesPdf = CoursesPdf::findOrFail($id); 
		
 
			if(!empty($CoursesPdf->coursePdfText)){				 	
			$thumbnail = 'download/'.$CoursesPdf->coursePdfText.'.pdf';			 
			if (file_exists($thumbnail))
			{
			unlink($thumbnail);
			}  
			}
		if($CoursesPdf->delete()){
		$status=1;							 
		$msg="Course PDF deleted successfully !";	
		}else{
		$status=0;							 
		$msg="Course PDF could not be deleted!";	
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
       	 
		$delet_data = CoursesPdf::findOrFail($id);	 
		//echo "<pre>";print_r($delet_data);die;
		if($delet_data->coursePdfText!='')
		{				 
			 
			if(!empty($delet_data->coursePdfText)){				 	
			$thumbnail = 'download/'.$delet_data->coursePdfText.'.pdf';			 
			if (file_exists($thumbnail))
			{
			unlink($thumbnail);
			}  
			}
			 		 
		}
 
		$edit_data = array('coursePdfText'  =>"",);	 
		$del = CoursesPdf::where('id',$id)->update($edit_data);			 		
		return redirect('admin/coursepdf/edit/'.base64_encode($id))->with("success","Course PDF deleted successfully.");
			
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
		 
		$coursesPdf = CoursesPdf::findOrFail($id);	 
		$coursesPdf->status=$val;
		 
		if($coursesPdf->save()){
			$status=1;							 
			$msg="Course PDF status updated successfully!";					
			}else{
			$status=0;							 
			$msg="Course PDF status could not be updated!";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
  
 
 
}
