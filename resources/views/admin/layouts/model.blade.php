 
								
								
	<div class="modal fade" id="payemployee" role="dialog">
	<div class="modal-dialog modal-large">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<div class="successinvoice"></div>
	<div class="errorinvoice"></div>
	<h4>Pay Emplopyee</h4>
	</div>
	<div class="modal-body">
		
	<form action="" method="post" class="payemployee" autocomplete="off">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							 <div class="nk-int-mk">
                                    <h2>Employee Type<span class="required">*</span></h2>
                                </div>
								  {{csrf_field()}}          
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="nk-int-st">
                                      <select class="selectpicker bootstrap-select fm-cmp-mg" name="employee_type" id="employee_type" data-rule="employee_type" data-msg="Select Employee Type">
											<option value="">Select Employee Type</option>
											<option value="employee" @if ("employee"== old('employee_type'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->role == "employee" ) ? "selected":"" }} @endif >Employee</option>
											
											<option value="trainer" @if ("trainer"== old('employee_type'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->role == "trainer" ) ? "selected":"" }} @endif >Trainer</option>
											
											
											<option value="other" @if ("other"== old('employee_type'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->role == "other" ) ? "selected":"" }} @endif >Other</option>
											
											
											
											</select>
										<div class="validation"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    
						          <div class="nk-int-mk">
                                    <h2>Employee Name<span class="required">*</span></h2>
                                </div>                       
							   <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="nk-int-st ">
									 <select class=" bootstrap-select" name="employee_id" id="employee_name" data-rule="employee_id" data-msg="Select Employee Name">
                                 
										 </select>
										<div class="validation"></div>
									 
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							 <div class="nk-int-mk">
                                    <h2>Mode</h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="nk-int-st">
									
                                        <select class="bootstrap-select" name="payment_mode"  data-rule="payment_mode" data-msg="Select payment mode Type">
											<option value="">Select Mode</option>			           
									 
										 <?php  $paymode=  App\Paymentmode::get(); 									 
										 
										 if(!empty($paymode)){
											 
											 foreach($paymode as $mode){
										 ?>
										 <option value="<?php echo $mode->mode;?>"><?php echo $mode->mode ?></option>
											
										 <?php } } ?>
											</select>
										 <div class="validation"></div>
                                    </div>
                                </div>
                            </div>
							</div>
							<div class="row">
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Paid Amount<span class="required">*</span></h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="number" class="form-control" name="paid_amount" value="{{ old('paid_amount')}}" placeholder="Enter paid Amount" data-rule="paid_amount" data-msg="Enter Pay Amount">
										 <div class="validation"></div>
										 
                                    </div>
                                </div>
                            </div>
							
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Remarks</h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="remarks" value="{{ old('remarks')}}" placeholder="Enter remarks" >
										 
                                    </div>
                                </div>
                            </div>
							
							  
							
							
							
                        </div> 
						 
						 
						
						
					 
						 <div class="modal-footer">
					<button type="submit" class="btn btn-default" name="submit">Submit</button>
					<button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
						</form>
                  
	</div>
	 
	</div>
	</div>
	</div>
	
	
	
	
	
	<div class="modal fade" id="generatesalaryinvoice" role="dialog">
		<div class="modal-dialog modal-large">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="successinvoice"></div>
												<div class="errorinvoice"></div>
					<h4>Add Generate Invoice</h4	>
				</div>
				<div class="modal-body">
					
					<form action="" method="post" class="AddGenerateInvoice" autocomplete="off">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							 <div class="nk-int-mk">
                                    <h2>Employee Type</h2>
                                </div>
								  {{csrf_field()}}          
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="nk-int-st">
                                      <select class="selectpicker bootstrap-select fm-cmp-mg" name="employee_type" id="employee_invoice" data-rule="employee_type" data-msg="Select Employee Type">
											<option value="">Select Employee Type<span class="required">*</span></option>
											<option value="employee" @if ("employee"== old('employee_type'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->role == "employee" ) ? "selected":"" }} @endif >Employee</option>
											
											<option value="trainer" @if ("trainer"== old('employee_type'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->role == "trainer" ) ? "selected":"" }} @endif >Trainer</option>
											
											
											<option value="other" @if ("other"== old('employee_type'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->role == "other" ) ? "selected":"" }} @endif >Other</option>
											
											
											
											</select>
										<div class="validation"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    
						          <div class="nk-int-mk">
                                    <h2>Employee Name<span class="required">*</span></h2>
                                </div>                       
							   <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="nk-int-st ">
									 <select class=" bootstrap-select" name="employee_id" id="employee_invoice_name" data-rule="employee_id" data-msg="Select Employee Name">
                                            
										 
										 </select>
										<div class="validation"></div>
									 
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							 <div class="nk-int-mk">
                                    <h2>Fixed Salary<span class="required">*</span></h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="fixed_salary" id="fixed_salary" value="{{ old('fixed_salary')}}" placeholder="Enter Fixed Salary" data-rule="fixed_salary" data-msg="Enter Fixed Salary">
										 <div class="validation"></div>
										 
                                    </div>
                                </div>
                            </div>
							</div>
							<div class="row">
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Employee Code<span class="required">*</span></h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="emp_code" id="emp_code" value="{{ old('emp_code')}}" placeholder="Enter Example CC-, LE-" >
										 
										 
                                    </div>
                                </div>
                            </div>
							
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Leave Amount</h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="leave_amount" value="{{ old('leave_amount')}}" placeholder="Enter leave amount Deduct" >
										 
                                    </div>
                                </div>
                            </div>
							
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Total Net Pay<span class="required">*</span></h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="net_pay" value="{{ old('net_pay')}}" placeholder="Enter net pay" data-rule="net_pay" data-msg="Enter Net Pay">
										<div class="validation"></div>
										 
                                    </div>
                                </div>
                            </div>
                             
							
							
							
                        </div> 
						<div class="row">
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Days Payable<span class="required">*</span></h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-sun-o"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="dayspayable" value="{{ old('dayspayable')}}" placeholder="Enter days payable" >
										 
										 
                                    </div>
                                </div>
                            </div>
							
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Leave Without Pay</h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-sun-o"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="leave_without_pay" value="{{ old('leave_without_pay')}}" placeholder="Enter Leave Without Pay deduct days" >
										 
										 
                                    </div>
                                </div>
                            </div>
							
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Invoice Date<span class="required">*</span></h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control invoicedate" name="invoice_date" value="{{ old('invoice_date')}}" placeholder="Enter invoice date" data-rule="invoice_date" data-msg="Enter invoice date" >
										<div class="validation"></div>
										 
                                    </div>
                                </div>
                            </div>
                             
							
							
							
                        </div> 
						 
						 
						
						
					 
						 <div class="modal-footer">
					<button type="submit" class="btn btn-default" name="submit">Save</button>
					<button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
						</form>
                  
				</div>
				
			</div>
		</div>
	</div>
	
								
		<div class="modal fade" id="payinvoiceModal" role="dialog">
		<div class="modal-dialog modal-large">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="successinvoice"></div>
												<div class="errorinvoice"></div>
					<h4>Pay Invoice</h4>
				<div class="modal-body">
					
					<form action="" method="post" class="payinvoicess" autocomplete="off">
					{{csrf_field()}}        
								<div class="row">
								<div class="input"></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							 <div class="nk-int-mk">
                                    <h2>Employee Type<span class="required">*</span></h2>
                                </div>
								      
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="nk-int-st">
                                      <select class="selectpicker bootstrap-select fm-cmp-mg" name="employee_type" id="employee_pay" data-rule="employee_type" data-msg="Select Employee Type">
											<option value="">Select Employee Type</option>
											<option value="employee">Employee</option>										
											<option value="trainer" >Trainer</option>								
											<option value="other"  >Other</option>										
											</select>
										<div class="validation"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    
						          <div class="nk-int-mk">
                                    <h2>Employee Name<span class="required">*</span></h2>
                                </div>                       
							   <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="nk-int-st ">
									 <select class=" bootstrap-select" name="employee_id" id="employee_pay_name" data-rule="employee_id" data-msg="Select Employee Name">
                                            
										 
										 </select>
										<div class="validation"></div>
									 
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							 <div class="nk-int-mk">
                                    <h2>Mode</h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="nk-int-st">
									
                                        <select class="bootstrap-select" name="payment_mode"  id="employee_payment_mode" data-rule="payment_mode" data-msg="Select payment mode Type">
											<option value="">Select Mode</option>
											
											
											
											
											</select>
										 <div class="validation"></div>
                                    </div>
                                </div>
                            </div>
							</div>
							<div class="row">
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Paid Amount<span class="required">*</span></h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="paid_amount" value="" placeholder="Enter paid Amount" data-rule="payment_mode" data-msg="Select payment mode Type">
										 <div class="validation"></div>
										 
                                    </div>
                                </div>
                            </div>
							
							 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							  <div class="nk-int-mk">
                                    <h2>Remarks</h2>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" class="form-control" name="remarks" value="" placeholder="Enter remarks" >
										 
                                    </div>
                                </div>
                            </div>
							
							  
							
							
							
                        </div>  
						
						 <div class="modal-footer">
					<button type="submit" class="btn btn-default" name="submit">Save</button>
					<button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
							</form>
					
					</div>
					</div>
					</div>
					</div>
								

								
		<div class="modal fade" id="payinvoice" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
			 
					</div>
					</div>
					</div>		

					
		<div class="modal fade" id="invoice-history" role="dialog">
		<div class="modal-dialog modal-large">
		<div class="modal-content">

		</div>
		</div>
		</div>	
		
		<div class="modal fade" id="summary-history" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">

		</div>
		</div>
		</div>	
		
		
		<div class="modal fade" id="designationmodel" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">

		</div>
		</div>
		</div>
		
		<!--Change Password-->
		
		<div class="modal fade" id="password-form" role="dialog">
		<div class="modal-dialog">
		<div class="modal-content">

		</div>
		</div>
		</div>
								
 
                  	<script> 
		 											
			//$(".successinvoice").fadeOut(3000);
		//	$(".errorinvoice").fadeOut(3000);
			
			 
		</script>           