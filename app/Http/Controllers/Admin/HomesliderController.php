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
use App\Homebannar;
use App\Mobilebanner;
use App\Homeslider; 
use App\Helpers;

class HomesliderController extends Controller
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
        return view('admin.homeslider.index');
    } 
	
 
   /**
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		 
        return view('admin.homeslider.index');
    } 
	 /**
	 add save City Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveHomeslider(Request $request)
    {	  
        if($request->ajax()){ 			
		  $validator = Validator::make($request->all(),[	 	 
				'slider_name' => 'required',				
				//'image' => 'required',					 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				$homeslider = New Homeslider;
				$homeslider->slider_name = trim($request->input('slider_name'));					 
				if ($request->hasFile('image_slider')) {
					$image = [];
					//$filePath = getsliderFolderStructure();
					$filePath = "uploads/slider";;
			//	$file = Input::file('course_image');
					$file =  $request->file('image_slider');
					$filename =str_replace(' ', '_', $file->getClientOriginalName());
					$alt = str_replace(' ', '_', $file->getClientOriginalName());
					$destinationPath = public_path($filePath);
					$nameArr = explode('.',$filename);
					$ext = array_pop($nameArr);
					$name = implode('_',$nameArr);
					if(file_exists($destinationPath.'/'.$filename)){
						$filename = $name."_".time().'.'.$ext;
					}
					$file->move($destinationPath,$filename);				 
					$image['image_slider'] = array(
						'name'=>$filename,
						'alt'=>$alt,						
						'src'=>$filePath."/".$filename
					);	
					$sliderimage= serialize($image);
				}else{
						$sliderimage="";
				}					
				$homeslider->image_slider = $sliderimage;	
				$homeslider->status = '1';				 
		//echo "<pre>"; print_r($homeslider);	 	
			if($homeslider->save()){
				$status=1;							 
				$msg="Home slider submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Home slider could not be submitted!";	
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
		$edit_data= Homeslider::findOrFail(base64_decode($id)); 
        return view('admin.homeslider.edit_homeslider',['edit_data'=>$edit_data]);
    } 
	
 /**
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveHomeslider(Request $request,$id)
    {	  
		//echo"<pre>";print_r($_POST);echo $id; die;
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[				 
				'slider_name' 	=> 'required',									
			]);
			if($request->hasFile('image_slider')){
				$validator = Validator::make($request->all(),[					 
				'image_slider' => 'required',		
				]);
			}
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  					
				 
				 
				$homeslider= Homeslider::findOrFail($id); 
				$homeslider->slider_name = ucfirst(trim($request->input('slider_name')));		
				//echo"<pre>"; print_r($homeslider); die;			
				if ($request->hasFile('image_slider')) {
					$image = [];
					$filePath = "uploads/slider";
					//	$file = Input::file('course_image');
					$file =  $request->file('image_slider');
					$filename =str_replace(' ', '_', $file->getClientOriginalName());	
					$alt = str_replace(' ', '_', $file->getClientOriginalName());
					$destinationPath = public_path($filePath);
					$nameArr = explode('.',$filename);
					$ext = array_pop($nameArr);
					$name = implode('_',$nameArr);
					if(file_exists($destinationPath.'/'.$filename)){
						$filename = $name."_".time().'.'.$ext;
					}
					$file->move($destinationPath,$filename);				 
					$image['image_slider'] = array(
						'name'=>$filename,
						'alt'=>$alt,						
						'src'=>$filePath."/".$filename
					);	
					$homeslider->image_slider = serialize($image);		
				}else{
					$homeslider->image_slider = $homeslider->image_slider;	
				}	
				
				$homeslider->status = '1';
				//echo"<pre>"; print_r($homeslider); die;	
				if($homeslider->save()){
					$status=1;							 
					$msg="Home Bannar Slider updated successfully !";				
				}else{
					$status=0;							 
					$msg="Home Bannar Slider could not be updated!";	
				}
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
		}
    } 
	
	
	public function del_icon($id)
    {
       	 
		$delet_data = Homeslider::findOrFail($id);	 
		if($delet_data->image_slider!='')
		{				 
			$image = json_decode($delet_data->image_slider);			
			$large = $image['image_slider']['src'];
			if(!empty($image['image_slider']['src'])){
			$thumbnail = $image['image_slider']['src'];
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
 
		$edit_data = array('image_slider'  =>"",);	 
		$del = Homeslider::where('id',$id)->update($edit_data);			 		
		return redirect('admin/homeslider/edit/'.base64_encode($id))->with("success","image slider deleted successfully.");
			
    }

	/**
	 get pagination city Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public function getHomesliderPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$homesliders = 	Homeslider::orderBy('slider_name','ASC');		 
		if($request->input('search.value')!==''){
				$homesliders = $homesliders->where(function($query) use($request){
					$query->orWhere('slider_name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$homesliders = $homesliders->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $homesliders->total();
			$returnLeads['recordsFiltered'] = $homesliders->total();
			$returnLeads['recordCollection'] = [];
				$i=0;
			foreach($homesliders as $sliders){				 
				$action="";
				$seperate="";
				$status="";
				 $i++;		 
				$action .='<a href="/admin/homeslider/edit/'.base64_encode($sliders->id).'" title="Edit sliders" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_city') ){
				//	$action .='<a href="javascript:homesliderController.delete('.$sliders->id.')" title="Delete sliders" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				} 
				if($sliders->status=='1'){
					$status .='<a href="javascript:homesliderController.status('.$sliders->id.',0)" title="sliders status" class="btn btn-success">Active</a>';	
				}else{
					$status .='<a href="javascript:homesliderController.status('.$sliders->id.',1)" title="sliders status" class="btn btn-danger">Inactive</a>';
				}
				$vimage= json_decode($sliders->image_slider);
				$image='<img src="'.asset($vimage['image_slider']['src']).'" type="'.$vimage['image_slider']['alt'].'" width="50">';	
					$data[] = [		
						$i,					
						$sliders->slider_name,	
						$image,	
						$status,						
						$action,					  	 
					];
				$returnLeads['recordCollection'][] = $sliders->id;				 
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
       	 
		$homeslider = Homeslider::findOrFail($id);	 
		// echo "<pre>";print_r($homebannar);
			if($homeslider->delete()){
				$status=1;							 
				$msg="Home slider deleted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Home slider could not be Delete!";	
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
		 
		$homeslider = Homeslider::findOrFail($id);	 
		$homeslider->status=$val;
		 
		if($homeslider->save()){
			$status=1;							 
			$msg="Home sliders status updated successfully!";					
			}else{
			$status=0;							 
			$msg="Home sliders status could not be successfully, Please try again !";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
    
    
    //*********Mobile Homer banner
 
	public function getmobilebannerPagination(Request $request)
	{   
		if($request->ajax()){			 
		$mobilebanner = 	Mobilebanner::orderBy('banner_name','ASC');		 
		if($request->input('search.value')!==''){
				$mobilebanner = $mobilebanner->where(function($query) use($request){
					$query->orWhere('banner_name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$mobilebanner = $mobilebanner->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $mobilebanner->total();
			$returnLeads['recordsFiltered'] = $mobilebanner->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($mobilebanner as $mobBanner){				 
				$action="";
				$seperate="";
				$status="";
				  					 
				$action .='<a href="/admin/mobilebanner/edit/'.base64_encode($mobBanner->id).'" title="Edit mobile Banner" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';

				//	$action .='<a href="javascript:homesliderController.deleteBanner('.$mobBanner->id.')" title="Delete mobile Banner" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
			
				if($mobBanner->status=='1'){
					$status .='<a href="javascript:homesliderController.statusBanner('.$mobBanner->id.',0)" title="mobile Banner status" class="btn btn-success">Active</a>';	
				}else{
					$status .='<a href="javascript:homesliderController.statusBanner('.$mobBanner->id.',1)" title="mobile Banner status" class="btn btn-danger">Inactive</a>';
				}
				$vimage= json_decode($mobBanner->image_banner);
				$image='<img src="'.asset($vimage['image_banner']['src']).'" type="'.$vimage['image_banner']['alt'].'" width="50">';	
					$data[] = [		 		 		 
						$mobBanner->banner_name,	
						$image,	
						$status,						
						$action,					  	 
					];
				$returnLeads['recordCollection'][] = $mobBanner->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
		}  
		
	}
	
	
	
	
	 public function mobileBannerEdit(Request $request,$id)
    {	  
		$edit_data= Mobilebanner::findOrFail(base64_decode($id)); 
        return view('admin.homeslider.edit_mobilebanner',['edit_data'=>$edit_data]);
    } 
 
	
	 public function editMobilebanner(Request $request,$id)
    {	  
	//	echo"<pre>";print_r($_POST);echo $id; die;
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[				 
				'banner_name' 	=> 'required',									
			]);
			if($request->hasFile('image_banner')){
				$validator = Validator::make($request->all(),[					 
			//	'image_banner' => 'required|mimes:jpeg,png,jpg,svg,JPG,JPEG',
					'image_banner' => 'required',
				]);
			}
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  					
				 
				 
				$mobilebanner= Mobilebanner::findOrFail($id); 
				$mobilebanner->banner_name = ucfirst(trim($request->input('banner_name')));		
				//echo"<pre>"; print_r($mobilebanner); die;			
				if ($request->hasFile('image_banner')) {
					$image = [];
					//$filePath = getContentFolderStructure();
					$filePath = 'uploads/mobilebanner/';
					//	$file = Input::file('course_image');
					$file =  $request->file('image_banner');
					$filename =str_replace(' ', '_', $file->getClientOriginalName());		
					$alt = str_replace(' ', '_', $file->getClientOriginalName());
					$destinationPath = public_path($filePath);
					$nameArr = explode('.',$filename);
					$ext = array_pop($nameArr);
					$name = implode('_',$nameArr);
					if(file_exists($destinationPath.'/'.$filename)){
						$filename = $name."_".time().'.'.$ext;
					}
					$file->move($destinationPath,$filename);				 
					$image['image_banner'] = array(
						'name'=>$filename,
						'alt'=>$alt,						
						'src'=>$filePath."/".$filename
					);	
					$mobilebanner->image_banner = serialize($image);		
				}else{
					$mobilebanner->image_banner = $mobilebanner->image_banner;	
				}	
				
				$mobilebanner->status = '1';
				//echo"<pre>"; print_r($mobilebanner); die;	
				if($mobilebanner->save()){
					$status=1;							 
					$msg="Home Bannar Slider updated successfully !";				
				}else{
					$status=0;							 
					$msg="Home Bannar Slider could not be updated!";	
				}
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
		}
    } 
	
	 public function deleteBanner($id)
    {
       	 
		$mobilebanner = Mobilebanner::findOrFail($id);	 
		// echo "<pre>";print_r($homebannar);
			if($mobilebanner->delete()){
				$status=1;							 
				$msg="Mobile Home Banner deleted successfully !";		
				
			}else{
				$status=0;							 
				$msg="Mobile Home Banner could not be Delete!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
    }
  

	  public function statusBanner(request $request, $id,$val)
		{
			 if($request->ajax()){	 
				$mobilebanner = Mobilebanner::findOrFail($id);	 
				$mobilebanner->status=$val;
			 
			if($mobilebanner->save()){
				$status=1;							 
				$msg="Home sliders status updated successfully!";					
				}else{
				$status=0;							 
				$msg="Home sliders status could not be successfully, Please try again !";	
				}		
				return response()->json(['status'=>$status,'msg'=>$msg],200); 
			 }
		}
		
		public function del_icon_banner($id)
		{       	 
			$delet_data = Mobilebanner::findOrFail($id);	 
			if($delet_data->image_banner!='')
			{				 
				$image = json_decode($delet_data->image_banner);			
				$large = $image['image_banner']['src'];
				if(!empty($image['image_banner']['src'])){
				$thumbnail = $image['image_banner']['src'];
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
	 
			$edit_data = array('image_banner'  =>"",);	 
			$del = Mobilebanner::where('id',$id)->update($edit_data);			 		
			return redirect('admin/mobilebanner/edit/'.base64_encode($id))->with("success","image Mobile Banner deleted successfully.");
				
		}
  
 
 
 
 
}
