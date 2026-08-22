
		 <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{url('admin/dashboard')}}" class="site_title"><i class="fa fa-paw"></i> <span>Corporates Academy </span></a>
            </div>

            <div class="clearfix"></div>
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                       
                    </ul>
                  </li>
				  @if(Auth::user()->current_user_can('administrator') ||  Auth::user()->current_user_can('all_user') )
                  <li><a><i class="fa fa-user"></i> User <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('admin/users/add')}}">Add User</a></li>
                      <li><a href="{{url('admin/users')}}">All User</a></li>                      
                    </ul>
                  </li>
				  @endif
				   
			@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager')|| Auth::user()->current_user_can('system_management') )
			<li><a><i class="fa fa fa-sitemap fa-fw"></i> System Management <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('social') )
                        <li><a href="{{url('admin/social')}}">Social</a></li>  
						@endif		
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('homebannar') )
                        <li><a href="{{url('admin/homeslider')}}">Home Bannar</a></li>
						@endif
					<!--	@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('speciality') )						
						<li><a href="{{url('admin/speciality')}}">Speciality </a></li>    
						@endif
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('batch_date') )					
						<li><a href="{{url('admin/offer')}}">Batch Date & Time</a></li>
						@endif-->
						
					@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('city') )
                        <li><a href="{{url('admin/city')}}">City</a></li>
					@endif
					@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('tool_image') )
                        <li><a href="{{url('admin/toolscovered')}}">Tools Image</a></li>
					@endif
					@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('faq') )
                        <li><a href="{{url('admin/FAQs')}}">All FAQs</a></li>  
						@endif
					@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('testimonial') )
                        <li><a href="{{url('admin/testimonial')}}">All Testimonial</a></li>  
					@endif
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_course_pdf') )
					 	<li><a href="{{url('admin/coursepdf')}}">All Course PDF</a></li>  
						@endif	
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_client') )
					 	<li><a href="{{url('admin/client')}}">All Client</a></li>  
						@endif	
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('permission') )
						<li><a href="{{url('admin/permission')}}">Permission</a></li> 
						@endif
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('role_permission') )					
						<li><a href="{{url('admin/role-permission')}}">Role Permission</a></li>   
					 	@endif
					 	
					 	<!--@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('role_permission') )					
						<li><a href="{{url('admin/payment-mode')}}">Payment Mode</a></li>   
					 	@endif-->
                    </ul>
                  </li>   
					@endif
					@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('category') )
				  <li><a><i class="fa fa fa-sitemap fa-fw"></i> Category <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('category') )
                      <li><a href="{{url('admin/category/add')}}">Add Category</a></li>
                      <li><a href="{{url('admin/category')}}">All Category</a></li>   
					@endif					  
				               
                    </ul>
                  </li> 
				  
				  @endif
				  
				  @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('course_page') )
				  <li><a><i class="fa fa fa-book fa-fw"></i> Course Page<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">                
                      <li><a href="{{url('admin/course/add')}}">Add Course Page</a></li>
                      <li><a href="{{url('admin/course')}}">All Course Page</a></li>                       
                    </ul>
                  </li> 
                  @endif
				  
				   @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('seo_page') )
                   <li><a><i class="fa fa fa-book fa-fw"></i> SEO Page <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">                
                      <li><a href="{{url('admin/seopage/add')}}">Add SEO page</a></li>
                      <li><a href="{{url('admin/seopage')}}">All SEO Pages</a></li>                       
                    </ul>
                  </li>  
                  @endif
                  <!--- @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('master_page') )
				  <li><a><i class="fa fa fa-book fa-fw"></i>Master Program<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">                
                      <li><a href="{{url('admin/coursemaster/add')}}">Add Master Program</a></li>
                      <li><a href="{{url('admin/coursemaster')}}">All Master Programs</a></li>                       
                    </ul>
                  </li> 				  
				  @endif
				  -->
			<!--  @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('certification') )

				  <li><a><i class="fa fa-file"></i> Global Certification <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('admin/certificate/add')}}">Add Certification</a></li>
                      <li><a href="{{url('admin/certificate')}}">All Certification</a></li>                       
                    </ul>
                  </li> 
				  @endif-->
				  
				  @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('add_lead') )
				  <li><a><i class="fa fa-graduation-cap"></i>Lead <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      @if(Auth::user()->current_user_can('administrator') ||  Auth::user()->current_user_can('add_lead') )
                       <li><a href="{{url('admin/enterleads')}}">Add Lead</a></li>
                       @endif
                         @if(Auth::user()->current_user_can('administrator') ||  Auth::user()->current_user_can('show_lead') )
                      <li><a href="{{url('admin/lead')}}">All Lead</a></li>   
                      @endif
                       <!-- @if(Auth::user()->current_user_can('administrator')  ||  Auth::user()->current_user_can('show_analysis'))
                      <li><a href="{{url('admin/lead-analysis')}}">Daily Lead Analysis</a></li>      
                      <li><a href="{{url('admin/monthly-lead-analysis')}}">Monthly Lead Analysis</a></li>
                      <li><a href="{{url('admin/course-assignment')}}">Course Assignment</a></li>    
                      @endif-->
                    </ul>
                  </li> 
				  @endif 
				   @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('blog') )
				<li><a><i class="fa fa-rss"></i> Blog <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('admin/blog/add')}}">Add Blog</a></li>
                      <li><a href="{{url('admin/blog')}}">All Blog</a></li>                       
                    </ul>
                  </li> 
				  @endif
				  
				   @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('reviews') )
				  
				  <li><a><i class="fa fa-registered"></i>Reviews <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('admin/reviews/add')}}">Add Reviews</a></li>
                      <li><a href="{{url('admin/reviews')}}">All Reviews</a></li>                       
                    </ul>
                  </li> 
				    
				 @endif
				 
				  @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('placement') )
				  <li><a><i class="fa fa-graduation-cap"></i> Placement <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('admin/placement/add')}}">Add Placement</a></li>
                      <li><a href="{{url('admin/placement')}}">All Placement</a></li>                       
                    </ul>
                  </li> 
				  @endif
				   @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('careers') )
				  <li><a><i class="fa fa-graduation-cap"></i>Careers <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('admin/careers/add')}}">Add Careers</a></li>
                      <li><a href="{{url('admin/careers')}}">All Careers</a></li>                       
                    </ul>
                  </li> 
				  @endif
				   
                </ul>
              </div> 

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
		  