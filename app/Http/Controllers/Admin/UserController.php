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
use App\Models\Placement;
use App\Models\Careers;
use App\Models\Courses;
use App\Helpers;
use App\Models\User;
use App\Models\Permission;
use App\Models\Capability;
class UserController extends Controller
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
        return view('admin.user.index');
    } 
	
 
   /**
   * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {		
		 
        return view('admin.user.index');
    } 
	 /**
		add save Careers Title with slug
   * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUser(Request $request)
    {	
	
	 
        if($request->ajax()){ 
		  $validator = Validator::make($request->all(),[			 
				'name' => 'required|max:35',		
				'email' => 'required|email|unique:users,email',				
				'mobile' => 'required',	
				'role' => 'required',				
				'capabilities' => 'required',	
				'password' => 'required|min:6',
				'password_confirmation' => 'required_with:password|same:password|min:6'				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
			 
				
				$user = New user;
				$user->name = ucwords(trim($request->input('name')));		
				$user->email = $request->input('email');					 					
				$user->mobile =$request->input('mobile');	
			 					 
				$user->role = trim($request->input('role'));					 
				$user->password = trim(bcrypt($request->input('password')));					 
								 
			 						
				$user->created_by = '1';				 
				$user->status = '1';				 
				 	// echo "<pre>";print_r($user);die;
			if($user->save()){
				
				$add_capbilities = array(
					 'user_id'=>$user->id,
					 'capabilities'=>json_encode($request->input('capabilities')),					 
					 );
				
				$capability = DB::table('web_capabilities')->insert($add_capbilities);	 
				$status=1;							 
				$msg="User Created submitted successfully !";		
				
			}else{
				$status=0;							 
				$msg="User could not be submitted, please try again!";	
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
		$edit_data= User::findOrFail(base64_decode($id)); 	

	
		 $capabilities = Capability::where('user_id',$edit_data->id)->first(); 	
		 
		
		$permissions = Permission::all();  
		if(!empty($capabilities)){
			  
			if(isset($capabilities->capabilities) && !is_null($capabilities->capabilities)){
				$capabilities = unserialize($capabilities->capabilities);
			}
		}else{
			$capabilities = [];
		}

        return view('admin.user.update-user',['edit_data'=>$edit_data,'permissions'=>$permissions,'userCaps'=>$capabilities,]);
    } 
	
	
	
	
	public function updateUser(Request $request, User $user, $id){
		
		$user_id = base64_decode($id);
		$user = User::find($user_id);	 
 
		$capabilities = Capability::where('user_id',$user->id)->first();

		$edit_data = Capability::where('user_id',$user->id)->first();		
		$permissions = Permission::all();  
		if(!!$capabilities){
			if(isset($capabilities->capabilities) && !is_null($capabilities->capabilities)){
				$capabilities = unserialize($capabilities->capabilities);
			}
		}else{
			$capabilities = [];
		}		
		if(
			(Auth::user()->current_user_can('super_admin') && ($user->current_user_can('administrator') || $user->current_user_can('manager') || $user->current_user_can('user') || $user->id==Auth::user()->id))
			||
			(Auth::user()->current_user_can('administrator') && ($user->current_user_can('manager') || $user->current_user_can('user') || $user->id==Auth::user()->id))
			||
			(Auth::user()->current_user_can('manager') && ($user->current_user_can('user') || $user->id==Auth::user()->id))
			||
			(Auth::user()->current_user_can('user') && $user->id==Auth::user()->id)
		){
			 
			return view('auth.update-user',['user'=>$user,'userCaps'=>$capabilities,'permissions'=>$permissions,'edit_data'=>$edit_data]);
		}
		$request->session()->flash('failed', "Not Permission other Super admin edit");
		return redirect("/users");
		 
	}
	
	public function updateThisUser(Request $request, $id)
	{ 
 
	 
		$user_id = base64_decode($id);		  
		$user = User::find($user_id);
        $validator = Validator::make($request->all(), [
          	'name'=>'required|unique:web_users,name,'.$user_id,
			'email'=>'required|unique:web_users,email,'.$user_id,		 
            'role' => 'required',
			'password' => 'confirmed',
			'capabilities' =>'required',
        ]);

        if ($validator->fails()) {
            return redirect("user/update/$id")
                        ->withErrors($validator)
                        ->withInput();
        }		
		$user->name = $request->input('name');
		$user->email = $request->input('email');
		if((Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('super_admin')) && ($user->current_user_can('manager') || $user->current_user_can('user') || $user->id!=Auth::user()->id)){
			$user->role = $request->input('role');
		}
		if(!empty($request->input('password'))){
			$user->password = bcrypt($request->input('password'));
		}
	 //echo "<pre>";print_r($user);die;
		$user->save();
		
		
		if(Auth::user()->current_user_can('super_admin') || Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager')){
			
			
			 $update_capbilities = array(					 
					 'capabilities'=>serialize($request->input('capabilities')),					 
					 );
				if($request->input('manager')!=""){
					$update_capbilities['manager'] =$request->input('manager');
				}else{
					$update_capbilities['manager']="0";					
				}
				 
				$capability = Capability::where('user_id',$user_id)->update($update_capbilities);	 
			
			
			 
		
		}
		$this->success_msg .= 'User successfully updated!';
		$request->session()->flash('success', $this->success_msg);		  
		return redirect("/users");
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 /**
	 add save Course Title with slug
   * Author: Brijesh Chauhan.
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSaveUser(Request $request,$id)
    {	  
		//echo "<pre>";print_r($_POST);die;  
	
        if($request->ajax()){ 
		
		  $validator = Validator::make($request->all(),[				 
				'name'=>'required|unique:users,name,'.$id,
			'email'=>'required|unique:users,email,'.$id,		 
            'role' => 'required',
			'password' => 'confirmed',
			'capabilities' =>'required',		
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
					$user = User::find($id);
				
						if(!empty($request->input('password'))){
						$user->password = bcrypt($request->input('password'));
						}
				$user->name = ucwords(trim($request->input('name')));		
				$user->email = $request->input('email');					 					
				$user->mobile =$request->input('mobile');				 					 
				$user->role = trim($request->input('role'));			 				 
				//$user->capability =serialize($request->input('capabilities'));	
		//	echo "<pre>";print_r($user);die;	
			if($user->save()){
				
					$checkcapbility = Capability::where('user_id',$id)->first();
				if(!empty($checkcapbility)){
					$update_capbilities = array(					 
					 'capabilities'=>serialize($request->input('capabilities')),					 
					 );
				 
				 
				$capability = Capability::where('user_id',$id)->update($update_capbilities);
					
				}else{
					$add_capbilities = array(
					 'user_id'=>$user->id,
					 'capabilities'=>serialize($request->input('capabilities')),					 
					 );
				
				$capability = DB::table('web_capabilities')->insert($add_capbilities);	
					
				}
					
				
				$status=1;							 
				$msg="User updated successfully !";		
				
			}else{
				$status=0;							 
				$msg="User could not be updated, please try again!";	
			}
		
			 return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		
		}
    } 

	// GET  Course pagination
	public function getUserPagination(Request $request)
	{
		   
		if($request->ajax()){			 
		$users = 	User::orderBy('name','asc');		 
		if($request->input('search.value')!==''){
				$users = $users->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('mobile','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$users = $users->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $users->total();
			$returnLeads['recordsFiltered'] = $users->total();
			$returnLeads['recordCollection'] = [];

			foreach($users as $user){				 
				$action="";
				$seperate="";				 					 
				$status="";				 					 
				$action .='<a href="/admin/users/edit/'.base64_encode($user->id).'" title="Edit User" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>    ';
				$user_id=[1,2,3,6];																				
					if (!in_array($user->id,$user_id)){
					if(Auth::user()->current_user_can('administrator')){
					$action .='<a href="javascript:userController.delete('.$user->id.')" title="Delete User" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';	
					}

					}
				if($user->status=='1'){
					$status .='<a href="javascript:userController.status('.$user->id.',0)" title="User status" class="btn btn-success">Active</a>';	
					}else{
					$status .='<a href="javascript:userController.status('.$user->id.',1)" title="User status" class="btn btn-danger">Inactive</a>';	
					}
				 
					$data[] = [		 		 		 
						$user->name,					 			
						$user->email,	 		
						$user->mobile,					 			
						$user->role,					 		 			
						$status, 	 			 			
						$action,					  
						 
					];
					$returnLeads['recordCollection'][] = $user->id;				 
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
		 
		$user = User::findOrFail($id); 	
//echo"<pre>";print_r($user);die;	
	$coursemaster = CoursesMaster::where('created_by',$id)->select('id','created_by')->get();
		if(!empty($coursemaster)){		
		foreach($coursemaster as $coursemaster){			
			 $createduser =array( 'created_by'=>1,	);				 
			$update  =DB::table('web_coursemaster')->where('id',$coursemaster->id)->update($createduser);		
			}
		}
		$courses = Course::where('created_by',$id)->select('id','created_by')->get();
		if(!empty($courses)){		
		foreach($courses as $course){$courseuser =array( 'created_by'=>1);				 
			$update  =DB::table('web_courses')->where('id',$course->id)->update($courseuser);		
		}
		}
		
		
		$blogs = Blog::where('created_by',$id)->select('id','created_by')->get();
		if(!empty($blogs)){		
		foreach($blogs as $blog){$bloguser =array( 'created_by'=>1);				 
			$update  =DB::table('web_courses')->where('id',$blog->id)->update($bloguser);		
		}
		}
	
		if($user->delete()){
		$status=1;							 
		$msg="User deleted successfully!";	
		}else{
		$status=0;							 
		$msg="User could not be deleted!";	
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
		$user = User::findOrFail($id);	 
		$user->status=$val;
		// echo "<pre>";print_r($user);die;
		if($user->save()){
			$status=1;							 
			$msg="User status updated successfully!";					
			}else{
			$status=0;							 
			$msg="User status could not be updated!";	
			}		
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
		 }
    }
  
 
 
 
}
