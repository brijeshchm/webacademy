@extends('admin.layouts.app')
@section('title')
Pay Mode
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
<div class="page-title">
              <div class="title_left">
                <h3>Payment Mode</h3>
				<div class="succesmessage"></div><div class="errormessage"></div>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                     <a href="/admin/payment-mode/add"  class="btn btn-info"> Add Mode</a>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
				 @if(Request::segment(3)=='add'  || Request::segment(3)=='edit'  )
			 <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">                    
                    <form class="form-horizontal form-label-left" autocomplete="off" action="" onsubmit="return paymentModeController.Submit(this)" enctype="multi-part/form-data" method="post"> 

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="name" value="" placeholder="Enter Name" >
                        </div>
                      </div>          
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Mode<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-7 col-xs-12" name="mode">
						  <option value="">Select Mode</option>
						  <option value="GooglePay">GooglePay</option>
						  <option value="PhonePay">PhonePay</option>
						  <option value="PayTm">PayTm</option>
						  <option value="UPI">UPI</option>
						  </select>
                        </div>
                      </div> 

					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Number<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="number" value="" placeholder="Enter Number">
                        </div>
                      </div> 

					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">QR File
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" class="form-control col-md-7 col-xs-12" name="qrfile" value="" placeholder="Enter Number">
                        </div>
                      </div> 					  

					  
					    
					                       
                     
                      
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
			@else
            <div class="row">
               
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                     
                    <table id="datatable-all-paymentMode" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>                          
                          <th>URL</th>                          
                          <th>Mode</th>                          
                          <th>Number</th>                          
                          <th>QR Code</th>                          
                          <th>Action</th>
                           
                        </tr>
                      </thead>


                       </table>
                  </div>
                </div>
              </div>

             
               
              
            </div>
			@endif
          </div>
        </div>
		
		@endsection