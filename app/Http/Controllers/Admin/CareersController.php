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
use App\Models\Careers;
use App\Models\Courses;
use App\Helpers;
class CareersController extends Controller
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
        return view('admin.careers.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		
		 
        return view('admin.careers.add_careers');
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCareers(Request $request)
    {	
	
	 //echo "<pre>";print_r($_POST);die;
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[			 
				'job_title' => 'required|unique:web_careers,job_title|max:35',		
				'position' => 'required',				
				'profile' => 'required',				
				'exp_from' => 'required',				
				'exp_to' => 'required',				
				'description' => 'required',				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
			 
				$careers = New Careers;
				$careers->job_title = ucwords(trim($request->input('job_title')));		
				$careers->position = $request->input('position');					 					
				$careers->profile =$request->input('profile');	
			 					 
				$careers->exp_from = trim($request->input('exp_from'));					 
				$careers->exp_to = trim($request->input('exp_to'));					 
				$careers->description = $request->input('description');					
				 							
				$careers->created_by = '1';				 
				$careers->status = '1';				 
				  
			if($careers->save()){
				$status=1;							 
				$msg="Career submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Career could not be submitted, please try again!";	
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
		$edit_data= Careers::findOrFail(base64_decode($id)); 
		$course_list= Course::select('id','title','course_name')->groupby('course_name')->get();
        return view('admin.careers.edit_careers',['edit_data'=>$edit_data,'course_list'=>$course_list]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCareers(Request $request,$id)
    {	  
	 
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[				 
				'job_title' 	=> 'required|max:35|unique:web_careers,job_title,'.$id.',id',			 				
				'position' => 'required',				
				'profile' => 'required',				
				'exp_from' => 'required',				
				'exp_to' => 'required',				
				'description' => 'required',			
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				$careers= Careers::findOrFail($id); 
				$careers->job_title = ucwords(trim($request->input('job_title')));		
				$careers->position = $request->input('position');					 					
				$careers->profile =$request->input('profile');				 					 
				$careers->exp_from = trim($request->input('exp_from'));					 
				$careers->exp_to = trim($request->input('exp_to'));					 
				$careers->description = $request->input('description');					 			
			 	$careers->updated_by = '1';	
			
			if($careers->save()){
				$status=1;							 
				$msg="Career updated successfully!";		
				
			}else{
				$status=0;							 
				$msg="Career could not be updated, please try again!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getCareersPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$careers = 	Careers::orderBy('id','desc');		 
		if($request->input('search.value')!==''){
				$careers = $careers->where(function($query) use($request){
					$query->orWhere('job_title','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('position','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$careers = $careers->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $careers->total();
			$returnLeads['recordsFiltered'] = $careers->total();
			$returnLeads['recordCollection'] = [];

			foreach($careers as $career){				 
				$action="";
				$seperate="";				 					 
				$status="";				 					 
				$action .='<a href="/admin/careers/edit/'.base64_encode($career->id).'" title="Edit Careers" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_careers') ){
				$action .='<a href="javascript:careersController.delete('.$career->id.')" title="Delete Careers" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
				if($career->status=='1'){
					$status .='<a href="javascript:careersController.status('.$career->id.',0)" title="Careers status" class="btn btn-success">Active</a>';	
					}else{
					$status .='<a href="javascript:careersController.status('.$career->id.',1)" title="Careers status" class="btn btn-danger">Inactive</a>';	
					}
				 
					$data[] = [		 		 		 
						$career->job_title,					 			
						$career->position,	 		
						$career->profile,					 			
						$career->exp_from.'-'.$career->exp_to.' Exp',					 			
						$career->description,					 			
						$status, 	 			 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $career->id;				 
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
		 
		$careers = Careers::findOrFail($id); 		 
		if($careers->delete()){
		$status=1;							 
		$msg="Career deleted successfully!";	
		}else{
		$status=0;							 
		$msg="Career could not be deleted!";	
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
		 
		$careers = Careers::findOrFail($id);	 
		$careers->status=$val;
		 
		if($careers->save()){
			$status=1;							 
			$msg="Career status updated successfully!";					
			}else{
			$status=0;							 
			$msg="Career status could not be updated!";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
  
 
 
 
}
