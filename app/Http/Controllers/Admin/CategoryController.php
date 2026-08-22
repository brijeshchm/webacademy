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
use App\Models\Course;
use App\Models\Category;
use App\Models\SubCategory;
use App\Helpers;
class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
         ////$this->middleware('auth');
	   
    }

    /**
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {	 
	 
        return view('admin.category.index');
    } 
	
 
   /**
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {	  
		 
        return view('admin.category.index');
    } 
	 /**
	 add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCategory(Request $request)
    {	  
	
        if($request->ajax()){			
  
		  $validator = Validator::make($request->all(),[			 
				'category' => 'required|unique:web_categories,category|max:255',				 		
			//	'category_icons' => 'required|mimes:jpeg,png,jpg,svg|max:2|dimensions:min_width=40,min_height=35,max_width=55,max_height=55',	
				//'video_link' => 'required',		
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 	
				$category = New Category;
				$category->category = ucfirst(trim($request->input('category')));	
				$category->category_slug = $this->generate_slug(str_replace('?','',$request->input('category')));
				$category->video_link =trim($request->input('video_link'));		
				$alt= $request->input('category');	
				if ($request->hasFile('category_icons')) {
				$image = [];
				$filePath = $this->getCategoryFolderStructure();
			 
				$file =  $request->file('category_icons');
				$iconsfilename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$iconsfilename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$iconsfilename)){
				$iconsfilename = $name."_".time().'.'.$ext;
				}
				$file->move($destinationPath,$iconsfilename);				 
				$image['category_icons'] = array(
				'name'=>$iconsfilename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$iconsfilename
				);	
							
				$category->category_icons = serialize($image);
			}
				$category->status = '1';				 
				$category->created_by =1; 		
			if($category->save()){
				$status=1;							 
				$msg="Category Submitted Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Category could not be submitted, please try again!";	
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
		$edit_data= Category::findOrFail(base64_decode($id)); 
        return view('admin.category.edit_category',['edit_data'=>$edit_data]);
    } 
	
 /**
	 * add save Course Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveCategory(Request $request,$id)
    {	  
	
        if($request->ajax()){ 		 
		  $validator = Validator::make($request->all(),[					 
			'category' 	=> 'required|max:255|unique:web_categories,category,'.$id.',id',	
			'category_icons' => 'required',			
			]);
			if($request->hasFile('category_icons')){
				 $validator = Validator::make($request->all(),[					 
				'category_icons' => 'required|mimes:jpeg,png,jpg,svg|max:2|dimensions:min_width=40,min_height=38,max_width=55,max_height=55',		 			
			]);
			} 
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 
				$category = Category::findOrFail($id);
				$category->category = ucfirst(trim($request->input('category')));
				$category->video_link =trim($request->input('video_link'));	
				$alt =$request->input('category');
				if ($request->hasFile('category_icons')) {
				$icons = [];
				$filePath = $this->getCategoryFolderStructure();				 
				$file =  $request->file('category_icons');
				$iconsfilename =str_replace(' ', '_', $file->getClientOriginalName());			 
				$destinationPath = public_path($filePath);
				$nameArr = explode('.',$iconsfilename);
				$ext = array_pop($nameArr);
				$name = implode('_',$nameArr);
				if(file_exists($destinationPath.'/'.$iconsfilename)){
				$iconsfilename = $name."_".time().'.'.$ext;
				}
				
				 
				$file->move($destinationPath,$iconsfilename);				 
				$icons['category_icons'] = array(
				'name'=>$iconsfilename,
				'alt'=>$alt,						
				'src'=>$filePath."/".$iconsfilename
				);	
				$category->category_icons = serialize($icons);		
				}else{
				$category->category_icons = $category->category_icons;	
				}					
				$category->updated_by =1; 					
			if($category->save()){
				$status=1;							 
				$msg="Category updated successfully !";		
				
			}else{
				$status=0;							 
				$msg="Category could not be updated, please try again!!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	 /**
	 * Category pagination Title with slug
     * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

public function getCategoryPagination(Request $request)
{
    if (!Auth::user()->current_user_can('administrator') && !Auth::user()->current_user_can('view_category')) {
        return response()->json(['status' => 0, 'msg' => 'Unauthorized'], 403);
    }

    if (!$request->ajax()) {
        return response()->json(['status' => 0, 'msg' => 'Invalid request'], 400);
    }

    try {
        $categories = Category::orderBy('id', 'DESC');

        if ($request->filled('search.value')) {
            $searchVal = $request->input('search.value');
            $categories = $categories->where(function ($query) use ($searchVal) {
                $query->where('category', 'LIKE', '%' . $searchVal . '%')
                      ->orWhere('id', 'LIKE', '%' . $searchVal . '%');
            });
        }

        $perPage = (int) $request->input('length');
        $categories = $categories->paginate($perPage > 0 ? $perPage : 25);

        $returnLeads = [
            'draw'             => $request->input('draw'),
            'recordsTotal'     => $categories->total(),
            'recordsFiltered'  => $categories->total(),
            'recordCollection' => [],
            'data'             => [],
        ];

        foreach ($categories as $category) {
            $icons = '';

      if (!empty($category->category_icons)) {
    // Suppress the E_WARNING unserialize() throws on malformed data, check return value instead
    $vicons = @unserialize($category->category_icons, ['allowed_classes' => false]);

    if ($vicons !== false && isset($vicons['category_icons']['src'])) {
        $icons = '<img src="' . asset($vicons['category_icons']['src']) . '" alt="' . e($vicons['category_icons']['alt'] ?? '') . '" width="100">';
    }
}

            $action = '<a href="/admin/category/edit/' . base64_encode($category->id) . '" title="Edit Course Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a> ';

            if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_category')) {
                if ($category->id != 32) {
                    $action .= '<a href="javascript:categoryController.delete(' . $category->id . ')" title="Delete Course Content" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
            }

            if ($category->status == '1') {
                $status = '<a href="javascript:categoryController.status(' . $category->id . ',0)" title="Course status" class="btn btn-success">Active</a>';
            } else {
                $status = '<a href="javascript:categoryController.status(' . $category->id . ',1)" title="Course status" class="btn btn-danger">Inactive</a>';
            }

            $returnLeads['data'][] = [
                $category->category,
                $icons,
                $status . ' ' . $action,
            ];
            $returnLeads['recordCollection'][] = $category->id;
        }

        return response()->json($returnLeads);

    } catch (\Exception $e) {
        \Log::error('getCategoryPagination failed: ' . $e->getMessage());
        return response()->json(['status' => 0, 'msg' => 'Something went wrong.'], 500);
    }
}

	public function getCategoryPagination_old(Request $request)
	{	 
		if($request->ajax()){			 
		$categories = 	Category::orderBy('id','DESC');		 
		if($request->input('search.value')!==''){
				$categories = $categories->where(function($query) use($request){
					$query->orWhere('category','LIKE','%'.$request->input('search.value').'%')->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$categories = $categories->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $categories->total();
			$returnLeads['recordsFiltered'] = $categories->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($categories as $category){				 
				$action="";
				$seperate="";
				$status="";
				$icons="";

				if(!empty($category->category_icons)){
					$vicons= json_decode($category->category_icons); 
					$icons='<img src="'.asset($vicons['category_icons']['src']).'" type="'.$vicons['category_icons']['alt'].'" width="100">'; 	
				}
				
			

					$action .='<a href="/admin/category/edit/'.base64_encode($category->id).'" title="Edit Course Content" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>  ';
					if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_category') ){
					if($category->id==32){
					}else{
					$action .='<a href="javascript:categoryController.delete('.$category->id.')" title="Delete Course Content" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
					}
					}
					if($category->status=='1'){
					$status .='<a href="javascript:categoryController.status('.$category->id.',0)" title="Course status" class="btn btn-success">Active</a>';	
					}else{
					$status .='<a href="javascript:categoryController.status('.$category->id.',1)" title="Course status" class="btn btn-danger">Inactive</a>';	
					}
					
					$data[] = [		 		 		 
						$category->category,				 			
						$icons,						 
						$status.' '.$action,					  
				
					];
					$returnLeads['recordCollection'][] = $category->id;				 
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
       	 
		$delet_data = Category::findOrFail($id);	 
		if($delet_data->category_icons!='')
		{				 
			$image = json_decode($delet_data->category_icons);			
			$large = $image['category_icons']['src'];
			if(!empty($image['category_icons']['src'])){
			$thumbnail = $image['category_icons']['src'];
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
 
		$edit_data = array('category_icons'  =>"",);	 
		$del = Category::where('id',$id)->update($edit_data);			 		
		return redirect('admin/category/edit/'.base64_encode($id))->with("success","Image deleted successfully.");
			
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
		 
		$category = Category::findOrFail($id);	 
		$category->status=$val;
		 
		if($category->save()){
			$status=1;							 
			$msg="Category status updated successfully !";					
			}else{
			$status=0;							 
			$msg="Category status could not be successfully, Please try again !";	
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
       	 
		$category = Category::findOrFail($id);	 
	
		if($category->category_icons!='')
			{				 
			$image = json_decode($category->category_icons);			
			$large = $image['category_icons']['src'];
			if(!empty($image['category_icons']['src'])){
			$thumbnail = $image['category_icons']['src'];
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
	
	
		$subCategory= SubCategory::where('category',$category->id)->get()->count();
			 
		if(!empty($subCategory)){			

			
			
			$status=0;							 
			$msg="First Delete of Sub Category then delete category!";				 
		}else if($category->delete()){
			
			
				$status=1;							 
				$msg="Category Deleted Successfully!";		
				
			}else{
				$status=0;							 
				$msg="Category could not be deleted!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
	 
    }
  
 
 
 
 
 /**
     * the specified resource fetch from subcuisine according to cuisine id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getvideolink(Request $request)
    {
        
		$id = $request->input('cid'); 
		$cc_id = $request->input('cc_id'); 
	 
	/* 	$course_data =Course::where('id',$cc_id)->first();	
		if(!empty($course_data->video_link)){		  
		 echo $course_data->video_link;		 
		}else{
			$category_data =Category::where('id',$id)->first();			 
		if($category_data){ 
		 echo $category_data->video_link;
		}else{ 
		echo '';
		}
			
		}
		 */
		
		$category_data =Category::where('id',$id)->first();			 
		if($category_data){ 
		 echo $category_data->video_link;
		}else{ 
		echo '';
		}
		
		
	}
 
 
 
// FOLDER STRUCTURE GENERATOR
// **************************
function getCategoryFolderStructure(){	 
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
		$partial_str = 'uploads/Category/'.date('Y').'/'.date('m').'/'.$week;
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
 
 


     function generate_slug($slug=null){
	if(is_null($slug)){
		return null;
	}
	$slug = explode(" ",$slug);
	$slug = array_map('trim',$slug);
	//$slug = array_map('remove_splchars',$slug);
	$slug = array_map('strtolower',$slug);
	$slug = implode("-",$slug);
	return $slug;
}
 
}
