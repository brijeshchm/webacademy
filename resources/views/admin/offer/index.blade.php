@extends('admin.layouts.app')
@section('title')
Offer
@endsection
@section('content')	
 
  <div class="right_col" role="main">
          <div class="">    
			<div class="page-title">
				<div class="title_left">
				<h3>Batch Date & Time</h3>
				<div class="succesmessage"></div><div class="errormessage"></div>
				</div>
				<div class="title_right">
				<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
				<div class="input-group">
				<a href="/admin/offer/add"  class="btn btn-info"> Add Batch Date & Time</a>
				</div>
				</div>
				</div>
			</div>
            <div class="clearfix"></div>				 
            <div class="row">               
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">                  
                  <div class="x_content">                     
                    <table id="datatable-all-offer" class="table table-striped table-bordered">
                      <thead>
                        <tr>
						<th>Category</th>           
                          <th>Sub Category</th>  
                          <th>Amount </th>                  
                          <th>Offer</th>                  
                          <th>Discount amount</th>   
                          <th>Day Occurrence</th>           
                          <th>Batch Start</th>           
                          
                          <th>Action</th> 
                        </tr>
                      </thead>
					  </table>
                  </div>
                </div>
              </div>  
            </div> 
          </div>
        </div>		
		@endsection