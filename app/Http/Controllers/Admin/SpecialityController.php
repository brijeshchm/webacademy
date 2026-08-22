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
use App\Models\Speciality;
use App\Social;
use App\Helpers;
class SpecialityController extends Controller
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
        return view('admin.speciality.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {	  
		 
        return view('admin.speciality.index');
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSpeciality(Request $request)
    {	  
	
        if($request->ajax()){ 
		// echo "<pre>";print_r($_POST);die;
			
  
		  $validator = Validator::make($request->all(),[		 
			 
				'professionals_trained' => 'required|unique:web_speciality,professionals_trained|max:6',	
				'batches' => 'required',						
				 						
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				$alt= $request->input('alt');	
				$speciality = New Speciality;
				$speciality->professionals_trained = trim($request->input('professionals_trained'));		
				$speciality->batches = trim($request->input('batches'));		
				$speciality->counting = trim($request->input('counting'));		
				$speciality->corporate = trim($request->input('corporate'));		 				
				 					
				$speciality->status = '1';				 
				$speciality->created_by =1; 	
 				
			if($speciality->save()){
				$status=1;							 
				$msg="Speciality submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Speciality could not be submitted!";	
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
		$edit_data= Speciality::findOrFail(base64_decode($id));
		 
 
        return view('admin.speciality.edit_speciality',['edit_data'=>$edit_data]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveSpeciality(Request $request,$id)
    {
        if($request->ajax()){ 		 
		  $validator = Validator::make($request->all(),[				 
			'professionals_trained' 	=> 'required|max:255|unique:web_speciality,professionals_trained,'.$id.',id',				 	
			 					
			]);

			 
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 
				$speciality = Speciality::findOrFail($id);
				$speciality->professionals_trained = trim($request->input('professionals_trained'));		
				$speciality->batches = trim($request->input('batches'));		
				$speciality->counting = trim($request->input('counting'));		
				$speciality->corporate = trim($request->input('corporate'));	
				
			 	 			
				$speciality->updated_by =1;			 
			//echo "<pre>";print_r($speciality);die;
			if($speciality->save()){
				$status=1;							 
				$msg="Speciality updated successfully!";		
				
			}else{
				$status=0;							 
				$msg="Speciality could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Speciality pagination
	public function getSpecialityPagination(Request $request)
	{
		   
	if($request->ajax()){			 
		$speciality = 	Speciality::orderBy('id','DESC');		 
		if($request->input('search.value')!==''){
				$speciality = $speciality->where(function($query) use($request){
					$query->orWhere('professionals_trained','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$speciality = $speciality->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $speciality->total();
			$returnLeads['recordsFiltered'] = $speciality->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($speciality as $special){				 
				$action="";
				$seperate="";				 					 
				$action .='<a href="/admin/speciality/edit/'.base64_encode($special->id).'" title="Edit speciality Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>  ';
				 
					$data[] = [		 		 		 
						$special->professionals_trained,					 			
						$special->batches,					 			
						$special->counting,					 			
						$special->corporate,				 				 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $special->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
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
       	 
		$speciality = Speciality::findOrFail($id);	
		  
			if($speciality->delete()){				
			$status=1;							 
			$msg="Speciality deleted successfully!";		

			}else{
			$status=0;							 
			$msg="Speciality could not be successfully!";	
			}

		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
    }
  
 
 
 
 
 
 
}
