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
use App\Models\Course;
use App\Helpers;
class PlacementController extends Controller
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
        return view('admin.placement.index');
    } 
	
 
   /**
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		
		$course_list= Course::select('id','title','course_name')->where('course_type','1')->get();	
		
        return view('admin.placement.add_placement',['course_list'=>$course_list]);
    } 
	 /**
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function savePlacement(Request $request)
    {	  
	 
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[	
			 
				'name' => 'required',				
				'course' => 'required',				
			//	'rating' => 'required',				
			//	'total_rating' => 'required',				
			//	'alt' => 'required',				
			//	'comment' => 'required',				
				'company_name' => 'required',				
				'designation' => 'required',				
				//'placement_image' => 'required',				
			//	'related_courses' => 'required',				
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
			
				 
	$image = "";
			if ($request->hasFile('placement_image')) {
					$alt= $request->input('alt');	
			
				$filePath = $this->getPlacementFolderStructure();			 
				$file =  $request->file('placement_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['placement_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				} 
				
				$placement = New Placement;
				$placement->name = ucwords(trim($request->input('name')));		
				$placement->email = $request->input('email');					 					
				$placement->course =$request->input('course');		
				$course = Course::find($request->input('course'));

				$coursename = $course?->course_name ?: $course?->title;

				$placement->coursename = $coursename;				 
				$placement->rating = trim($request->input('rating'));					 
				$placement->total_rating = trim($request->input('total_rating'));					 
				$placement->comment = $request->input('comment');					 
				$placement->company_name = $request->input('company_name');					 
				$placement->salary_hike = $request->input('salary_hike');					 
				$placement->designation = $request->input('designation');	
				$placement->related_courses = json_encode($request->input('related_courses'));									
				$placement->placement_image = $image?json_encode($image):'';									
				$placement->created_by = '1';				 
				$placement->status = '1';				 
				 	
			if($placement->save()){
				$status=1;							 
				$msg="Placement submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Placement could not be submitted!";	
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
		$edit_data= Placement::findOrFail(base64_decode($id)); 
		$course_list= Course::select('id','title','course_name')->where('course_type','1')->get();
        return view('admin.placement.edit_placement',['edit_data'=>$edit_data,'course_list'=>$course_list]);
    } 
	
	/**
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSavePlacement(Request $request,$id)
    {	  
 
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[				 
				'name' => 'required',				
				'course' => 'required',				
			//	'rating' => 'required',				
			//	'total_rating' => 'required',				
			//	'alt' => 'required',				
			//	'comment' => 'required',				
				'company_name' => 'required',				
				'designation' => 'required',				
			//	'placement_image' => 'required',				
			//	'related_courses' => 'required',				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
					
				$placement = Placement::findOrFail($id);				 
				$placement->name = ucwords(trim($request->input('name')));		
				$placement->email = $request->input('email');					 					
				$placement->course =$request->input('course');				
				$course = Course::find($request->input('course'));
				$coursename = $course?->course_name ?: $course?->title;
				$placement->coursename = $coursename;
				$placement->rating = trim($request->input('rating'));					 
				$placement->total_rating = trim($request->input('total_rating'));					 
				$placement->comment = $request->input('comment');					 
				$placement->company_name = $request->input('company_name');					 
				$placement->salary_hike = $request->input('salary_hike');					 
				$placement->designation = $request->input('designation');	
				$placement->related_courses = json_encode($request->input('related_courses'));				 			 
			 	$image = "";
				
				if ($request->hasFile('placement_image')) {
			
				$alt= $request->input('alt');
				$filePath = $this->getPlacementFolderStructure();
				 
				$file =  $request->file('placement_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['placement_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				$placement->placement_image = json_encode($image);		
				}else{
				$placement->placement_image = $placement->placement_image;	
				}				
			 	$placement->updated_by = '1';			
			if($placement->save()){
				$status=1;							 
				$msg="Placement updated successfully !";		
				
			}else{
				$status=0;							 
				$msg="Placement could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 
	
	/*
	// GET  Course pagination
	* Author: Brijesh Chauhan.
	*/
	public function getPlacementPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$placements = 	Placement::orderBy('id','desc');		 
		if($request->input('search.value')!==''){
				$placements = $placements->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('company_name','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$placements = $placements->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $placements->total();
			$returnLeads['recordsFiltered'] = $placements->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($placements as $placement){				 
				$action="";
				$seperate="";				 					 
				$action .='<a href="/admin/placement/edit/'.base64_encode($placement->id).'" title="Edit placement" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_placement') ){
				$action .='<a href="javascript:placementController.delete('.$placement->id.')" title="Delete placement" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';					
				}
				if(!empty($placement->placement_image)){
				 $vimage= json_decode($placement->placement_image); 
					$image='<img src="'.asset($vimage['placement_image']['src']).'" type="'.$vimage['placement_image']['alt'].'" width="100">'; 	
				}else{
					$image="";
				}
				
				$status="";
				if($placement->status=='1'){
				$status .='<a href="javascript:placementController.status('.$placement->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:placementController.status('.$placement->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
				}
				
				$coursename = Course::select('id','course_name')->where('id',$placement->course)->first();
				if(!empty($coursename)){
					$coursen = $coursename->course_name;
				}else{
					$coursen="";
				}
					$data[] = [		 		 		 
						$placement->name,					 			
						$placement->coursename,	 		
						$placement->company_name,					 			
						$placement->designation,					 			
						$image,	 				 			
						$status,	 				 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $placement->id;				 
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
		 
		$placement = Placement::findOrFail($id);			 
		if($placement->placement_image!='')
		{
			$image = json_decode($placement->placement_image);
			$large = $image['placement_image']['src'];
			if(!empty($image['placement_image']['src'])){
			$thumbnail = $image['placement_image']['src'];
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
	
		if($placement->delete()){
		$status=1;							 
		$msg="Placement deleted successfully!";	
		}else{
		$status=0;							 
		$msg="Placement could not be deleted!";	
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
       	 
		$delet_data = Placement::findOrFail($id);	
 	
		if($delet_data->placement_image!='')
		{		
			 
			$image = json_decode($delet_data->placement_image);
			
			$large = $image['placement_image']['src'];
			if(!empty($image['placement_image']['src'])){
			$thumbnail = $image['placement_image']['src'];
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
 
		$edit_data = array('placement_image' =>"",);	 
		$del = Placement::where('id',$id)->update($edit_data);			 		
		return redirect('admin/placement/edit/'.base64_encode($id))->with("success","image deleted successfully.");
			
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
		 
		$placement = Placement::findOrFail($id);	 
		$placement->status=$val;
	
		if($placement->save()){
			$status=1;							 
			$msg="Placement status updated successfully!";					
			}else{
			$status=0;							 
			$msg="Placement status could not be updated!";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
 
 
 // FOLDER STRUCTURE GENERATOR
// **************************
function getPlacementFolderStructure(){
	try{
		$partial_str = '';
		$day = date('j');
		$week = '';
		if($day<11){
			$week = 'week_1';
		}
		else if($day>=11&&$day<21){
			$week = 'week_2';
		}
		else if($day>=21){
			$week = 'week_3';
		}
		$partial_str = 'uploads/Placement/'.date('Y').'/'.date('m').'/'.$week;
		$structure = public_path($partial_str);
		if(file_exists($structure)){
			return $partial_str;
		}else{
			if(mkdir($structure, 0755, true)){
				return $partial_str;
			}else{
				throw new Exception("Folder structure not found.\nUnable to create folder structure.");
			}
		}
	}catch(Exception $e){
		return $e->getMessage();
	}
}
 
 
}
