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
use App\Helpers;
use App\Models\Category;
class BlogController extends Controller
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
        return view('admin.blog.index');
    } 
	
 
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		
		$cetegories= Category::select('id','category')->where('status',1)->get();	
        return view('admin.blog.add_blog',['cetegories'=>$cetegories]);
    } 
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveBlog(Request $request)
    {	  
	 
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[	
			 
				'title' => 'required|min:20|max:75',				
				'sub_title'=>'required|min:28|max:48',			
				'rating' => 'required',				
				'total_rating' => 'required',				
				'category' => 'required',					 			
				'meta_title'=>'required|min:20|max:300',	
				'meta_keywords'=>'required|min:20|max:1160',	
				'meta_description'=>'required|min:45|max:160',	
				 				
				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
			$alt= $request->input('alt');
			
				// GENERATING SLUG
			// ***************
			$business_slug = NULL;
			$business_slug = $this->generate_slug(str_replace('?','',$request->input('title')));
			if(is_null($business_slug)){
			return redirect("/admin/blog/add");

			}
			$slugExists = DB::table('web_blog')
			->select(DB::raw('slug'))
			->where('slug', 'like', '%'.$business_slug.'%')
			->orderBy('id','desc')
			->get();
			if(count($slugExists)>0){
			$business_slug = $slugExists[0]->slug;
			$business_slug = explode("-",$business_slug);
			$end = end($business_slug);
			reset($business_slug);
			if(!is_numeric($end)){
			$business_slug[] = 1;
			}else{
			++$end;
			$business_slug[count($business_slug)-1] = $end;
			}
			$business_slug = implode("-",$business_slug);
			}

		  
				
				$blog = New Blog;
				$blog->title = ucwords(trim($request->input('title')));		
				$blog->slug  =$business_slug;					
				$blog->sub_title = ucwords($request->input('sub_title'));					 
				$blog->rating = trim($request->input('rating'));					 
				$blog->total_rating = trim($request->input('total_rating'));					 
				$blog->meta_title = $request->input('meta_title');					 
				$blog->meta_keywords = $request->input('meta_keywords');					 
				$blog->meta_description = $request->input('meta_description');					 
				 
				$blog->category = $request->input('category');	
				 							
				$blog->created_by = '1';				 
				$blog->status = '1';				 
				 	
			if($blog->save()){
				$status=1;							 
				$msg="Blog submitted successfully!";		
				
			}else{
				$status=0;							 
				$msg="Blog could not be submitted, Please try again!";	
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
		$edit_data= Blog::findOrFail(base64_decode($id)); 
		$cetegories= Category::select('id','category')->where('status',1)->get();	
		//dd($edit_data);
        return view('admin.blog.edit_blog',['edit_data'=>$edit_data,'cetegories'=>$cetegories]);
    } 
	
 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveBlog(Request $request,$id)
    {	  
 
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[	
				
				'title' => 'required|min:20|max:75',				
				'sub_title'=>'required|min:28|max:48',			
				'rating' => 'required',				
				'total_rating' => 'required',				
				'category' => 'required',					 
				'slug' => 'required',
				'meta_title'=>'required|min:30|max:160',	
				'meta_keywords'=>'required|min:20|max:1160',	
				'meta_description'=>'required|min:70|max:155',	
		 				 				
				 			
			]);
			
		  
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
				 
				$blog = Blog::findOrFail($id);
				$blog->title = ucfirst(trim($request->input('title')));		
				$blog->slug  =trim(str_replace('?','',$request->input('slug')));			
				$blog->sub_title = ucfirst($request->input('sub_title'));					 
				$blog->rating = trim($request->input('rating'));					 
				$blog->total_rating = trim($request->input('total_rating'));	
				$blog->category = trim($request->input('category'));
			 			
				$blog->meta_keywords = ucfirst($request->input('meta_keywords'));					 
				$blog->meta_description = ucfirst($request->input('meta_description'));					 
				$blog->blog_defination = ucfirst($request->input('blog_defination'));				
				$blog->heading = ucfirst($request->input('heading'));				
				$blog->blog_about = ucfirst($request->input('blog_about'));				
				
				 
			 	$blog->updated_by = '1';			
			if($blog->save()){
				$status=1;							 
				$msg="Blog updated successfully!";		
				
			}else{
				$status=0;							 
				$msg="Blog could not be updated, Please try again!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	
		
		 /**
	 * Save/update blog image and banner image.
	 *
	 * @return \Illuminate\Http\Response
	 */
	 public function editSaveImage(Request $request, $id)
{
    if (!$request->ajax()) {
        return response()->json(['status' => false, 'msg' => 'Invalid request.'], 400);
    }

    $rules = [];

    if ($request->hasFile('blog_image')) {
        $rules['blog_image'] = 'mimes:jpg,jpeg,png,webp|max:2048';
    }

    if ($request->hasFile('image_banner')) {
        $rules['image_banner'] = 'mimes:jpg,jpeg,png,webp|max:4096';
    }

    if (!empty($rules)) {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorsBag = $validator->getMessageBag()->toArray();
            return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
        }
    }

    try {
        $blogdetails = Blog::find($id);

        if (!$blogdetails) {
            return response()->json(['status' => false, 'msg' => 'Blog not found'], 404);
        }

        $oldLogoImages = [];
        $filePath = $this->getFolderBlogStructure();

        // ── Blog image ──────────────────────────────────────────────
        if ($request->hasFile('blog_image')) {
            if (!empty($blogdetails->blog_image)) {
                $existing = json_decode($blogdetails->blog_image, true);
                if (!empty($existing['blog_image']['src'])) {
                    $oldLogoImages[] = $existing['blog_image'];
                }
            }

            $destinationPath = public_path($filePath);
            $filename = $this->saveImageSmart(
                $request->file('blog_image'),
                $destinationPath,
                900,
                400
            );

            $blogImageData = [
                'blog_image' => [
                    'name'   => $filename,
                    'alt'    => $filename,
                    'width'  => '',
                    'height' => '',
                    'src'    => $filePath . '/' . $filename,
                ],
            ];

            $blogdetails->blog_image = json_encode($blogImageData);
        }

        // ── Banner image ────────────────────────────────────────────
        if ($request->hasFile('image_banner')) {
            if (!empty($blogdetails->image_banner)) {
                $existing = json_decode($blogdetails->image_banner, true);
                if (!empty($existing['image_banner']['src'])) {
                    $oldLogoImages[] = $existing['image_banner'];
                }
            }

            $destinationPath = public_path($filePath);
            $filename = $this->saveImageSmart(
                $request->file('image_banner'),
                $destinationPath,
                900,
                250
            );

            $bannerImageData = [
                'image_banner' => [
                    'name'   => $filename,
                    'alt'    => $filename,
                    'width'  => '',
                    'height' => '',
                    'src'    => $filePath . '/' . $filename,
                ],
            ];

            $blogdetails->image_banner = json_encode($bannerImageData);
        }

        if (!$blogdetails->save()) {
            return response()->json(['status' => false, 'msg' => 'Blog could not be updated'], 500);
        }

        foreach ($oldLogoImages as $oldImage) {
            $oldPath = public_path($oldImage['src']);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        return response()->json([
            'status' => true,
            'msg'    => 'Blog Description updated successfully',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'msg'    => $e->getMessage(),
        ], 500);
    }
}
	
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveContent(Request $request,$id)
    {	  
 
		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [

				'top_heading' => 'nullable|string',
				'top_content' => 'nullable|string',

			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

				$blogdetails = Blog::findOrFail($id);
 
				$blogdetails->update([
					'top_heading' => $request->top_heading,
					'top_content' => $request->top_content,
					'bottom_heading' => $request->bottom_heading,
					'bottom_content' => $request->bottom_content,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'Blog Description updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'Blog not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	        

		} 

	
	
	 /**
	 add save Course Title with slug
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveFaq(Request $request,$id)
    {	  
 
      
		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [

				'faqq1' => 'nullable|string|max:1999',
				'faqa1' => 'nullable|string|max:1999',
				'faqq2' => 'nullable|string|max:1999',
				'faqa2' => 'nullable|string|max:1999',
				'faqq3' => 'nullable|string|max:1999',
				'faqa3' => 'nullable|string|max:1999',
				'faqq4' => 'nullable|string|max:1999',
				'faqa4' => 'nullable|string|max:1999',
				'faqq5' => 'nullable|string|max:1999',
				'faqa5' => 'nullable|string|max:1999',

			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

				$blogdetails = Blog::findOrFail($id);

				$blogdetails->update([
					'faqq1' => $request->faqq1,
					'faqa1' => $request->faqa1,
					'faqq2' => $request->faqq2,
					'faqa2' => $request->faqa2,
					'faqq3' => $request->faqq3,
					'faqa3' => $request->faqa3,
					'faqq4' => $request->faqq4,
					'faqa4' => $request->faqa4,
					'faqq5' => $request->faqq5,
					'faqa5' => $request->faqa5,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'Blog FAQ updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'Blog not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

		} 

	
	
	// GET  Course pagination
	public function getBlogPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$blogs = 	Blog::orderBy('id','desc');		 
		if($request->input('search.value')!==''){
				$blogs = $blogs->where(function($query) use($request){
					$query->orWhere('title','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('sub_title','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$blogs = $blogs->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $blogs->total();
			$returnLeads['recordsFiltered'] = $blogs->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($blogs as $blog){				 
				$action="";
				$seperate="";	
				$status="";		
				$action .='<a href="/admin/blog/edit/'.base64_encode($blog->id).'" title="Edit Blog" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
				if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_blog') ){
				$action .='<a href="javascript:blogController.delete('.$blog->id.')" title="Delete Blog" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
				}
				$image ="";
				if($blog->blog_image){
				 $vimage= json_decode($blog->blog_image); 
				$image='<img src="'.asset($vimage['blog_image']['src']).'" type="'.$vimage['blog_image']['alt'].'" width="100">'; 
				}
				if($blog->status=='1'){
					$status .='<a href="javascript:blogController.status('.$blog->id.',0)" title="Course status" class="btn btn-success" >Active</a>';	
					}else{
					$status .='<a href="javascript:blogController.status('.$blog->id.',1)" title="Course status" class="btn btn-danger" >Inactive</a>';	
					}
					$data[] = [		 		 		 
						$blog->title,					 			
						$blog->slug,					 			
						$image,	
						$status,		
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $blog->id;				 
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
		 
		$blog = Blog::findOrFail($id);			 
		if($blog->blog_image!='')
		{
			$image = json_decode($blog->blog_image);
			$large = $image->blog_image->src;
			if(!empty($image->blog_image->src)){
			$thumbnail = $image->blog_image->srcs;
			if (file_exists($thumbnail))
			{
				unlink($thumbnail);
			}  
			}
			 
		}
		
		if($blog->image_banner!='')
		{
			$image = json_decode($blog->image_banner);
			$large = $image->image_banner->src;
			if(!empty($image->image_banner->src)){
			$thumbnail = $image->image_banner->src;
			if (file_exists($thumbnail))
			{
				unlink($thumbnail);
			}  
			}
			 
		}

		 
		
		if($blog->delete()){
		$status=1;							 
		$msg="Blog Deleted Successfully!";	
		}else{
		$status=0;							 
		$msg="Blog could not be Deleted!";	
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
       	 
		$delet_data = Blog::findOrFail($id); 	
		if(!empty($delet_data->image_banner))
		{		
			 
			$image = json_decode($delet_data->image_banner);
			
	 
			if(!empty($image->image_banner->src)){
			$thumbnail = $image->image_banner->src;
			if (file_exists($thumbnail))
			{
			unlink($thumbnail);
			}  
			}
			 
		 
		 
		}
 
		$edit_data = array('image_banner'  =>"",);	 
		$del = Blog::where('id',$id)->update($edit_data);			 		
		return redirect('admin/blog/edit/'.base64_encode($id))->with("success","Blog Icons deleted successfully.");
			
    }
 
 
	 /**
     * Remove the specified resource from storage del_icon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_image($id)
    {
       	 
		$delet_data = Blog::findOrFail($id); 	
		if($delet_data->blog_image!='')
		{		
			 
			$image = json_decode($delet_data->blog_image);
			
			 
			if(!empty($image->blog_image->src)){
			$thumbnail = $image->blog_image->src;
			if (file_exists($thumbnail))
			{
			unlink($thumbnail);
			}  
			}
			 
		 
		 
		}
 
		$edit_data = array('blog_image'  =>"",);	 
		$del = Blog::where('id',$id)->update($edit_data);			 		
		return redirect('admin/blog/edit/'.base64_encode($id))->with("success","image deleted successfully.");
			
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
		 
		$blog = Blog::findOrFail($id);	 
		$blog->status=$val;
		 
		if($blog->save()){
			$status=1;							 
			$msg="Blog status updated successfully !";					
			}else{
			$status=0;							 
			$msg="Blog status could not be successfully, Please try again !";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
  
 
      
    // FOLDER STRUCTURE GENERATOR
    // **************************
    function getFolderBlogStructure(){
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
    		$partial_str = 'uploads/Blog/'.date('Y').'/'.date('m').'/'.$week;
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
 private function saveImageSmart($file, $destinationPath, $width = null, $height = null)
	{
		$ext = strtolower($file->getClientOriginalExtension());
		$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$name = str_replace(' ', '_', $name);
		$filename =  time() . rand(1000,9999);

		// ✅ SVG → Save directly
		if ($ext === 'svg') {
			$finalName = $filename . '.svg';
			$file->move($destinationPath, $finalName);
			return $finalName;
		}

		// ✅ Raster → Convert to WEBP
		$imagePath = $file->getPathname();

		switch ($ext) {
			case 'jpg':
			case 'jpeg':
				$src = imagecreatefromjpeg($imagePath);
				break;
			case 'png':
				$src = imagecreatefrompng($imagePath);
				imagepalettetotruecolor($src);
				imagealphablending($src, true);
				imagesavealpha($src, true);
				break;
			case 'webp':
				$src = imagecreatefromwebp($imagePath);
				break;
			default:
				throw new \Exception('Unsupported image type');
		}

		$width = $width ?? imagesx($src);
		$height = $height ?? imagesy($src);

		$dst = imagecreatetruecolor($width, $height);
		imagealphablending($dst, false);
		imagesavealpha($dst, true);

		imagecopyresampled(
			$dst,
			$src,
			0,
			0,
			0,
			0,
			$width,
			$height,
			imagesx($src),
			imagesy($src)
		);

		$finalName = $filename . '.webp';
		imagewebp($dst, $destinationPath . '/' . $finalName, 80);

		imagedestroy($src);
		imagedestroy($dst);

		return $finalName;
	}

 
}
