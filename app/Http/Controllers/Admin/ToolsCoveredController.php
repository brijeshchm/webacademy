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
use App\Models\Category;
use App\Models\SubCategory;
use App\Helpers;
use App\Models\ToolsCovered;
class ToolsCoveredController extends Controller
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
	//echo "test";die;
        return view('admin.toolscovered.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {	  
		 
        return view('admin.toolscovered.index');
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveToolsCovered(Request $request)
    {	  
	
        if($request->ajax()){ 
		 //echo "<pre>";print_r($_POST);die;
			
  
		  $validator = Validator::make($request->all(),[			 
				'name' => 'required|unique:web_toolscovered,name|max:255',				 		
				'covered_icons' => 'required|mimes:jpeg,png,jpg,svg|max:3|dimensions:min_width=25,min_height=25,max_width=200,max_height=100',				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 	
				$toolsCovered = New ToolsCovered;
				$toolsCovered->name = ucfirst(trim($request->input('name')));		
				$alt= $request->input('name');	
				if ($request->hasFile('covered_icons')) {
				$image = [];
				$filePath = $this->getToolCoveredFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('covered_icons');
				$iconsfilename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$iconsfilename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$iconsfilename)){
				$iconsfilename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$iconsfilename);				 
				$image['covered_icons'] = array(
				'name'=>$iconsfilename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$iconsfilename
				);	
				} 			
				$toolsCovered->covered_icons = serialize($image);
				
				$toolsCovered->status = '1';				 
				$toolsCovered->created_by =1; 		
			if($toolsCovered->save()){
				$status=1;							 
				$msg="Tools covered submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Tools covered could not be submitted!";	
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
		$edit_data= ToolsCovered::findOrFail(base64_decode($id));
		 
 
        return view('admin.toolscovered.edit_toolscovered',['edit_data'=>$edit_data]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveToolsCovered(Request $request,$id)
    {	  
	
        if($request->ajax()){ 		 
		  $validator = Validator::make($request->all(),[					 
			'name' 	=> 'required|max:255|unique:web_toolscovered,name,'.$id.',id',				 		
			]);
			if($request->hasFile('covered_icons')){
				 $validator = Validator::make($request->all(),[					 
				'covered_icons' => 'required|mimes:jpeg,png,jpg,svg|max:3|dimensions:min_width=25,min_height=25,max_width=200,max_height=100',		 			
			]);
			} 
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 
				$toolsCovered = ToolsCovered::findOrFail($id);
				$toolsCovered->name = ucfirst(trim($request->input('name')));	
				$alt =$request->input('name');
				if ($request->hasFile('covered_icons')) {
				$icons = [];
				$filePath = $this->getToolCoveredFolderStructure();
				//	$file = Input::file('course_image');
				$file =  $request->file('covered_icons');
				$iconsfilename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$iconsfilename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$iconsfilename)){
				$iconsfilename = $name."_".time().'.'.$ext;
				}
				
				 
				$file->move($destinationPath,$iconsfilename);				 
				$icons['covered_icons'] = array(
				'name'=>$iconsfilename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$iconsfilename
				);	
				$toolsCovered->covered_icons = serialize($icons);		
				}else{
				$toolsCovered->covered_icons = $toolsCovered->covered_icons;	
				}					
				$toolsCovered->updated_by =1; 					
			if($toolsCovered->save()){
				$status=1;							 
				$msg="Tools covered updated successfully!";
				
			}else{
				$status=0;							 
				$msg="Tools covered could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getToolsCoveredPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$toolsCovereds = 	ToolsCovered::orderBy('id','DESC');		 
		if($request->input('search.value')!==''){
				$toolsCovereds = $toolsCovereds->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$toolsCovereds = $toolsCovereds->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $toolsCovereds->total();
			$returnLeads['recordsFiltered'] = $toolsCovereds->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($toolsCovereds as $toolsCovered){				 
				$action="";
				$seperate="";
				$status="";
				 if(!empty($toolsCovered->covered_icons)){
				 	$vicons= unserialize($toolsCovered->covered_icons); 
				$icons='<img src="'.asset($vicons['covered_icons']['src']).'" width="45px">'; 	
				 }else{
					$icons="";
				 }				
				$action .='<a href="/admin/toolscovered/edit/'.base64_encode($toolsCovered->id).'" title="Edit tools covered" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>  ';
				 if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_tools_image') ){
				$action .='<a href="javascript:toolsCoveredController.delete('.$toolsCovered->id.')" title="Delete tools covered" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				 }
				if($toolsCovered->status=='1'){
				$status .='<a href="javascript:toolsCoveredController.status('.$toolsCovered->id.',0)" title="tools covered status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:toolsCoveredController.status('.$toolsCovered->id.',1)" title="tools covered status" class="btn btn-danger">Inactive</a>';	
				}
					$data[] = [		 		 		 
						$toolsCovered->name,				 			
						$icons,				 			
						$status, 				 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $toolsCovered->id;				 
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
       	 
		$delet_data = ToolsCovered::findOrFail($id);	 
		if($delet_data->covered_icons!='')
		{				 
			$image = unserialize($delet_data->covered_icons);			
			$large = $image['covered_icons']['src'];
			if(!empty($image['covered_icons']['src'])){
			$thumbnail = $image['covered_icons']['src'];
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
 
		$edit_data = array('covered_icons'  =>"",);	 
		$del = ToolsCovered::where('id',$id)->update($edit_data);			 		
		return redirect('admin/toolscovered/edit/'.base64_encode($id))->with("success","Image deleted successfully.");
			
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
		 
		$toolsCovered = ToolsCovered::findOrFail($id);	 
		$toolsCovered->status=$val;
	 
		if($toolsCovered->save()){
			$status=1;							 
			$msg="Tools covered status updated successfully !";					
			}else{
			$status=0;							 
			$msg="Tools covered status could not be updated!";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
  
  
	 /**
     * Remove the specified resource from storage delelete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       	 
		$toolsCovered = ToolsCovered::findOrFail($id);	 
	
		if($toolsCovered->covered_icons!='')
			{				 
			$image = unserialize($toolsCovered->covered_icons);			
			$large = $image['covered_icons']['src'];
			if(!empty($image['covered_icons']['src'])){
			$thumbnail = $image['covered_icons']['src'];
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
	
	
		  if($toolsCovered->delete()){		
				$status=1;							 
				$msg="Tools Covered Delete Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Tools Covered Delete Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
	 
    }
   
// FOLDER STRUCTURE GENERATOR
// **************************
function getToolCoveredFolderStructure(){	 
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
		$partial_str = 'uploads/Covered/'.date('Y').'/'.date('m').'/'.$week;
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
