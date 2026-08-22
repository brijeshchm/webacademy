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
use App\CourseCity;
use App\Helpers;
class CityController extends Controller
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
        return view('admin.course_city.index');
    } 
	
 
   /**
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		 
        return view('admin.course_city.index');
    } 
	 /**
	 add save City Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCity(Request $request)
    {	  
	
        if($request->ajax()){ 			
   
		  $validator = Validator::make($request->all(),[	 
			 
				'city' => 'required|unique:web_coursecity,city|max:25',				
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				
				$city = New CourseCity;
				$city->city = ucfirst(trim($request->input('city')));					 
				$city->status = '1';				 
				 	
			if($city->save()){
				$status=1;							 
				$msg="City submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="City could not be submitted!";	
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
		$edit_data= CourseCity::findOrFail(base64_decode($id)); 
        return view('admin.course_city.edit_city',['edit_data'=>$edit_data]);
    } 
	
 /**
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCity(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		 
		  $validator = Validator::make($request->all(),[				 
				'city' 	=> 'required|max:255|unique:web_coursecity,city,'.$id.',id',					
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				
				$city = CourseCity::findOrFail($id);
				$city->city = ucfirst(trim($request->input('city')));				 				 
				$city->status =1; 		
			if($city->save()){
				$status=1;							 
				$msg="City updated successfully !";		
				
			}else{
				$status=0;							 
				$msg="City could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	/**
	 get pagination city Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public function getCityPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$citys = 	CourseCity::orderBy('city','ASC');		 
		if($request->input('search.value')!==''){
				$citys = $citys->where(function($query) use($request){
					$query->orWhere('city','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$citys = $citys->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $citys->total();
			$returnLeads['recordsFiltered'] = $citys->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($citys as $city){				 
				$action="";
				$seperate="";
				$status="";
				 
				 					 
				$action .='<a href="/admin/city/edit/'.base64_encode($city->id).'" title="Edit City" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_city') ){
				$action .='<a href="javascript:cityController.delete('.$city->id.')" title="Delete City" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
				 if($city->status=='1'){
				$status .='<a href="javascript:cityController.status('.$city->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:cityController.status('.$city->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
				}
					$data[] = [		 		 		 
						$city->city,	
						$status,						
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $city->id;				 
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
       	 
		$city = CourseCity::findOrFail($id);	 
		 
			if($city->delete()){
				$status=1;							 
				$msg="City deleted successfully !";		
				
			}else{
				$status=0;							 
				$msg="City could not be Delete!";	
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
		 
		$city = CourseCity::findOrFail($id);	 
		$city->status=$val;
		 
		if($city->save()){
			$status=1;							 
			$msg="City status updated successfully!";					
			}else{
			$status=0;							 
			$msg="City status could not be successfully, Please try again !";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
  
 
 
 
 
}
