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
use App\Client;
use App\Models\ToolsCovered;
class ClientController extends Controller
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
        return view('admin.client.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {	  
		 
        return view('admin.client.index');
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveClient(Request $request)
    {	  
	
        if($request->ajax()){ 
		 //echo "<pre>";print_r($_POST);die;
			
  
		  $validator = Validator::make($request->all(),[			 
				'name' => 'required|unique:web_clients,name|max:255',				 		
				'client_icons' => 'required|mimes:jpeg,png,jpg,svg|max:3|dimensions:min_width=25,min_height=25,max_width=400,max_height=400',				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 	
				$client = New Client;
				$client->name = ucfirst(trim($request->input('name')));		
				$alt= $request->input('name');	
				if ($request->hasFile('client_icons')) {
				$image = [];
				$filePath = $this->getclientFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('client_icons');
				$iconsfilename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$iconsfilename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$iconsfilename)){
				$iconsfilename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$iconsfilename);				 
				$image['client_icons'] = array(
				'name'=>$iconsfilename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$iconsfilename
				);	
				} 			
				$client->client_icons = serialize($image);				
				$client->status = '1';				 
				$client->created_by =1; 	

 				
			if($client->save()){
				$status=1;							 
				$msg="Client image submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Client image could not be submitted!";	
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
		$edit_data= Client::findOrFail(base64_decode($id));
		 
 
        return view('admin.client.edit_client',['edit_data'=>$edit_data]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveClient(Request $request,$id)
    {	  
	
        if($request->ajax()){ 		 
		  $validator = Validator::make($request->all(),[					 
			'name' 	=> 'required|max:255|unique:web_clients,name,'.$id.',id',				 		
			]);
			if($request->hasFile('client_icons')){
				 $validator = Validator::make($request->all(),[					 
				'client_icons' => 'required|mimes:jpeg,png,jpg,svg|max:3|dimensions:min_width=25,min_height=25,max_width=400,max_height=400',		 			
			]);
			} 
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 
				$client = Client::findOrFail($id);
				$client->name = ucfirst(trim($request->input('name')));	
				$alt =$request->input('name');
				if ($request->hasFile('client_icons')) {
				$icons = [];
				$filePath = $this->getclientFolderStructure();
				//	$file = Input::file('course_image');
				$file =  $request->file('client_icons');
				$iconsfilename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$iconsfilename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$iconsfilename)){
				$iconsfilename = $name."_".time().'.'.$ext;
				}
				
				 
				$file->move($destinationPath,$iconsfilename);				 
				$icons['client_icons'] = array(
				'name'=>$iconsfilename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$iconsfilename
				);	
				$client->client_icons = serialize($icons);		
				}else{
				$client->client_icons = $client->client_icons;	
				}					
				$client->updated_by =1; 					
			if($client->save()){
				$status=1;							 
				$msg="Client Image updated successfully!";
				
			}else{
				$status=0;							 
				$msg="Client Image could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getClientPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$clients = 	Client::orderBy('id','DESC');		 
		if($request->input('search.value')!==''){
				$clients = $clients->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$clients = $clients->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $clients->total();
			$returnLeads['recordsFiltered'] = $clients->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($clients as $client){				 
				$action="";
				$seperate="";
				$status="";
				 if(!empty($client->client_icons)){
				 	$vicons= unserialize($client->client_icons); 
				 	
				    $icons='<img src="'.asset($vicons['client_icons']['src']).'" width="100px">'; 	
				 }else{
					$icons="";
				 }				
				$action .='<a href="/admin/client/edit/'.base64_encode($client->id).'" title="Edit Client" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>  ';
				 if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_tools_image') ){
				$action .='<a href="javascript:clientController.delete('.$client->id.')" title="Delete Client" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				 }
				if($client->status=='1'){
				$status .='<a href="javascript:clientController.status('.$client->id.',0)" title="Client status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:clientController.status('.$client->id.',1)" title="Client status" class="btn btn-danger">Inactive</a>';	
				}
					$data[] = [		 		 		 
						$client->name,				 			
						$icons,				 			
						$status, 				 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $client->id;				 
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
       	 
		$delet_data = Client::findOrFail($id);	 
		
		 
		if($delet_data->client_icons!='')
		{				 
			$image = unserialize($delet_data->client_icons);			
			$large = $image['client_icons']['src'];
			if(!empty($image['client_icons']['src'])){
			$thumbnail = $image['client_icons']['src'];
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
 
		$edit_data = array('client_icons'  =>"",);	 
		$del = Client::where('id',$id)->update($edit_data);			 		
		return redirect('admin/client/edit/'.base64_encode($id))->with("success","Image deleted successfully.");
			
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
		 
		$client = Client::findOrFail($id);	 
		$client->status=$val;
	 
		if($client->save()){
			$status=1;							 
			$msg="Client status updated successfully !";					
			}else{
			$status=0;							 
			$msg="Client status could not be updated!";	
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
       	 
		$client = Client::findOrFail($id);	 
	//echo "<pre>";print_r($client);die;
		if($client->client_icons!='')
			{				 
			$image = unserialize($client->client_icons);			
			$large = $image['client_icons']['src'];
			if(!empty($image['client_icons']['src'])){
			$thumbnail = $image['client_icons']['src'];
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
	
	
		  if($client->delete()){		
				$status=1;							 
				$msg="Client Image Delete Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Delete Client Image Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
	 
    }
  
 
  
// FOLDER STRUCTURE GENERATOR
// **************************
function getclientFolderStructure(){
	
	 
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
		$partial_str = 'uploads/client/'.date('Y').'/'.date('m').'/'.$week;
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
