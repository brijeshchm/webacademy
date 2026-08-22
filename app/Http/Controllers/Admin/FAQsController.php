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
use App\Helpers;
class FAQsController extends Controller
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
        return view('admin.FAQ.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		 
        return view('admin.FAQ.index');
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveFAQs(Request $request)
    {	  
	  //echo "<pre>";print_r($_POST);die;
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[	
			 
				'question' => 'required|unique:web_faqs,question|max:250',				
				'answer' => 'required|unique:web_faqs,answer|max:2000',				
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				
				$FAQs = New FAQs;
				$FAQs->question = ucwords(trim($request->input('question')));					 
				$FAQs->answer = ucwords(trim($request->input('answer')));					 
				$FAQs->status = '1';				 
				 	
			if($FAQs->save()){
				$status=1;							 
				$msg="FAQs submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="FAQs could not be submitted, Please try again!";	
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
		$edit_data= FAQs::findOrFail(base64_decode($id)); 
        return view('admin.FAQ.edit_faq',['edit_data'=>$edit_data]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveFAQs(Request $request,$id)
    {	  
	// echo "<pre>";print_r($_POST);die;  
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[				 
				'question' 	=> 'required|max:255|unique:web_faqs,question,'.$id.',id',					
				'answer' 	=> 'required|max:2000|unique:web_faqs,answer,'.$id.',id',					
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				
				$FAQs = FAQs::findOrFail($id);
				$FAQs->question = ucwords(trim($request->input('question')));				 				 
				$FAQs->answer = ucwords(trim($request->input('answer')));				 				 
			 	
			if($FAQs->save()){
				$status=1;							 
				$msg="FAQs updated successfully!";		
				
			}else{
				$status=0;							 
				$msg="FAQs could not be updated!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getFAQsPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$faqs = 	FAQs::orderBy('id','desc');		 
		if($request->input('search.value')!==''){
				$faqs = $faqs->where(function($query) use($request){
					$query->orWhere('question','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('answer','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$faqs = $faqs->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $faqs->total();
			$returnLeads['recordsFiltered'] = $faqs->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($faqs as $faq){				 
				$action="";
				$seperate="";				 					 
				$action .='<a href="/admin/FAQs/edit/'.base64_encode($faq->id).'" title="Edit FAQs" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_faq') ){
				$action .='<a href="javascript:FAQsController.delete('.$faq->id.')" title="Delete FAQs" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
					$data[] = [		 		 		 
						$faq->question,					 			
						$faq->answer,				
						 				 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $faq->id;				 
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
       	 
		$faq = FAQs::findOrFail($id);		 
			if($faq->delete()){
				$status=1;							 
				$msg="FAQs deleted successfully!";		
				
			}else{
				$status=0;							 
				$msg="FAQs could not be deleted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
    }
  
 
 
 
 
 
 
}
