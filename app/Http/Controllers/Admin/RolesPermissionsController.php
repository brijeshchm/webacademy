<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  
use App\Http\Requests;
use Validator;

//models
use App\Models\Permission;
use App\Models\RolePermission;
use Session;
class RolesPermissionsController extends Controller
{
	 
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request){
	//	if($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator')){
			return view('admin.roles_permissions.index');
		/* }else{
			return "Unh Cheatin`";
		} */
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function add(Request $request){
	//	if($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator')){
			return view('admin.roles_permissions.index');
		/* }else{
			return "Unh Cheatin`";
		} */
	}
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function permissionStore(Request $request)
    {
		
		//echo "<pre>";print_r($_POST);die;
        //if($request->ajax() && ($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator'))){
			 
			
			$validator = Validator::make($request->all(),[			 
				'permission'=>'required|unique:web_permissions',				 				
			]);
			
			if($validator->fails()){
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	  
			 
			
			
			$permission = new Permission;
			$permission->permission = str_replace(' ','_',strtolower($request->input('permission')));
			//echo "<pre>";print_r($permission);die;
			if($permission->save()){
				$status=1;							 
				$msg="Permission Submitted Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Permission could not be submitted, please try again!";	
			}
			  return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
		//} 
    }
	
    /**
     * Get paginated permissions.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPaginatedPermissions(Request $request)
    {
		//if($request->ajax() && ($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator'))){
			$permissions = Permission::orderBy('id','desc');
			if($request->input('search.value')!==''){
				$permissions = $permissions->where(function($query) use($request){
					$query->orWhere('permission','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$permissions= $permissions->paginate($request->input('length'));
			$returnPermissions = [];
			$data = [];
			$returnPermissions['draw'] = $request->input('draw');
			$returnPermissions['recordsTotal'] = $permissions->total();
			$returnPermissions['recordsFiltered'] = $permissions->total();
			foreach($permissions as $permission){
				$data[] = [
					$permission->permission,
					'<a href="/admin/permission/edit/'.$permission->id.'" title="Update"><i class="fa fa-refresh" aria-hidden="true"></i></a>'." | ".'<a href="javascript:permissionController.delete('.$permission->id.')" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>'
				];
			}
			$returnPermissions['data'] = $data;
			return response()->json($returnPermissions);
		//} 
    }
	
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPermission(Request $request, $id)
    {
		//if($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator')){
			$edit_data = Permission::find($id);
			// echo "<pre>";print_r($edit_data);die;
			return view('admin.roles_permissions.permission_update',['edit_data'=>$edit_data,'id'=>$id]);			
		//} 
    }
	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermission(Request $request, $id)
    {  

//echo "<pre>";print_r($_POST);die;
		//if($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator')){
			
			$validator = Validator::make($request->all(),[					 
			'permission'=>'required|unique:web_permissions,permission,'.$id			 		
			]);
			 
			if($validator->fails()){
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	
 
			$permission = Permission::find($id);
			$permission->permission = str_replace(' ','_',strtolower($request->input('permission')));


			if($permission->save()){
				$status=1;							 
				$msg="Permission Updated Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Permission could not be updated, please try again!";	
			}
			  return response()->json(['status'=>$status,'msg'=>$msg],200); 


 	
		//} 
    }
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermission(Request $request, $id)
    {

		//if($request->ajax() && ($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator'))){
		

try{
				$permission = Permission::findorFail($id);
//echo "<pre>";print_r($permission);die;
				if($permission->delete()){
					$status=1;							 
				$msg="Permission Deleted Successfully !";		
				}else{
					$status=0;							 
				$msg="Permission could not be deleted, please try again!";	
				}
			}catch(\Exception $e){

				$status=0;							 
				$msg="Permission could not be deleted, please try again!";	
				
			}
return response()->json(['status'=>$status,'msg'=>$msg],200); 


    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function rolePermissionIndex(Request $request){
		//if($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator')){
			$permissions = Permission::all();
			$roles = [
				'super_admin'=>'Super Admin',
				'administrator'=>'Administrator',
				'manager'=>'Manager',
				'user'=>'User',
			];			
			return view('admin.roles_permissions.role_permission',['permissions'=>$permissions,'roles'=>$roles]);
		//} 
	}
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function rolePermissionStore(Request $request)
    {  
       // if($request->ajax() && ($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator'))){
			// echo "<pre>";print_r($_POST);die;
			$validator = Validator::make($request->all(),[					 
			'role'=>'required|unique:web_roles_permissions',		 		
			'permission'=>'required',		 		
			]);
			 
			if($validator->fails()){
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	
 
			
			$permission = new RolePermission;
			$permission->role = $request->input('role');
			$permission->permissions = serialize($request->input('permission'));
//echo "<pre>";print_r($permission);die;

			if($permission->save()){
				$status=1;							 
				$msg="Role Permission Created Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Role Permission could not be created, please try again!";	
			}
			  return response()->json(['status'=>$status,'msg'=>$msg],200); 



			 
		//} 
    }
	
    /**
     * Get paginated permissions.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPaginatedRolesPermissions(Request $request)
    {
		//if($request->ajax() && ($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator'))){
			$permissions = RolePermission::orderBy('id','desc')->where('role','<>','super_admin')->paginate($request->input('length'));
			$returnPermissions = [];
			$data = [];
			$returnPermissions['draw'] = $request->input('draw');
			$returnPermissions['recordsTotal'] = $permissions->total();
			$returnPermissions['recordsFiltered'] = $permissions->total();
	 
			foreach($permissions as $permission){
				$html = '';
				$permissionss = unserialize($permission->permissions);
				$i=1;
				if(!empty($permissionss)){
				foreach($permissionss as $p){
					$br = "";
					if($i%6==0)
						$br .= "<br>";
					$html .= "<span class='label label-default'>$p</span>&nbsp;&nbsp;".$br;
					++$i;
				}
				}
				$data[] = [
					$permission->role,
					$html,
					'<a href="/admin/role-permission/update/'.$permission->id.'" title="Update"><i class="fa fa-refresh" aria-hidden="true"></i></a>'
				];
			}
			$returnPermissions['data'] = $data;
			return response()->json($returnPermissions);
	//	} 
    }
	
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRolePermission(Request $request, $id)
    {  
		//if($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator')){
			$permissions = Permission::all();
			$edit_permission = RolePermission::find($id);
			$roles = [			 
				'administrator'=>'Administrator',
				'manager'=>'Manager',
				'user'=>'User',
			];
			 
			$sourcePermissions = "";
			$destinationPermissions = "";
			if(!is_null($edit_permission->permissions)){
				$rolePermissions = unserialize($edit_permission->permissions);
				 
					foreach($permissions as $permission){
						if(isset($rolePermissions) && in_array($permission->permission,$rolePermissions)){
							$destinationPermissions .="<option value=\"$permission->permission\" selected>$permission->permission</option>";
						}else{
							$sourcePermissions .="<option value=\"$permission->permission\">$permission->permission</option>";
							
						}
					}
			}else{
				foreach($permissions as $permission){
					$sourcePermissions .= "<option value=\"$permission->permission\">$permission->permission</option>";
				}
			}
			
			
			return view('admin.roles_permissions.role_permission_update',['id'=>$id,'roles'=>$roles,'edit_permission'=>$edit_permission, 'users'=>['sourcePermissions'=>$sourcePermissions,'destinationPermissions'=>$destinationPermissions]]);
	//	} 
    }
	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRolePermission(Request $request, $id)
    { 
		//if($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator')){
			 
			//echo "<pre>";print_r($_POST);die;
			
			$validator = Validator::make($request->all(),[					 
			 
			'role' 	=> 'required|max:255|unique:web_roles_permissions,role,'.$id.',id',
			'permission'=>'required',	
			]);
			 
			if($validator->fails()){
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status'=>1,'errors'=>$errorsBag],400);
			}	
 
 
			$permission = RolePermission::find($id);
			$permission->role = $request->input('role');
			$permission->permissions = serialize($request->input('permission'));
			
			if($permission->save()){
				$status=1;							 
				$msg="Role Permission Updated Successfully !";		
				
			}else{
				$status=0;							 
				$msg="Role Permission could not be updated, please try again!";	
			}
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
			
			
			 
			
			
		//} 
    }
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRolePermission(Request $request, $id)
    {
		//if($request->ajax() && ($request->user()->current_user_can('super_admin') || $request->user()->current_user_can('administrator'))){
			try{
				$permission = RolePermission::findorFail($id);
				if($permission->delete()){
					return response()->json(['status'=>1],200);
				}else{
					return response()->json(['status'=>0],400);
				}
			}catch(\Exception $e){
				return response()->json(['status'=>0,'errors'=>'Permission not found'],200);
			}
		//} 
    }
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRolePermissions(Request $request, $id)
    {  
		if($request->ajax() && ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager'))){
			try{
				$rolePermission = RolePermission::where('role',$id)->first();
				$permissions = Permission::all();
				$rolePermissions = unserialize($rolePermission->permissions);
				$html = "";
				foreach($permissions as $permission){
					if(in_array($permission->permission,$rolePermissions)){
						$html .= "<option value='$permission->permission' selected>$permission->permission</option>";
					}else{
						$html .= "<option value='$permission->permission'>$permission->permission</option>";
					}
				}
				return response()->json(['status'=>1,'html'=>$html],200);
			}catch(\Exception $e){
				return response()->json(['status'=>0,'errors'=>'Permission not found'],200);
			}
		} 
    }
}
