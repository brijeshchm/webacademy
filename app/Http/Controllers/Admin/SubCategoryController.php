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
class SubCategoryController extends Controller
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
        return view('admin.subcategory.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {	  
		 $categories = Category::orderBy('category','asc')->get();
        return view('admin.subcategory.index',['categories'=>$categories]);
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSubCategory(Request $request)
    {	  
	
        if($request->ajax()){ 
		 //echo "<pre>";print_r($_POST);die;
			
  
		  $validator = Validator::make($request->all(),[		 
			 
				'category' => 'required',				
							
				'subcategory' => 'required|unique:web_subcategory,subcategory|max:255',	
				'course_icons' => 'required|max:120|dimensions:min_width=49,min_height=49,max_width=55,max_height=55',		 
			//	'course_image' => 'required|mimes:jpeg,png,jpg,svg|max:5',	
				'course_image' => 'required|max:200|dimensions:min_width=200,min_height=180,max_width=300,max_height=200',	
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				
				$category = New SubCategory;
				$category->category = trim($request->input('category'));					 
				$category->subcategory = ucfirst(trim($request->input('subcategory')));		
				$alt= $request->input('subcategory');	
				if ($request->hasFile('course_icons')) {
				$image = [];
				$filePath = $this->getCourseFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('course_icons');
				$iconsfilename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$iconsfilename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$iconsfilename)){
				$iconsfilename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$iconsfilename);				 
				$image['course_icons'] = array(
				'name'=>$iconsfilename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$iconsfilename
				);	
				} 			
				$category->course_icons = serialize($image);

				if ($request->hasFile('course_image')) {
				$courseimage = [];
				$filePath = $this->getCourseFolderStructure();
			//	$file = Input::file('course_image');
				$file =  $request->file('course_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$courseimage['course_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				} 			
				$category->course_image = serialize($courseimage);					
				$category->status = '1';				 
				$category->created_by =1; 	
 				
			if($category->save()){
				$status=1;							 
				$msg="Sub Category Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Sub Category Successfully !";	
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
		$categories = Category::orderBy('category','asc')->get();
		$edit_data= SubCategory::findOrFail(base64_decode($id)); 
        return view('admin.subcategory.edit_subcategory',['edit_data'=>$edit_data,'categories'=>$categories]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveSubCategory(Request $request,$id)
    {	  
	
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[				 
		'category' 	=> 'required',					
		'subcategory' 	=> 'required|max:255|unique:web_subcategory,subcategory,'.$id.',id',		
		'course_icons' => 'required',			
		'course_image' => 'required',			
		 		
			]);
		//	ECHO $request->hasFile('course_icons');DIE;
			if($request->hasFile('course_icons')){
				 $validator = Validator::make($request->all(),[				
				  //   'course_icons' => 'required|mimes:jpeg,png,jpg,svg|max:2',		 
				'course_icons' => 'required|mimes:jpeg,png,jpg,svg|max:2|dimensions:min_width=45,min_height=45,max_width=55,max_height=55',		 			
			]);
			} 
			if($request->hasFile('course_image')){
				 $validator = Validator::make($request->all(),[					 
				//'course_image' => 'required|mimes:jpeg,png,jpg,svg|max:5',	
				'course_image' => 'required|mimes:jpeg,png,jpg,svg|max:6|dimensions:min_width=280,min_height=180,max_width=300,max_height=200',	
			]);
			} 
			
			//echo "<pre>";print_r($_POST);die;  
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				
				$subcategory = SubCategory::findOrFail($id);
				$subcategory->category = trim($request->input('category'));				 				 
				$subcategory->subcategory = ucwords(trim($request->input('subcategory')));		
				$alt =$request->input('subcategory');
				if ($request->hasFile('course_icons')) {
				$icons = [];
				$filePath = $this->getCourseFolderStructure();
				//	$file = Input::file('course_image');
				$file =  $request->file('course_icons');
				$iconsfilename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$iconsfilename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$iconsfilename)){
				$iconsfilename = $name."_".time().'.'.$ext;
				}
				
				 
				$file->move($destinationPath,$iconsfilename);				 
				$icons['course_icons'] = array(
				'name'=>$iconsfilename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$iconsfilename
				);	
				$subcategory->course_icons = serialize($icons);		
				}else{
				$subcategory->course_icons = $subcategory->course_icons;	
				}		

				if ($request->hasFile('course_image')) {
				$image = [];
				$filePath = $this->getCourseFolderStructure();
				//	$file = Input::file('course_image');
				$file =  $request->file('course_image');
				$filename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$filename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$filename)){
				$filename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$filename);				 
				$image['course_image'] = array(
				'name'=>$filename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$filename
				);	
				$subcategory->course_image = serialize($image);		
				}else{
				$subcategory->course_image = $subcategory->course_image;	
				}						
				$subcategory->updated_by =1; 		
			if($subcategory->save()){
				$status=1;							 
				$msg="Sub Category Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Sub Category Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getSubCategoryPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$subcategories = 	SubCategory::orderBy('id','DESC');		 
		if($request->input('search.value')!==''){
				$subcategories = $subcategories->where(function($query) use($request){
					$query->orWhere('subcategory','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$subcategories = $subcategories->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $subcategories->total();
			$returnLeads['recordsFiltered'] = $subcategories->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($subcategories as $category){				 
				$action="";
				$seperate="";				 					 
				$status="";				 					 
				$action .='<a href="/admin/subcategory/edit/'.base64_encode($category->id).'" title="Edit Sub Course Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_subcategory') ){
				$action .='<a href="javascript:subCategoryController.delete('.$category->id.')" title="Delete Sub Course Content" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
				if($category->course_icons){
				$vicons= json_decode($category->course_icons); 
				$icons='<img src="'.asset($vicons['course_icons']['src']).'" type="'.$vicons['course_icons']['alt'].'" width="100">'; 
                }else{
    
                    $icons= "";
                    }

                if($category->course_image){
				$vimage= json_decode($category->course_image); 
				$image='<img src="'.asset($vimage['course_image']['src']).'" type="'.$vimage['course_image']['alt'].'" width="100">'; 	
				
                }else{
    
                    $image="";
                    }
				
				if(!empty($category->category)){
				 $categoryn= Category::findOrFail($category->category);
				 if(!empty($categoryn)){
					 $categoryname= $categoryn->category;					 
				 }else{
					 $categoryname="";
				 }
				}else{
					$categoryname="";
				}
				 if($category->status=='1'){
				$status .='<a href="javascript:subCategoryController.status('.$category->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
				}else{
				$status .='<a href="javascript:subCategoryController.status('.$category->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
				}
				 
					$data[] = [		 		 		 
						$categoryname,					 			
						$category->subcategory,	
						$icons,						
						$image,		
						$status,					
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $category->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
		}  
		
	}
	
	
	
 /**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSubCategoryPDF(Request $request)
    {
        
		$id = $request->input('cid'); 
		$sid = $request->input('sid'); 
		 
		$subcategory_data =SubCategory::where('category',$id)->where('status',1)->get();
		
		/* 
		$subcategory_data= DB::table('web_coursepdf as pdf');		 
		$subcategory_data  =$subcategory_data->join('web_subcategory as subcategory','pdf.subcategory','=','subcategory.id','left');
		$subcategory_data= $subcategory_data->select('pdf.*','subcategory.id as subcategoryid','subcategory.subcategory as subcategoryname','subcategory.category as categoryname');
		$subcategory_data= $subcategory_data->groupby('pdf.subcategory');
		$subcategory_data= $subcategory_data->where('pdf.category',$id);
		$subcategory_data= $subcategory_data->where('pdf.status',1)->get(); */


		
		//echo "<pre>";print_r($subcategory_data);die;
		if($subcategory_data){ 
		echo '<option value="">Select sub Category</option>';
		foreach($subcategory_data as $subcategory){ 
		$selected = ($sid==$subcategory->id)?"selected":'';

		echo'<option value="'.$subcategory->id.'" '.$selected.' >'.$subcategory->subcategory.'</option>';

		}
		} else { 
		echo'<option value="">No record found</option>';
		}
		
	}
 /**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCoursePdf(Request $request)
    {
        
		$id = $request->input('sid'); 
		$pid = $request->input('pid'); 
		 
	//	$subcategory_data =SubCategory::where('category',$id)->where('status',1)->get();
		
		
		$subcategory_data= DB::table('web_coursepdf as pdf');	 		
		$subcategory_data= $subcategory_data->select('pdf.*','pdf.id as pdfid');
	//	$subcategory_data= $subcategory_data->groupby('pdf.subcategory');
		$subcategory_data= $subcategory_data->where('pdf.subcategory',$id);
		$subcategory_data= $subcategory_data->where('pdf.status',1)->get();


		
		//echo "<pre>";print_r($subcategory_data);die;
		if($subcategory_data){ 
		echo '<option value="">Select Course PDF</option>';
		foreach($subcategory_data as $subcategory){ 
		$selected = ($pid==$subcategory->coursePdfText)?"selected":'';

		echo'<option value="'.$subcategory->coursePdfText.'" '.$selected.' >'.$subcategory->coursePdfText.'</option>';

		}
		} else { 
		echo'<option value="">No record found</option>';
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
       	 
		$subcategory = SubCategory::findOrFail($id);	 
		// echo "<pre>";print_r($category);die;
		
			if($subcategory->course_icons!='')
			{				 
				$image = json_decode($subcategory->course_icons);			
				$large = $image['course_icons']['src'];
				if(!empty($image['course_icons']['src'])){
				$thumbnail = $image['course_icons']['src'];
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
			
			if($subcategory->course_image!='')
			{				 
				$image = json_decode($subcategory->course_image);			
				$large = $image['course_image']['src'];
				if(!empty($image['course_image']['src'])){
				$thumbnail = $image['course_image']['src'];
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
			
			if($subcategory->delete()){
				$status=1;							 
				$msg="Sub Category Delete Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Not Sub Category Delete Successfully !";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
    }
  
 
 /**
     * Return the specified resource from storage.
     *
     * @param  obj  Request object
     * @param  int  $id
     * @return Json Response
     */
	public function getSubCourseAjax(Request $request, $id){
		if($request->ajax()){
			$subCategory = SubCategory::where('category',$id)->select('id','subcategory')->where('status',1)->orderBy('subcategory','DESC')->get();
			// echo "<pre>";print_r($messages);die;
			return response()->json($subCategory,200);
		} 
	}
 
	/**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSubCategory(Request $request)
    {
        
		$id = $request->input('cid'); 
		$sid = $request->input('sid'); 
		 
		$subcategory_data =SubCategory::where('category',$id)->where('status',1)->get();		
		//echo "<pre>";print_r($subcategory_data);die;
		if($subcategory_data){ 
		echo '<option value="">Select sub Categpry</option>';
		foreach($subcategory_data as $subcategory){ 
		$selected = ($sid==$subcategory->id)?"selected":'';

		echo'<option value="'.$subcategory->id.'" '.$selected.' >'.$subcategory->subcategory.'</option>';

		}
		} else { 
		echo'<option value="">No record found</option>';
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
       	 
		$delet_data = SubCategory::findOrFail($id);	 
		if($delet_data->course_icons!='')
		{			 
			$image = json_decode($delet_data->course_icons);			
			$large = $image['course_icons']['src'];
			if(!empty($image['course_icons']['src'])){
			$thumbnail = $image['course_icons']['src'];
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
		$edit_data = array('course_icons'  =>"",);	 
		$del = SubCategory::where('id',$id)->update($edit_data);			 		
		return redirect('admin/subcategory/edit/'.base64_encode($id))->with("success","Icons deleted successfully.");
			
    }
	
	
	
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_image($id)
    {
       	 
		$delet_data = SubCategory::findOrFail($id);	 
		if($delet_data->course_image!='')
		{			 
			$image = json_decode($delet_data->course_image);			
			$large = $image['course_image']['src'];
			if(!empty($image['course_image']['src'])){
			$thumbnail = $image['course_image']['src'];
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
		$edit_data = array('course_image'  =>"",);	 
		$del = SubCategory::where('id',$id)->update($edit_data);			 		
		return redirect('admin/subcategory/edit/'.base64_encode($id))->with("success","image deleted successfully.");
			
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
		 
		$category = SubCategory::findOrFail($id);	 
		$category->status=$val;
		//echo "<pre>";print_r($category);die;
		if($category->save()){
			$status=1;							 
			$msg="Sub Category Status Successfully !";					
			}else{
			$status=0;							 
			$msg="Not Sub Category Status Successfully !";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
  
  
  
// FOLDER STRUCTURE GENERATOR
// **************************
function getCourseFolderStructure(){
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
		$partial_str = 'uploads/Course/'.date('Y').'/'.date('m').'/'.$week;
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
