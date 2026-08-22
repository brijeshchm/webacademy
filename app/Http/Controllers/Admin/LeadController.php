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
use App\Inquiry; 
use App\LeadUser; 
use App\LeadSource; 
use App\LeadDemo;
use App\Models\Courses; 
use App\LeadStatus; 
use App\Courseassignment; 
 
class LeadController extends Controller
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
 
	//$leadSource = LeadSource::where('status',1)->orderby('name','asc')->get();
// 	$leadUser = User::orderby('name','asc')->get();
 	$courses = Course::orderby('id','asc')->where('status',1)->get();
 
	$search = [];
		if($request->has('search')){
			$search = $request->input('search');
		}
        return view('admin.lead.index',['search'=>$search,'courses'=>$courses]);
    } 
	
   
	 	
  
	// GET  Course pagination
	public function getLeadPagination(Request $request)
	{
		    date_default_timezone_set('Asia/Kolkata');
		    
		if($request->ajax()){			 
		$inquires = 	Inquiry::orderBy('id','DESC');		 
		if($request->input('search.value')!==''){
				$inquires = $inquires->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
                                ->orWhere('form','LIKE','%'.$request->input('search.value').'%')
                                ->orWhere('name','LIKE','%'.$request->input('search.value').'%')
                                ->orWhere('course','LIKE','%'.$request->input('search.value').'%')
                               
                                ->orWhere('mobile','LIKE','%'.$request->input('search.value').'%')
                                ->orWhere('sub_category','LIKE','%'.$request->input('search.value').'%')
                                ->orWhere('from_name','LIKE','%'.$request->input('search.value').'%');
				});
			}
			
				if($request->input('search.leaddf')!=''){
				$inquires = $inquires->whereDate('created_at','>=',date_format(date_create($request->input('search.leaddf')),'Y-m-d'));
			}
			if($request->input('search.leaddt')!=''){
				$inquires = $inquires->whereDate('created_at','<=',date_format(date_create($request->input('search.leaddt')),'Y-m-d'));
			}
			
			if($request->input('search.user')!=''){
				$inquires = $inquires->where('assigned_to',$request->input('search.user'));
			}
			
			if($request->input('search.courses')!=''){
				$inquires = $inquires->where('course_id',$request->input('search.courses'));
			}
			
			// for duplicate value
	    	$inquires = $inquires->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"));
	 
			$inquires = $inquires->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $inquires->total();
			$returnLeads['recordsFiltered'] = $inquires->total();
			$returnLeads['recordCollection'] = [];
          
			foreach($inquires as $inquiry){
			    $checkid = '<input type="checkbox" class="check-box-lead" value="'.$inquiry->id.'">';
			    if($inquiry->duplicate==2){
				 $mobilecode = '<span style="color:#A52A2A">'.$inquiry->mobile.'</span>';
			    }else{
			        $mobilecode =$inquiry->mobile;
			        
			    }
				 if($inquiry->form){
				     $from_name= '('.$inquiry->form.')';
				 }else{
				     $from_name="";
				 }
				 
				 	if($inquiry->form){
				     $sub_category = '<span title="'.$from_name.'" >'.$from_name.'</span>';
				     
				 }else{
				      $sub_category ='<span title="'.$inquiry->sub_category.'" >'.substr($inquiry->sub_category,0,20).'</span>';
				     
				 }
				  if($inquiry->course){
				     $coursename = '<span title="'.$inquiry->course.'" style="    cursor: pointer;">'.substr($inquiry->course,0,25).'</span>';
				     
				     
				     
				 }else{
				      $coursename ="";
				     
				 }
                 
		 

					$data[] = [	
					    $checkid,
						date_format(date_create($inquiry->created_at),'d-M-y | H:i'),
						$inquiry->name,				 			
						$mobilecode,
						$inquiry->email,
						 	$coursename,	 			
						$inquiry->form,		
					 
					];
					$returnLeads['recordCollection'][] = $inquiry->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
		}  
		
	}
	
	public function selectTodeleteLeads(Request $request){
		$ids = $request->input('ids');	
		  
		if(!empty($ids)){
		foreach($ids as $id){	
			$leads = DB::table('web_enquiries')->where('id',$id)->delete();	
			 	
		}
		return response()->json([
			'statusCode'=>1,
			'data'=>[
				'responseCode'=>200,
				'payload'=>'',
				'message'=>'Successfully Deleted'
			]
		],200);
	}else{
		
		return response()->json([
			'statusCode'=>1,
			'data'=>[
				'responseCode'=>200,
				'payload'=>'',
				'message'=>'Please select check box.'
			]
		],200);
		
	}
	
	} 
	 
 public function getleadcount(Request $request){
    
	    $data=array();
        $lastdate =date('Y-m-d');
		 $leacount = Inquiry::whereDate('created_at','=',date_format(date_create($lastdate),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
	  	$follows = array(	  	    
	  	    'leacount'=>$leacount,	  	    
	  	    );
	  
	  
	  	return response()->json([
				"statusCode"=>1,
				"success"=>[
					"responseCode"=>200,
					"count_data"=>$leacount,
					"message"=>""
				]
			],200);	
		 
		 
		 
		
		
   
		
	}
 
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function leadanalysis(Request $request)
    {	 
	//echo "test";die;
			$current =  date('d-m-Y');						
			$oneday=  date('d-m-Y', strtotime($current));	
			$onelead =Inquiry::whereDate('created_at','=',date_format(date_create($oneday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$directvisitonelead= LeadDemo::whereDate('created_at','=',date_format(date_create($oneday),'Y-m-d'))->where('source',11)->get()->count();
			
			
			$firstday=  date('d-m-Y', strtotime($current. ' - 1 day'));	
			$firstlead =Inquiry::whereDate('created_at','=',date_format(date_create($firstday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$directvisitfirstlead= LeadDemo::whereDate('created_at','=',date_format(date_create($firstday),'Y-m-d'))->where('source',11)->get()->count();
			
			
			//echo $firstday; die;
			$secongday=  date('d-m-Y', strtotime($current. ' - 2 day'));	
			$secondlead =Inquiry::whereDate('created_at','=',date_format(date_create($secongday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$directvisitsecondlead= LeadDemo::whereDate('created_at','=',date_format(date_create($secongday),'Y-m-d'))->where('source',11)->get()->count();


			$thirdday=  date('d-m-Y', strtotime($current. ' - 3 day'));	
			$thirdlead = Inquiry::whereDate('created_at','=',date_format(date_create($thirdday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();							

			$directvisitthirdlead= LeadDemo::whereDate('created_at','=',date_format(date_create($thirdday),'Y-m-d'))->where('source',11)->get()->count();

			$fourday=  date('d-m-Y', strtotime($current. ' - 4 day'));	
			$fourlead = Inquiry::whereDate('created_at','=',date_format(date_create($fourday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$directvisitfourlead= LeadDemo::whereDate('created_at','=',date_format(date_create($fourday),'Y-m-d'))->where('source',11)->get()->count();

			$fiveday=  date('d-m-Y', strtotime($current. ' - 5 day'));	
			$fivelead = Inquiry::whereDate('created_at','=',date_format(date_create($fiveday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$directvisitfivelead= LeadDemo::whereDate('created_at','=',date_format(date_create($fiveday),'Y-m-d'))->where('source',11)->get()->count();

			$sixday=  date('d-m-Y', strtotime($current. ' - 6 day'));	
			$sixlead = Inquiry::whereDate('created_at','=',date_format(date_create($sixday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();	

			$directvisitsixlead= LeadDemo::whereDate('created_at','=',date_format(date_create($sixday),'Y-m-d'))->where('source',11)->get()->count();


			$sevenday=  date('d-m-Y', strtotime($current. ' - 7 day'));	
			$sevenlead = Inquiry::whereDate('created_at','=',date_format(date_create($sevenday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();

			$directvisitsevenlead= LeadDemo::whereDate('created_at','=',date_format(date_create($sevenday),'Y-m-d'))->where('source',11)->get()->count();


			$eightday=  date('d-m-Y', strtotime($current. ' - 8 day'));	
			$eightlead = Inquiry::whereDate('created_at','=',date_format(date_create($eightday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();

			$directvisiteightlead= LeadDemo::whereDate('created_at','=',date_format(date_create($eightday),'Y-m-d'))->where('source',11)->get()->count();


			$nineday=  date('d-m-Y', strtotime($current. ' - 9 day'));	
			$ninelead = Inquiry::whereDate('created_at','=',date_format(date_create($nineday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$directvisitninelead= LeadDemo::whereDate('created_at','=',date_format(date_create($nineday),'Y-m-d'))->where('source',11)->get()->count();
			
			
			$tenday=  date('d-m-Y', strtotime($current. ' - 10 day'));	
			$tenlead = Inquiry::whereDate('created_at','=',date_format(date_create($tenday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$directvisittenlead= LeadDemo::whereDate('created_at','=',date_format(date_create($tenday),'Y-m-d'))->where('source',11)->get()->count();
			
			$elevenday=  date('d-m-Y', strtotime($current. ' - 11 day'));	
			$elevenlead = Inquiry::whereDate('created_at','=',date_format(date_create($elevenday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$directvisitelevenlead= LeadDemo::whereDate('created_at','=',date_format(date_create($elevenday),'Y-m-d'))->where('source',11)->get()->count();
	
	$dataPoints1 = array(
		//array("label"=> date('d-M',strtotime($oneday)), "y"=> ($onelead+$directvisitonelead)),
		array("label"=> date('d-M',strtotime($firstday)), "y"=> ($firstlead+$directvisitfirstlead)),
		array("label"=> date('d-M',strtotime($secongday)), "y"=> ($secondlead+$directvisitsecondlead)),
		array("label"=> date('d-M',strtotime($thirdday)), "y"=> ($thirdlead+$directvisitthirdlead)),
		array("label"=> date('d-M',strtotime($fourday)), "y"=> ($fourlead+$directvisitfourlead)),
		array("label"=> date('d-M',strtotime($fiveday)), "y"=> ($fivelead+$directvisitfivelead)),
		array("label"=> date('d-M',strtotime($sixday)), "y"=> ($sixlead+$directvisitsixlead)),
		array("label"=> date('d-M',strtotime($sevenday)), "y"=> ($sevenlead+$directvisitsevenlead)),
		array("label"=> date('d-M',strtotime($eightday)), "y"=> ($eightlead+$directvisiteightlead)),
		array("label"=> date('d-M',strtotime($nineday)), "y"=> ($ninelead+$directvisitninelead)),
		array("label"=> date('d-M',strtotime($tenday)), "y"=> ($tenlead+$directvisittenlead)),
		array("label"=> date('d-M',strtotime($elevenday)), "y"=> ($elevenlead+$directvisitelevenlead)),

		);
		$dataPoints=json_encode($dataPoints1, JSON_NUMERIC_CHECK);

	$leadSource = LeadSource::orderby('id','asc')->get();
	
	$search = [];
		if($request->has('search')){
			$search = $request->input('search');
		}
        return view('admin.lead.lead-analysis',['search'=>$search,'dataPoints'=>$dataPoints,'leadSource'=>$leadSource]);
    }
 
  /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function leadanalysis1_8(Request $request)
    {	 
	//echo "test";die;
			$current =  date('d-m-Y');						
			$oneday=  date('d-m-Y', strtotime($current));	
			$onelead =Inquiry::whereDate('created_at','=',date_format(date_create($oneday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$firstday=  date('d-m-Y', strtotime($current. ' - 1 day'));	
			$firstlead =Inquiry::whereDate('created_at','=',date_format(date_create($firstday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			
			//echo $firstday; die;
			$secongday=  date('d-m-Y', strtotime($current. ' - 2 day'));	
			$secondlead =Inquiry::whereDate('created_at','=',date_format(date_create($secongday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();

			$thirdday=  date('d-m-Y', strtotime($current. ' - 3 day'));	
			$thirdlead = Inquiry::whereDate('created_at','=',date_format(date_create($thirdday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();							

			$fourday=  date('d-m-Y', strtotime($current. ' - 4 day'));	
			$fourlead = Inquiry::whereDate('created_at','=',date_format(date_create($fourday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();


			$fiveday=  date('d-m-Y', strtotime($current. ' - 5 day'));	
			$fivelead = Inquiry::whereDate('created_at','=',date_format(date_create($fiveday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();

			$sixday=  date('d-m-Y', strtotime($current. ' - 6 day'));	
			$sixlead = Inquiry::whereDate('created_at','=',date_format(date_create($sixday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();	

			$sevenday=  date('d-m-Y', strtotime($current. ' - 7 day'));	
			$sevenlead = Inquiry::whereDate('created_at','=',date_format(date_create($sevenday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();

			$eightday=  date('d-m-Y', strtotime($current. ' - 8 day'));	
			$eightlead = Inquiry::whereDate('created_at','=',date_format(date_create($eightday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();

			$nineday=  date('d-m-Y', strtotime($current. ' - 9 day'));	
			$ninelead = Inquiry::whereDate('created_at','=',date_format(date_create($nineday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$tenday=  date('d-m-Y', strtotime($current. ' - 10 day'));	
			$tenlead = Inquiry::whereDate('created_at','=',date_format(date_create($tenday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			$elevenday=  date('d-m-Y', strtotime($current. ' - 11 day'));	
			$elevenlead = Inquiry::whereDate('created_at','=',date_format(date_create($elevenday),'Y-m-d'))->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();

	
	$dataPoints1 = array(
		//array("label"=> date('d-M',strtotime($oneday)), "y"=> ($onelead)),
		array("label"=> date('d-M',strtotime($firstday)), "y"=> ($firstlead)),
		array("label"=> date('d-M',strtotime($secongday)), "y"=> ($secondlead)),
		array("label"=> date('d-M',strtotime($thirdday)), "y"=> ($thirdlead)),
		array("label"=> date('d-M',strtotime($fourday)), "y"=> ($fourlead)),
		array("label"=> date('d-M',strtotime($fiveday)), "y"=> ($fivelead)),
		array("label"=> date('d-M',strtotime($sixday)), "y"=> ($sixlead)),
		array("label"=> date('d-M',strtotime($sevenday)), "y"=> ($sevenlead)),
		array("label"=> date('d-M',strtotime($eightday)), "y"=> ($eightlead)),
		array("label"=> date('d-M',strtotime($nineday)), "y"=> ($ninelead)),
		array("label"=> date('d-M',strtotime($tenday)), "y"=> ($tenlead)),
		array("label"=> date('d-M',strtotime($elevenday)), "y"=> ($elevenlead)),

		);
		$dataPoints=json_encode($dataPoints1, JSON_NUMERIC_CHECK);

	$leadSource = LeadSource::orderby('id','asc')->get();
	
	$search = [];
		if($request->has('search')){
			$search = $request->input('search');
		}
        return view('admin.lead.lead-analysis',['search'=>$search,'dataPoints'=>$dataPoints,'leadSource'=>$leadSource]);
    } 
    
	
    public function getPaginationSourcecount(Request $request)
	{
		   
		if($request->ajax()){			 
		$sources = Inquiry::orderBy('created_at','DESC');		 
		if($request->input('search.value')!==''){
				$sources = $sources->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
				if($request->input('search.leaddf')!=''){
 		
				$sources = $sources->whereDate('created_at','>=',date_format(date_create($request->input('search.leaddf')),'Y-m-d'));
				}
				if($request->input('search.leaddt')!=''){
				$sources = $sources->whereDate('created_at','<=',date_format(date_create($request->input('search.leaddt')),'Y-m-d'));
				}
				
			$sources = $sources->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"));
			$sources = $sources->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $sources->total();
			$returnLeads['recordsFiltered'] = $sources->total();
			$returnLeads['recordCollection'] = [];
 //echo "<pre>";print_r($sources);die;
			foreach($sources as $source){	

				//Website 7				 	
				$website =Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',7)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//WhatsApp 24 				 
				$whatsApp =Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',24)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//Ph. Enquiry 8				 
				$PhEnquiry =Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',8)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
								
				//Devendra Sir Phone  30					 
				$Devendraphone =Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',30)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			//Devendra Sir WhatsApp 31				 
				$DevendraWhatsApp = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',31)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();						
						
				//Saurabh Sir WhatsApp 29	
				 
				$saurabhwhatsApp = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',29)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				
					//Chat 34	
				 
				$chat = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',34)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//Direct Visit 11
				 
				 $directvisit = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',11)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				$directvisitLead = LeadDemo::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source',11)->get()->count();
				//FaceBook 16		    	 	
		    	$faceBook = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',16)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();	
			
				//Instagram 27
			   
				$instagram = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',27)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//Linkedin	17			  
				$linkedin = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',17)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				
				//JustDial 6				 
				$justDial = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',6)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//Sulekha 3				
				$sulekha = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',3)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
				//Yet5 2				
				$Yet5 = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',2)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				 
				//Google_Adword 19				
				$google_Adword = Inquiry::whereDate('created_at','=',date_format(date_create($source->created_at),'Y-m-d'))->where('source_id',19)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				 $total_lead = $website+$whatsApp+$PhEnquiry+$Devendraphone+$DevendraWhatsApp+$saurabhwhatsApp+$directvisit+$faceBook+$instagram+$linkedin+$justDial+$sulekha+$Yet5+$google_Adword+$chat+$directvisitLead;
				
					$data[] = [	
						date('d-M-y',strtotime($source->created_at)),											 		
						$website,	 			
						$whatsApp,	 			
						$PhEnquiry,
						$Devendraphone,	 			
						$DevendraWhatsApp,
						$saurabhwhatsApp,
						$chat,
						$directvisit+$directvisitLead,
						$faceBook,	 			
						$instagram,	
						$linkedin,	 	 					  
						$justDial,	 	 					  
						$sulekha,	 	 					  
						$Yet5,	 	 					  
						$google_Adword,	 	 					  
						$total_lead,	 	 					  
						 
					];
					$returnLeads['recordCollection'][] = $source->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
		}  
		
	}
	
 	
 	
 	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function monthlyleadanalysis(Request $request)
    {	 
	   
	$search = [];
		if($request->has('search')){
			$search = $request->input('search');
		}
        return view('admin.lead.monthly-lead-analysis',['search'=>$search]);
    } 
		// GET  Course pagination
 
	public function getMonthlyPaginationLeadAnalysis(Request $request)
	{
		   
		if($request->ajax()){			 
		$sources = Inquiry::orderBy('created_at','DESC');		 
		if($request->input('search.value')!==''){
				$sources = $sources->where(function($query) use($request){
					$query->orWhere('name','LIKE','%'.$request->input('search.value').'%')					     		   
						  ->orWhere('id','LIKE','%'.$request->input('search.value').'%');
				});
			}
				if($request->input('search.leaddf')!=''){
 		
				$sources = $sources->whereDate('created_at','>=',date_format(date_create($request->input('search.leaddf')),'Y-m-d'));
				}
				if($request->input('search.leaddt')!=''){
				$sources = $sources->whereDate('created_at','<=',date_format(date_create($request->input('search.leaddt')),'Y-m-d'));
				}
				
			$sources = $sources->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"));
			$sources = $sources->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $sources->total();
			$returnLeads['recordsFiltered'] = $sources->total();
			$returnLeads['recordCollection'] = [];
 
			foreach($sources as $source){	

				//Website 7				 	
				$website =Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',7)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//WhatsApp 24 				 
				$whatsApp =Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',24)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//Ph. Enquiry 8				 
				$PhEnquiry =Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',8)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
								
				//Devendra Sir Phone  30					 
				$Devendraphone =Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',30)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
			//Devendra Sir WhatsApp 31				 
				$DevendraWhatsApp = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',31)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();						
						
				//Saurabh Sir WhatsApp 29	
				 
				$saurabhwhatsApp = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',29)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				
					//Chat 34	
				 
				$chat = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',34)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//Direct Visit 11
				 
				 $directvisit = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',11)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				 
				$directvisitLead = LeadDemo::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source',11)->get()->count();
				//FaceBook 16		    	 	
		    	$faceBook = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',16)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();	
			
				//Instagram 27
			   
				$instagram = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',27)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//Linkedin	17			  
				$linkedin = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',17)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				
				//JustDial 6				 
				$justDial = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',6)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				
				//Sulekha 3				
				$sulekha = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',3)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
			
				//Yet5 2				
				$Yet5 = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',2)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				 
				//Google_Adword 19				
				$google_Adword = Inquiry::whereMonth('created_at','=',date_format(date_create($source->created_at),'m'))->whereYear('created_at','=',date_format(date_create($source->created_at),'Y'))->where('source_id',19)->groupBy('mobile','course',DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get()->count();
				 $total_lead = $website+$whatsApp+$PhEnquiry+$Devendraphone+$DevendraWhatsApp+$saurabhwhatsApp+$directvisit+$faceBook+$instagram+$linkedin+$justDial+$sulekha+$Yet5+$google_Adword+$chat+$directvisitLead;
				
					$data[] = [	
						date('M-y',strtotime($source->created_at)),											 		
						$website,	 			
						$whatsApp,	 			
						$PhEnquiry,
						$Devendraphone,	 			
						$DevendraWhatsApp,
						$saurabhwhatsApp,
						$chat,
						$directvisit+$directvisitLead,
						$faceBook,	 			
						$instagram,	
						$linkedin,	 	 					  
						$justDial,	 	 					  
						$sulekha,	 	 					  
						$Yet5,	 	 					  
						$google_Adword,	 	 					  
						$total_lead,	 	 					  
						 
					];
					$returnLeads['recordCollection'][] = $source->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
		}  
		
	}
	
		     
	
		/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function courseassignment(Request $request)
    {	 
	//echo "test";die;
	$leadUser = LeadUser::orderby('name','asc')->get();
	$leadSource = LeadSource::orderby('name','asc')->get();
	$leadStatus = LeadStatus::orderby('name','asc')->where('id','!=','13')->where('id','!=','14')->get();
	$courses = CatCourse::orderBy('name','asc')->get();
	$search = [];
		if($request->has('search')){
			$search = $request->input('search');
		}
        return view('admin.lead.course-assignment',['search'=>$search,'leadUser'=>$leadUser,'leadStatus'=>$leadStatus,'leadSource'=>$leadSource,'courses'=>$courses]);
    } 
	
	public function getCourseAssignmentPagination(Request $request)
	{
		    date_default_timezone_set('Asia/Kolkata');
		    
		if($request->ajax()){			 
		//$inquires = 	Inquiry::orderBy('id','DESC');		
 
			$inquires = Courseassignment::orderBy('id','DESC');
		
		if($request->input('search.value')!==''){
				$inquires = $inquires->where(function($query) use($request){
					$query->orWhere('counsellors','LIKE','%'.$request->input('search.value').'%')				     		   
                                ->orWhere('counsellors','LIKE','%'.$request->input('search.value').'%')                        
                                ->orWhere('counsellors','LIKE','%'.$request->input('search.value').'%');
				});
			}
			
			if($request->input('search.user')!==''){
				$inquires = $inquires->where('counsellors',$request->input('search.user'));
			}
			 
			if($request->input('search.course')!=''){
			$counsellorlist= [];
			$assigncourse = Courseassignment::get();	
			foreach($assigncourse as $counsellor){
			if(in_array($request->input('search.course'),json_decode($counsellor->assign_dom_course))){
			$counsellorlist[] = $counsellor->counsellors;

			}
			
			if(in_array($request->input('search.course'),json_decode($counsellor->assign_int_course))){
			$counsellorlist[] = $counsellor->counsellors;

			}
			}
			}
		
			if($request->input('search.course')!=''){				  
				$inquires = $inquires->whereIn('counsellors',$counsellorlist);
			 
				
			}
			
	 
			$inquires = $inquires->paginate($request->input('length'));
			
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $inquires->total();
			$returnLeads['recordsFiltered'] = $inquires->total();
			$returnLeads['recordCollection'] = [];
         // echo "<pre>";print_r($inquires);die;
		 $currentdate=date('Y-m-d');
		 
		$courses = CatCourse::get();
			foreach($inquires as $course){
				$usersname= LeadUser::where('id',$course->counsellors)->first();
			 
				if(!empty($usersname)){

				$leadusersname = $usersname->name;
				}else{
					$leadusersname="";
				}
				$htmldom ="";
				if($course->assign_dom_course !== NULL){
				$assigncourse = json_decode($course->assign_dom_course);				
				foreach($courses as $coursev){
				if(in_array($coursev->id,$assigncourse)){
				$htmldom .= "<span class=\"label label-default\">".$coursev->name."</span> ";
				}
				}
				}
				
				$htmlint = "";
				
				if($course->assign_int_course !== NULL){
				$assignIntcourse = json_decode($course->assign_int_course);
				foreach($courses as $coursesv){
				if(in_array($coursesv->id,$assignIntcourse)){
				$htmlint .="<span class=\"label label-default\">".$coursesv->name."</span> ";
				}
				}
				}
				
				
					$data[] = [	
					   $leadusersname,
					   $htmldom,
					   $htmlint,
					 
					 
						 				 			
						 					  
						 
					];
					$returnLeads['recordCollection'][] = $course->id;				 
			}			
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);			
			
		}  
		
	}
	    
	
	
 	
 
 
 
}
