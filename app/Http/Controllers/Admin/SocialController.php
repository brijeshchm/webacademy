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
use App\Social;
use App\Helpers;
class SocialController extends Controller
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
        return view('admin.social.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {	  
		 
        return view('admin.social.index');
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSocial(Request $request)
    {	  
	
        if($request->ajax()){ 
		 //echo "<pre>";print_r($_POST);die;
			
  
		  $validator = Validator::make($request->all(),[		 
			 
				'social' => 'required|unique:web_social,social|max:32',	
				'social_icon' => 'required|mimes:jpeg,png,jpg,svg|max:7',							
				'alt' => 'required',							
				'average_rating' => 'required|numeric|between:0,5',	
				'total_review' =>'required',	
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				$alt= $request->input('alt');	
				$social = New Social;
				$social->social = ucfirst(trim($request->input('social')));		
				$social->average_rating = ucfirst(trim($request->input('average_rating')));	
				$social->total_review = trim($request->input('total_review'));	
				if ($request->hasFile('social_icon')) {
				$image = [];
				$filePath = $this->getSocialFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('social_icon');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['social_icon'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				} 			
				$social->social_icon = serialize($image);						
				 					
				$social->status = '1';				 
				$social->created_by =1; 	
//echo "<pre>";print_r($social);die;				
			if($social->save()){
				$status=1;							 
				$msg="Social submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Social could not be submitted!";	
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
		$edit_data= Social::findOrFail(base64_decode($id));
		 
 
        return view('admin.social.edit_social',['edit_data'=>$edit_data]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveSocial(Request $request,$id)
    {	  
	
//echo "<pre>";print_r($_POST);print_r($_FILES);die;
        if($request->ajax()){ 		 
		  $validator = Validator::make($request->all(),[				 
				 
			'social' 	=> 'required|max:32|unique:web_social,social,'.$id.',id',	
			 	
			'alt' => 'required',	
			'average_rating' => 'required|numeric|between:0,5',	
			'total_review' => 'required',	
			]);

			if($request->hasFile('social_icon')){
			$validator = Validator::make($request->all(),[					 

			'social_icon' => 'required|mimes:jpeg,png,jpg,svg,JPG,JPEG|max:7',		

			]);
			}
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				$alt= $request->input('alt');	
				$social = Social::findOrFail($id);
				$social->social = ucfirst(trim($request->input('social')));	
				$social->average_rating = ucfirst(trim($request->input('average_rating')));	
				$social->total_review = trim($request->input('total_review'));	
				if ($request->hasFile('social_icon')) {
				$image = [];
				$filePath = $this->getSocialFolderStructure();
				//	$file = Input::file('course_image');
				$file =  $request->file('social_icon');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['social_icon'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				$social->social_icon = serialize($image);		
				}else{
				$social->social_icon = $social->social_icon;	
				}				
				$social->updated_by =1;			 
				//echo "<pre>";print_r($social);die;
			if($social->save()){
				$status=1;							 
				$msg="Social updated successfully!";		
				
			}else{
				$status=0;							 
				$msg="Social could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getSocialPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$socials = 	Social::orderBy('id','DESC');		 
		if($request->input('search.value')!==''){
				$socials = $socials->where(function($query) use($request){
					$query->orWhere('social','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$socials = $socials->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $socials->total();
			$returnLeads['recordsFiltered'] = $socials->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($socials as $social){				 
				$action="";
				$seperate="";				 					 
				$action .='<a href="/admin/social/edit/'.base64_encode($social->id).'" title="Edit Social Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_social') ){
				$action .='<a href="javascript:socialController.delete('.$social->id.')" title="Delete Social Content" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
				 $vimage= json_decode($social->social_icon); 
				$image='<img src="'.asset($vimage['social_icon']['src']).'" type="'.$vimage['social_icon']['alt'].'" width="50">'; 
					$data[] = [		 		 		 
						$social->social,					 			
						$image,					 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $social->id;				 
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
       	 
		$delet_data = Social::findOrFail($id);	 
		if($delet_data->social_icon!='')
		{				 
			$image = json_decode($delet_data->social_icon);			
			$large = $image['social_icon']['src'];
			if(!empty($image['social_icon']['src'])){
			$thumbnail = $image['social_icon']['src'];
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
 
		$edit_data = array('social_icon'  =>"",);	 
		$del = Social::where('id',$id)->update($edit_data);			 		
		return redirect('admin/social/edit/'.base64_encode($id))->with("success","Image deleted successfully.");
			
    }
  
  
	 /**
     * Remove the specified resource from storage delelete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       	 
		$social = Social::findOrFail($id);	
		 //echo "<pre>";print_r($social);die;
		 
			if($social->social_icon!='')
			{
			$image = json_decode($social->social_icon);
			$large = $image['social_icon']['src'];
			if(!empty($image['social_icon']['src'])){
			$thumbnail = $image['social_icon']['src'];
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
			if($social->delete()){				
			$status=1;							 
			$msg="Social deleted successfully!";		

			}else{
			$status=0;							 
			$msg="Social could not be deleted!";	
			}

		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
    }
  
 
 
 // FOLDER STRUCTURE GENERATOR
// **************************
function getSocialFolderStructure(){	 
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
		$partial_str = 'uploads/Social/'.date('Y').'/'.date('m').'/'.$week;
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
