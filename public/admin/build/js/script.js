// ************
// X-CSRF-TOKEN
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
// X-CSRF-TOKEN
// ************ 

// **************
// SPINNER OBJECT
	var mainSpinner = (function(){
		var opts = {
		lines: 13 // The number of lines to draw
		, length: 28 // The length of each line
		, width: 14 // The line thickness
		, radius: 42 // The radius of the inner circle
		, scale: 1 // Scales overall size of the spinner
		, corners: 1 // Corner roundness (0..1)
		, color: '#000' // #rgb or #rrggbb or array of colors
		, opacity: 0.25 // Opacity of the lines
		, rotate: 0 // The rotation offset
		, direction: 1 // 1: clockwise, -1: counterclockwise
		, speed: 1 // Rounds per second
		, trail: 60 // Afterglow percentage
		, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
		, zIndex: 2e9 // The z-index (defaults to 2000000000)
		, className: 'spinner' // The CSS class to assign to the spinner
		, top: '50%' // Top position relative to parent
		, left: '50%' // Left position relative to parent
		, shadow: false // Whether to render a shadow
		, hwaccel: false // Whether to use hardware acceleration
		, position: 'absolute' // Element positioning
		};
		var spinnerBkgd = document.getElementById('spinnerBkgd');
		var target = document.getElementById('spinnerCntr');
		var spinner = new Spinner(opts);
		return {
			start:function(){
				spinner.spin(target);
				spinnerBkgd.style.display = 'block';
			},
			stop:function(){
				spinner.stop();
				spinnerBkgd.style.display = 'none';
			}
		}
	})();
// SPINNER OBJECT
// **************
   
  
var dataTablelead;
if($('#datatable-all-leads').length){
    $('#datatable-all-leads').find('#check-all').on('change',function(){
    if(this.checked){
    $('.check-box-lead').prop('checked',true);
    }else{
    $('.check-box-lead').prop('checked',false);
    }
    });
 var dataTablelead = $('#datatable-all-leads')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [50,100,250,500],
            ['50','100','250','500']
        ],
		  
	"ajax":{
		url:"/admin/get-lead",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;		
			d.search['leaddf']=$('*[name="search[leaddf]"]').val();
			d.search['leaddt']=$('*[name="search[leaddt]"]').val();	
			d.search['user']=$('*[name="search[user]"]').val();			 	
			d.search['source']=$('*[name="search[source]"]').val();	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
}




 var dataTableAllcourse = $('#datatable-all-course')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/course/get-course",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;	
			d.search['category']=$('*[name="search[category]"]').val();
			d.search['course_type']=$('*[name="search[course_type]"]').val();	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
    var dataTableAllSEOcourse = $('#datatable-all-SEO-course')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/seopage/get-seopage",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;	
			d.search['category']=$('*[name="search[category]"]').val();
			d.search['course_type']=$('*[name="search[course_type]"]').val();
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
    
 var dataTableAllUser = $('#datatable-all-users')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [                     
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                      
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/users/get-user",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
 
    
 var dataTablePermission = $('#datatable-permission')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [                     
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                      
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/permission/get-permission",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
 var dataTableRolePermission = $('#datatable-role-permission')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [                     
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                      
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/role-permission/get-role-permission",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
 
 var dataTableAllcourseMaster = $('#datatable-all-course-master')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/coursemaster/get-courseMaster",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
 var dataTableAllCategory = $('#datatable-all-category')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/category/get-category",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();


 var dataTableToolsCovered = $('#datatable-all-toolscovered')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		  
	"ajax":{
		url:"/admin/toolscovered/get-toolscovered",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();


 var dataTableClient = $('#datatable-all-client')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		  
	"ajax":{
		url:"/admin/client/get-client",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();


 var dataTableAllSocial = $('#datatable-all-social')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/social/get-social",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
 var dataTableAllspeciality = $('#datatable-all-speciality')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/speciality/get-speciality",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
 var dataTableAllSubCategory = $('#datatable-all-sub-category')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/subcategory/get-subcategory",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
 
 var dataTableAllCity = $('#datatable-all-city')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/city/get-city",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();



var dataTableAllpaymentMode = $('#datatable-all-paymentMode')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [                 
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/payment-mode/get-payment-mode",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
  
  
   var dataTableAllHomeSlider = $('#datatable-all-home-slider')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/homeslider/get-homeslider",
		data:function(d){		 
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();


//********datatable-all-Mobile-home-Banner
  var dataTableAllMobileBanner = $('#datatable-all-mobile-banner')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/mobilebanner/get-mobilebanner",
		data:function(d){		 
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();

 var dataTableAllFAQs = $('#datatable-all-faqs')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/FAQs/get-FAQs",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
 
 
 var dataTableAllCertificate = $('#datatable-all-Certificate')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/certificate/get-certificate",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
      
 
 var dataTableAllBlog = $('#datatable-all-blog')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/blog/get-blog",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
       
 
 var dataTableAllReviews= $('#datatable-all-reviews')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/reviews/get-reviews",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
       
 var dataTableAllTestimonial= $('#datatable-all-testimonial')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/testimonial/get-testimonial",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
      
 var dataTableAllPlacement= $('#datatable-all-placement')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/placement/get-placement",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
    
      
 var dataTableAllCareers= $('#datatable-all-careers')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                   {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                      
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/careers/get-careers",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
        
      
 var dataTableAllOffer= $('#datatable-all-offer')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/offer/get-offer",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;			 	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 
      
 var dataTableAllCoursePDF= $('#datatable-all-course-pdf')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
		 dom: "Blfrtip",
                buttons: [
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                      
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
	"ajax":{
		url:"/admin/coursepdf/get-coursepdf",
		data:function(d){		 
			
			d.page = (d.start/d.length)+1;	
			d.search['category']=$('*[name="search[category]"]').val();
			d.search['subcategory']=$('*[name="search[subcategory]"]').val();	
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
 

 
 $(document).on('change','#completecourse',function(e){
			e.preventDefault();
			$this = $(this);
			if($this.val()=='') return;	 
		 var bid= $('#batch_id').val();
		 
				$.ajax({
					"url":"/batch/course-status/"+$this.val()+"/"+bid,
					"type":"get",
					"success":function(data,textStatus,jqXHR){
					 
						if(data.statusCode){
							 alert(data.data.message);
						}else{
							alert(data.data.message);
						}
						 
					}
				});
		 
			mainSpinner.stop();
		});
		
		  
  
 var courseController = (function(){
		return {
			checked_Ids:[],				  
			saveCourseTitle:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 			mainSpinner.start();
				$.ajax({
					url:"/admin/course/saveCourseTitle",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});							 
						$("input[tyle=\"reset\"]").click();
						removeValidationErrors($this);
						window.location="/admin/course";	
						}else{
							 removeValidationErrors($this);
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCourseTitle:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseTitle/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){												
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});	
						 window.location.reload();
						 removeValidationErrors($this);	
						 
						}else{					 

						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});								
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			
        editSaveCourseExtraContent:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseExtraContent/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){												
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});	
						 removeValidationErrors($this);	
						  window.location.reload();
						}else{					 

						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});								
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCourseAbout:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseAbout/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){			
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCourseTopic:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseTopic/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){			
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							  window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseBatchVisibility:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseBatchVisibility/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
								 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveCurriculum:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCurriculum/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseCurriculum:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseCurriculum/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseRelated:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseRelated/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCourseCertificate:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseCertificate/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){		
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveCourseLearn:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveCourseLearn/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){		
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
						
			editSaveTrainerAbout:function(THIS,id){	
			var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveTrainerAbout/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){		
												
							$('#successMessageId .modal-title').text("Trainer Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Trainer Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveFAQ:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveFAQ/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){		
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			 
			  editSaveTestimonial:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/course/editSaveTestimonial/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){		
												
							$('#successMessageId .modal-title').text("Testimonial");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Testimonial");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			 
			status:function(id,val){
		      if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				 mainSpinner.start();
				$.ajax({
					url:"/admin/course/status/"+id+"/"+val,
					type:"post",					
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllcourse.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course Content status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();	
						 alert('some error');
					}
				});
				}
				
			}else{
				
				if(confirm("Are you sure you want to change the status to Inactive?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/course/status/"+id+"/"+val,
					type:"post",					
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllcourse.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course Content status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					     mainSpinner.stop();	
						 alert('some error');
					}
				});
				}
				
				
			}
			 	 
			},  
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {
				  mainSpinner.start();
				$.ajax({
					url:"/admin/course/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllcourse.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course Content Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}, 
			courseContentDelete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {
				  mainSpinner.start();
				$.ajax({
					url:"/admin/course/courseContentDelete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
					   
					}else{
							$('#successMessageId .modal-title').text("Course Content Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			
			courseAboutExcelDelete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {
				  mainSpinner.start();
				$.ajax({
					url:"/admin/course/courseAboutExcelDelete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						 window.location.reload();
						 
					}else{
							$('#successMessageId .modal-title').text("Course Content Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			 
			
		 
			
			
	};
	})();
	
	var homesliderController = (function(){
		return {
			checked_Ids:[],				  
			sliderSubmit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({	
					url:"/admin/homeslider/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						$('#successMessageId .modal-title').text("Home slider");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/homeslider";								
						}else{
							$('#successMessageId .modal-title').text("Home Bannar");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}		 
					}
				}); 
				 return false;	
			},
			editSaveHomeslider:function(THIS,id){
					
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/homeslider/editSaveHomeslider/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
						$('#successMessageId .modal-title').text("Home Bannar");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/homeslider";	
						}else{
							$('#successMessageId .modal-title').text("Home Slider");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}		 
					}
				}); 
				 return false;	
			},
			delete:function(id){		 
			 	if( confirm("Are you sure you want to delete?!") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/homeslider/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("home slider Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllHomeSlider.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("home slider Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 	if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/homeslider/status/"+id+"/"+val,
					type:"GET",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllHomeSlider.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/homeslider/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllHomeSlider.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}					
				}	
			}, 
			
			editMobilebanner:function(THIS,id){			
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/mobilebanner/editMobilebanner/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
						$('#successMessageId .modal-title').text("Mobile Bannar");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/homeslider";	
						}else{
							$('#successMessageId .modal-title').text("Home Slider");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}		 
					}
				}); 
				 return false;	
			},
			deleteBanner:function(id){		 
			 	if( confirm("Are you sure you want to delete?!") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/mobilebanner/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("home slider Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllMobileBanner.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("home slider Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			statusBanner:function(id,val){		 
			 	if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/mobilebanner/status/"+id+"/"+val,
					type:"GET",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllMobileBanner.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/mobilebanner/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllMobileBanner.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
						}
					});
				}					
			}	
		}
			
			
			
};
})();	
	
	
 var courseMasterController = (function(){
		return {
			checked_Ids:[],				  
			saveCourseMasterTitle:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/saveCourseMasterTitle",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});		
							removeValidationErrors($this);
						$("input[tyle=\"reset\"]").click();
						window.location="/admin/coursemaster";
						 
						}else{
							 removeValidationErrors($this);
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
            editSaveCourseCurriculumExcel:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseCurriculumExcel/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();	
						if(data.status){			
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							  window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			masterCurriculumExcelDelete:function(id){
		 
			 	if( confirm("Are You Sure Want to Deleted!") ) {
				  mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/masterCurriculumExcelDelete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						 window.location.reload();
						 
					}else{
							$('#successMessageId .modal-title').text("Course Content Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			
			editSaveCourseMasterTitle:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseMasterTitle/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							removeValidationErrors($this);							
						}else{					 

						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});								
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			 
			editSaveCourseMasterAbout:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseMasterAbout/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
								removeValidationErrors($this);	
								window.location.reload();
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
						    	mainSpinner.stop();
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			
			editSaveCourseToolsCovered:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseToolsCovered/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
											
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
								removeValidationErrors($this);	
								window.location.reload();
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
						    	mainSpinner.stop();
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveCourseClients:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseClients/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
											
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
								removeValidationErrors($this);	
								window.location.reload();
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
						    	mainSpinner.stop();
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseStructure:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseStructure/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
											
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
								removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
						    	mainSpinner.stop();
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseMasterPlacement:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseMasterPlacement/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
											
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
								removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
						    	mainSpinner.stop();
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseMasterRelated:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseMasterRelated/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
								removeValidationErrors($this);	
								window.location.reload();
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
						    	mainSpinner.stop();
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveFAQ:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start(); 
				$.ajax({
					url:"/admin/coursemaster/editSaveFAQ/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
													
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							removeValidationErrors($this);	
							window.location.reload();
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
						    	mainSpinner.stop();
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			  	editSaveTestimonial:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveTestimonial/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
							 						
						$('#successMessageId .modal-title').text("Testimonial");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						 		window.location.reload();
						}else{
							$('#successMessageId .modal-title').text("Testimonial Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCourseFooter:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/editSaveCourseFooter/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			status:function(id,val){
		 
			  if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				 mainSpinner.start(); 
				$.ajax({
					url:"/admin/coursemaster/status/"+id+"/"+val,
					type:"post",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course master Content status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllcourseMaster.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course master Content status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				
				} 
				}else{
					if( confirm("Are you sure you want to change the status to Inactive?") ) {
					     mainSpinner.start();
					$.ajax({
					url:"/admin/coursemaster/status/"+id+"/"+val,
					type:"post",
					//dataType:"json",	
					success:function(response){
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course master Content status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllcourseMaster.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course master Content status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
					}					
				}
			},  			 
			delete:function(id){	 
			 	if( confirm("Are you sure you want to delete?") ) {	
			 	     mainSpinner.start();
				$.ajax({
					url:"/admin/coursemaster/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){		
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Master Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllcourseMaster.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course Master Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}
			 
			
		 
			
			
	};
	})();
	
	
	
	var SEOController = (function(){
		return {
			checked_Ids:[],				  
			saveCourseTitle:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
		
 			mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/saveCourseTitle",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});							 
						$("input[tyle=\"reset\"]").click();
						removeValidationErrors($this);
						window.location="/admin/seopage";	
						}else{
							 removeValidationErrors($this);
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCourseSeoTitle:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseSeoTitle/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){												
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});	
							 window.location.reload();
						 removeValidationErrors($this);	
						 
						}else{					 

						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});								
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCourseSeoTopic:function(THIS,id){	
			  	var $this = $(THIS);
				var form = new FormData(THIS);					
				mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseSeoTopic/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){												
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});	
							 window.location.reload();
						 removeValidationErrors($this);	
						 
						}else{					 

						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});								
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},





            editSaveCourseAboutExtra:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseAboutExtra/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){												
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});	
						 removeValidationErrors($this);	
						  window.location.reload();
						}else{					 

						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});								
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseSeoAbout:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseSeoAbout/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){			
												
							$('#successMessageId .modal-title').text("SEO page Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseLearn:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseLearn/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){			
												
							$('#successMessageId .modal-title').text("SEO page Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseExtraContent:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseExtraContent/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){			
												
							$('#successMessageId .modal-title').text("SEO page Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseBatchVisibility:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseBatchVisibility/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
								 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveCurriculum:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCurriculum/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseCurriculum:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseCurriculum/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseRelated:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseRelated/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
								 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCourseCertificate:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveCourseCertificate/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){		
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
								 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveFAQ:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveFAQ/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){		
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
								 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			 
			 
			 editSaveTestimonial:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/editSaveTestimonial/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){		
												
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
								 window.location.reload();
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 
			status:function(id,val){
		      if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				 mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/status/"+id+"/"+val,
					type:"post",					
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllSEOcourse.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course Content status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();	
						 alert('some error');
					}
				});
				}
				
			}else{
				
				if(confirm("Are you sure you want to change the status to Inactive?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/status/"+id+"/"+val,
					type:"post",					
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllSEOcourse.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course Content status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					     mainSpinner.stop();	
						 alert('some error');
					}
				});
				}
				
				
			}
			 	 
			},  
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {
				  mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllSEOcourse.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Course Content Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}, 
			courseContentDelete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {
				  mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/courseContentDelete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							 window.location.reload();
					   
					}else{
							$('#successMessageId .modal-title').text("Course Content Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			
			courseAboutExcelDelete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {
				  mainSpinner.start();
				$.ajax({
					url:"/admin/seopage/courseAboutExcelDelete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Course Content Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						 window.location.reload();
						 
					}else{
							$('#successMessageId .modal-title').text("Course Content Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			 
			
		 
			
			
	};
	})();

 var certificateController = (function(){
		return {
			checked_Ids:[],				  
			saveCertificateTitle:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/certificate/saveCertificateTitle",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){
												
						$('#successMessageId .modal-title').text("Course Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});				 
						removeValidationErrors($this);	
						
						}else{
							 
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCertificateTitle:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		  mainSpinner.start();
				$.ajax({
					url:"/admin/certificate/editSaveCertificateTitle/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
											
						$('#successMessageId .modal-title').text("Certificate Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});	
							removeValidationErrors($this);	
						}else{					 

						$('#successMessageId .modal-title').text("Certificate Content");	
						$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});								
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCertificateOverview:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/certificate/editSaveCertificateOverview/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
											
							$('#successMessageId .modal-title').text("Certificate Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
								removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Certificate Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCertificateCurriculum:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/certificate/editSaveCertificateCurriculum/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
													
							$('#successMessageId .modal-title').text("Certificate Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Certificate Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCertificateRelated:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			  mainSpinner.start();
				$.ajax({
					url:"/admin/certificate/editSaveCertificateRelated/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
												
							$('#successMessageId .modal-title').text("Certificate Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
							removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Certificate Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});				 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						 
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveFAQ:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start(); 
				$.ajax({
					url:"/admin/certificate/editSaveFAQ/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
											
							$('#successMessageId .modal-title').text("Certificate FAQs");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
								removeValidationErrors($this);	
						}else{
							$('#successMessageId .modal-title').text("Certificate FAQs");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			 
			 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {
				 mainSpinner.start(); 
				$.ajax({
					url:"/admin/certificate/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Certificate Content Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCertificate.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Certificate Content Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}
			 
			
		 
			
			
	};
	})();
	
 
 var categoryController = (function(){
		return {
			checked_Ids:[],				  
			submit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/category/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){						
						
						$('#successMessageId .modal-title').text("Category");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/category";	
						removeValidationErrors($this);							
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCategory:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/category/editSaveCategory/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
									
						$('#successMessageId .modal-title').text("Category");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/category";	
							
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});			 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
	 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/category/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Category Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCategory.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Category Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			 	 
			status:function(id,val){
	 
			 if(val==true){
				if( confirm("Are You sure you want to change the status to Active?") ) {
				     mainSpinner.start();
				$.ajax({
				url:"/admin/category/status/"+id+"/"+val,
				type:"POST",

				success:function(response){	
                mainSpinner.stop();			
				if(response.status){
				$('#successMessageId .modal-title').text("Category Status");	
				$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
				$('#successMessageId').modal({keyboard:false,backdrop:'static'});
				$('#successMessageId').css({'width':'100%'});
				dataTableAllCategory.ajax.reload( null, false );   
				}else{
				$('#successMessageId .modal-title').text("Category Status");	
				$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
				$('#successMessageId').modal({keyboard:false,backdrop:'static'});
				$('#successMessageId').css({'width':'100%'});
				}						
				},
				error:function(response){
				    mainSpinner.stop();			
				alert('some error');
				}
				});
				}

				}else{
					if( confirm("Are you sure you want to Inactive?") ){
					     mainSpinner.start();
				$.ajax({
				url:"/admin/category/status/"+id+"/"+val,
				type:"POST",

				success:function(response){	
                mainSpinner.stop();			
				if(response.status){
				$('#successMessageId .modal-title').text("Category Status");	
				$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
				$('#successMessageId').modal({keyboard:false,backdrop:'static'});
				$('#successMessageId').css({'width':'100%'});
				dataTableAllCategory.ajax.reload( null, false );   
				}else{
				$('#successMessageId .modal-title').text("Category Status");	
				$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
				$('#successMessageId').modal({keyboard:false,backdrop:'static'});
				$('#successMessageId').css({'width':'100%'});
				}						
				},
				error:function(response){
				    mainSpinner.stop();			
				alert('some error');
				}
				});
				}
				}
			}
			 
			
		 
			
			
	};
	})();
	
	
	var paymentModeController = (function(){
		return {
			checked_Ids:[],				  
			Submit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
			 
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/payment-mode/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){						
						
						$('#successMessageId .modal-title').text("Payment mode");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/payment-mode";	
						removeValidationErrors($this);							
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSavepayMode:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/payment-mode/editSavepayMode/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
									
						$('#successMessageId .modal-title').text("Payment mode");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/payment-mode";	
							
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});			 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
	 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/payment-mode/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Payment mode Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllpaymentMode.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Payment mode Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			 	 
			status:function(id,val){
	 
			 if(val==true){
				if( confirm("Are You sure you want to change the status to Active?") ) {
				     mainSpinner.start();
				$.ajax({
				url:"/admin/payment-mode/status/"+id+"/"+val,
				type:"POST",

				success:function(response){	
                mainSpinner.stop();			
				if(response.status){
				$('#successMessageId .modal-title').text("Payment mode Status");	
				$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
				$('#successMessageId').modal({keyboard:false,backdrop:'static'});
				$('#successMessageId').css({'width':'100%'});
				dataTableAllpaymentMode.ajax.reload( null, false );   
				}else{
				$('#successMessageId .modal-title').text("Payment mode Status");	
				$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
				$('#successMessageId').modal({keyboard:false,backdrop:'static'});
				$('#successMessageId').css({'width':'100%'});
				}						
				},
				error:function(response){
				    mainSpinner.stop();			
				alert('some error');
				}
				});
				}

				}else{
					if( confirm("Are you sure you want to Inactive?") ){
					     mainSpinner.start();
				$.ajax({
				url:"/admin/payment-mode/status/"+id+"/"+val,
				type:"POST",

				success:function(response){	
                mainSpinner.stop();			
				if(response.status){
				$('#successMessageId .modal-title').text("Payment mode Status");	
				$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
				$('#successMessageId').modal({keyboard:false,backdrop:'static'});
				$('#successMessageId').css({'width':'100%'});
				dataTableAllpaymentMode.ajax.reload( null, false );   
				}else{
				$('#successMessageId .modal-title').text("Payment mode Status");	
				$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
				$('#successMessageId').modal({keyboard:false,backdrop:'static'});
				$('#successMessageId').css({'width':'100%'});
				}						
				},
				error:function(response){
				    mainSpinner.stop();			
				alert('some error');
				}
				});
				}
				}
			}
			 
			
		 
			
			
	};
	})();

	
var toolsCoveredController = (function(){
		return {
			checked_Ids:[],				  
			submit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/toolscovered/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){						
						
						$('#successMessageId .modal-title').text("Tools Covered");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/toolscovered";	
						removeValidationErrors($this);							
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveToolsCovered:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/toolscovered/editSaveToolsCovered/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
									
						$('#successMessageId .modal-title').text("Category");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/toolscovered";	
							
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});			 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
	 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/toolscovered/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Tools Covered Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableToolsCovered.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Category Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			 	 
			status:function(id,val){
	            if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				     mainSpinner.start();
				$.ajax({
					url:"/admin/toolscovered/status/"+id+"/"+val,
					type:"POST",
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("toolscovered Status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableToolsCovered.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("toolscovered Status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}else{
				
				
				if(confirm("Are you sure you want to change the status to Inactive?")){
				     mainSpinner.start();
				$.ajax({
					url:"/admin/toolscovered/status/"+id+"/"+val,
					type:"POST",
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("toolscovered Status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableToolsCovered.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("toolscovered Status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}
			
			}
			 
			
		 
			
			
	};
	})();
	
	
var clientController = (function(){
		return {
			checked_Ids:[],				  
			submit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/client/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){						
						
						$('#successMessageId .modal-title').text("Client");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/client";	
						removeValidationErrors($this);							
						}else{
							$('#successMessageId .modal-title').text("Client ");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveClient:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/client/editSaveClient/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
									
						$('#successMessageId .modal-title').text("Client");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/client";	
							
						}else{
							$('#successMessageId .modal-title').text("Client ");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});			 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
	 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/client/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Client Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableClient.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Client Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			 	 
			status:function(id,val){
	            if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				     mainSpinner.start();
				$.ajax({
					url:"/admin/client/status/"+id+"/"+val,
					type:"POST",
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("client Status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableClient.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("client Status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}else{
				
				
				if(confirm("Are you sure you want to change the status to Inactive?")){
				     mainSpinner.start();
				$.ajax({
					url:"/admin/client/status/"+id+"/"+val,
					type:"POST",
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Client Status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableClient.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Client Status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}
			
			}
			 
			
		 
			
			
	};
	})();
	
	
  	
 var socialController = (function(){
		return {
			checked_Ids:[],				  
			submit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/social/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){						
						 
						$('#successMessageId .modal-title').text("social");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/social";								
						}else{
							$('#successMessageId .modal-title').text("Social");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveSocial:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
             mainSpinner.start();
			
				$.ajax({
					url:"/admin/social/editSaveSocial/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
					 					
						$('#successMessageId .modal-title').text("Social");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/social";	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});			 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
	 
			 	if( confirm("Are you sure you want to delete?!") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/social/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("social Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllSocial.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Social Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}
			 
			
		 
			
			
	};
	})();
  	
  	
 var specialityController = (function(){
		return {
			checked_Ids:[],				  
			submit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/speciality/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){						
							 
						$('#successMessageId .modal-title').text("speciality");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/speciality";								
						}else{
							$('#successMessageId .modal-title').text("speciality");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveSpeciality:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
                mainSpinner.start();		
				$.ajax({
					url:"/admin/speciality/editSaveSpeciality/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
							 					
						$('#successMessageId .modal-title').text("speciality");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/speciality";	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});			 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
	 
			 	if( confirm("Are you sure you want to delete?!") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/speciality/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("speciality Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllspeciality.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("speciality Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}
			 
			
		 
			
			
	};
	})();
  	
 var subCategoryController = (function(){
		return {
			checked_Ids:[],				  
			submit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 			 mainSpinner.start();
				$.ajax({
					url:"/admin/subcategory/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){						
						 
						$('#successMessageId .modal-title').text("Sub Category");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/subcategory";								
						}else{
							$('#successMessageId .modal-title').text("Sub Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveSubCategory:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/subcategory/editSaveSubCategory/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
						 					
						$('#successMessageId .modal-title').text("Sub Category");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/subcategory";	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});			 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
	 
			 	if( confirm("Are you sure you want to delete?!") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/subcategory/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Sub Category Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllSubCategory.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Category Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			
			status:function(id,val){
	 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				 mainSpinner.start();	
				$.ajax({
					url:"/admin/subcategory/status/"+id+"/"+val,
					type:"POST",
					 
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Sub Category Status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllSubCategory.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Sub Category Status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				
				}else{
					
					if(confirm("Are you sure you want to change the status to Inactive?")){
					 mainSpinner.start();
				$.ajax({
					url:"/admin/subcategory/status/"+id+"/"+val,
					type:"POST",
					 
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Sub Category Status");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllSubCategory.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Sub Category Status");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
					
				}
			}
			 
			 
			
		 
			
			
	};
	})();
  	
	
 var cityController = (function(){
		return {
			checked_Ids:[],				  
			citySubmit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({
					url:"/admin/city/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						 
						$('#successMessageId .modal-title').text("City");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/city";								
						}else{
							$('#successMessageId .modal-title').text("City");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCity:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/city/editSaveCity/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
					 						
						$('#successMessageId .modal-title').text("City");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/city";	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?!") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/city/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("City Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCity.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("City Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			 
			status:function(id,val){
		 
			 	if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/city/status/"+id+"/"+val,
					type:"GET",
					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCity.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/city/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCity.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}					
				}
				
				
			}
			 
			
		 
			
			
	};
	})();
  
  
   var homebannarController = (function(){
		return {
			checked_Ids:[],				  
			bannarSubmit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({
					url:"/admin/homebannar/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						 
						$('#successMessageId .modal-title').text("Home bannar");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/homebannar";								
						}else{
							$('#successMessageId .modal-title').text("Home Bannar");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveHomebannar:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/homebannar/editSaveHomebannar/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
					 						
						$('#successMessageId .modal-title').text("Home Bannar");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/homebannar";	
						}else{
							$('#successMessageId .modal-title').text("Home Bannar");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){		 
			 	if( confirm("Are you sure you want to delete?!") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/homebannar/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("home bannar Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllHomeBannar.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("home bannar Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			 
			status:function(id,val){		 
			 	if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/homebannar/status/"+id+"/"+val,
					type:"GET",
					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllHomeBannar.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/homebannar/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllHomeBannar.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}					
				}
				
				
			}
			 
			
		 
			
			
	};
	})();
 
 var FAQsController = (function(){
		return {
			checked_Ids:[],				  
			FAQsSubmit:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		         mainSpinner.start();
				$.ajax({
					url:"/admin/FAQs/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						 
						$('#successMessageId .modal-title').text("FAQs");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/FAQs";								
						}else{
							$('#successMessageId .modal-title').text("FAQs");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveFAQs:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/FAQs/editSaveFAQs/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
					 					
						$('#successMessageId .modal-title').text("FAQs");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/FAQs";	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/FAQs/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("FAQs Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllFAQs.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("FAQs Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}
			 
			
		 
			
			
	};
	})();
  
 var blogController = (function(){
		return {
			checked_Ids:[],				  
			saveBlog:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({
					url:"/admin/blog/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						 
						$('#successMessageId .modal-title').text("Blog");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/blog";								
						}else{
							$('#successMessageId .modal-title').text("Blog");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveBlog:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/blog/editSaveBlog/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
					 					
						$('#successMessageId .modal-title').text("FAQs");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							 	
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			
			editSaveContent:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/blog/editSaveContent/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
					 					
						$('#successMessageId .modal-title').text("FAQs");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						 
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
		 	 
			editSaveImage:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/blog/editSaveImage/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
					 					
						$('#successMessageId .modal-title').text("FAQs");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						 
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
		  editSaveFaq:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/blog/editSaveFaq/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
					 					
						$('#successMessageId .modal-title').text("FAQs");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						 
						}else{
							$('#successMessageId .modal-title').text("Course Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
		  
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/blog/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Blog Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllBlog.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Blog Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
				  mainSpinner.start();
				$.ajax({
					url:"/admin/blog/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllBlog.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
				  mainSpinner.start();
				$.ajax({
					url:"/admin/blog/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllBlog.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				}
			}
			 
			 
			
		 
			
			
	};
	})();
  
 var reviewsController = (function(){
		return {
			checked_Ids:[],				  
			saveReviews:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 	        	  mainSpinner.start();
				$.ajax({
					url:"/admin/reviews/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
							 
						$('#successMessageId .modal-title').text("Reviews");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/reviews";								
						}else{
							$('#successMessageId .modal-title').text("reviews");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveReviews:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/reviews/editSaveReviews/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
							 						
						$('#successMessageId .modal-title').text("Reviews");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/reviews";	
						}else{
							$('#successMessageId .modal-title').text("Reviews Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/reviews/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Reviews Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllReviews.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Reviews Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){
		 
			  if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
				  mainSpinner.start();
				$.ajax({
					url:"/admin/reviews/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllReviews.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
				  mainSpinner.start();
				$.ajax({
					url:"/admin/reviews/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllReviews.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				}
				
			}
			 
			 
			
		 
			
			
	};
	})();
   
 var testimonialController = (function(){
		return {
			checked_Ids:[],				  
			saveTestimonial:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({
					url:"/admin/testimonial/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){		
							 					
						$('#successMessageId .modal-title').text("Testimonial");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/testimonial";								
						}else{
							$('#successMessageId .modal-title').text("Testimonial");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveTestimonial:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/testimonial/editSaveTestimonial/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){
							 						
						$('#successMessageId .modal-title').text("Testimonial");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/testimonial";	
						}else{
							$('#successMessageId .modal-title').text("Testimonial Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/testimonial/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Testimonial Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllTestimonial.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Testimonial Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
				  mainSpinner.start();
				$.ajax({
					url:"/admin/testimonial/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllTestimonial.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
				  mainSpinner.start();
				$.ajax({
					url:"/admin/testimonial/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllTestimonial.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
					
					
				}
				
			}
			 
			
		 
			
			
	};
	})();
	
 var placementController = (function(){
		return {
			checked_Ids:[],				  
			savePlacement:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({
					url:"/admin/placement/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						 
						$('#successMessageId .modal-title').text("Placement");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/placement";								
						}else{
							$('#successMessageId .modal-title').text("Placement");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSavePlacement:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/placement/editSavePlacement/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
						 					
						$('#successMessageId .modal-title').text("Placement");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/placement";	
						}else{
							$('#successMessageId .modal-title').text("Placement Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/placement/delete/"+id,
					type:"GET",
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Placement Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllPlacement.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Placement Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
				  mainSpinner.start();
				$.ajax({
					url:"/admin/placement/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllPlacement.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
				  mainSpinner.start();
				$.ajax({
					url:"/admin/placement/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllPlacement.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
					
					
				}
				
			}
			 
			
		 
			
			
	};
	})();
	
	
	var careersController = (function(){
		return {
			checked_Ids:[],				  
			saveCareers:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({
					url:"/admin/careers/saveCareers",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						 
						$('#successMessageId .modal-title').text("Careers");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/careers";								
						}else{
							$('#successMessageId .modal-title').text("Careers");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCareers:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/careers/editSaveCareers/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
						 					
						$('#successMessageId .modal-title').text("careers");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/careers";	
						}else{
							$('#successMessageId .modal-title').text("Careers Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/careers/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("Placement Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCareers.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Placement Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){
		 
			 	 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){	
				     mainSpinner.start();
				$.ajax({
					url:"/admin/careers/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");		
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCareers.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
				
				
				
			}else{
				if(confirm("Are you sure you want to change the status to Inactive?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/careers/status/"+id+"/"+val,
					type:"GET",				
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");		
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCareers.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}			
				
			}
			}
			 
			 
			
		 
			
			
	};
	})();
 
  
 var offerController = (function(){
		return {
			checked_Ids:[],				  
			saveOffer:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({
					url:"/admin/offer/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						 
						$('#successMessageId .modal-title').text("Offer");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/offer";								
						}else{
							$('#successMessageId .modal-title').text("Offer");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveOffer:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 mainSpinner.start();
				$.ajax({
					url:"/admin/offer/editSaveOffer/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
							 						
						$('#successMessageId .modal-title').text("Offer");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/offer";	
						}else{
							$('#successMessageId .modal-title').text("Offer Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/offer/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("offer Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllOffer.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Offer Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			}
			 
			
		 
			
			
	};
	})();
	
	
  var coursePdfController = (function(){
		return {
			checked_Ids:[],				  
			saveCoursePDF:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);		
 		  mainSpinner.start();
				$.ajax({
					url:"/admin/coursepdf/save",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					    mainSpinner.stop();			
						if(data.status){	
						 
						$('#successMessageId .modal-title').text("Course pdf");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/coursepdf";								
						}else{
							$('#successMessageId .modal-title').text("Course pdf");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveCoursePdf:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
	    	  mainSpinner.start();
				$.ajax({
					url:"/admin/coursepdf/editSaveCoursePDF/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                   processData: false,                      
					success:function(data){
					    mainSpinner.stop();			
						if(data.status){	
							 						
						$('#successMessageId .modal-title').text("Offer");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
							window.location="/admin/coursepdf";	
						}else{
							$('#successMessageId .modal-title').text("Offer Content");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    mainSpinner.stop();			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are You Sure Want to Deleted!") ) {	
				  mainSpinner.start();
				$.ajax({
					url:"/admin/coursepdf/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
					 mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("coursepdf Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCoursePDF.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("coursepdf Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}
			},status:function(id,val){		 
			 	if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){	
				     mainSpinner.start();
				$.ajax({
					url:"/admin/coursepdf/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");		
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCoursePDF.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}			
				
			}else{
				if(confirm("Are you sure you want to change the status to Inactive?")){
				  mainSpinner.start();
				$.ajax({
					url:"/admin/coursepdf/status/"+id+"/"+val,
					type:"GET",				
					success:function(response){	
					    mainSpinner.stop();			
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");		
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllCoursePDF.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
					    mainSpinner.stop();			
						 alert('some error');
					}
				});
				}				
			}			
			
			},
			coursepdfstatus:function(id,val){
				 
				mainSpinner.start();
				$.ajax({
					url:"/admin/coursepdf/coursepdfstatus/"+id+"/"+val,
					type:"GET",
					success:function(response){
						if(response.status){
							mainSpinner.stop();
							alert('Status successfully');
						 
							dataTableAllCoursePDF.ajax.reload(null,false);
							 
						}else{
							mainSpinner.stop();
								alert('Not Status successfully');							 					
							dataTableAllCoursePDF.ajax.reload(null,false);
						}
					},
					error:function(response){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-danger').removeClass('hide').html('Assign not Update');
					}
				});
				return false;
			}
			 
			 
			
		 
			
			
	};
	})();
 
  
 var userController = (function(){
		return {
			checked_Ids:[],
			registerSubmit:function(THIS){
			 
				var $this = $(THIS),
					data  = $this.json_encode();
					 
				$.ajax({
					url:"/admin/users/save",
					type:"POST",
					data:data,
					success:function(response){
						 mainSpinner.stop();	
						if(response.status){						 
						 
							$('#successMessageId .modal-title').text('Upate');	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");
							$('#successMessageId').modal({backdrop:"static",keyboard:false});
							window.location="/admin/users";        
							    removeValidationErrors($this);
							
						}else{							 
							$('#successMessageId .modal-title').text('Upate');	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");
							$('#successMessageId').modal({backdrop:"static",keyboard:false});					 
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						mainSpinner.stop();	
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){
							showValidationErrors($this,response.errors);
						 
						}else{
							mainSpinner.stop();	
							alert('Something went wrong');
						}
						 
					}
				});
				return false;
			},
			 editRegisterSubmit:function(THIS,id){
			 
				var $this = $(THIS),
					data  = $this.json_encode();
				
				$.ajax({
					url:"/admin/users/editSaveUser/"+id,
					type:"POST",
					data:data,
					success:function(response){
						 mainSpinner.stop();	
						if(response.status){						 
						
							$('#successMessageId .modal-title').text('Profile Upate');	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");
							$('#successMessageId').modal({backdrop:"static",keyboard:false});
							window.location="/admin/users";     
							removeValidationErrors($this);
							
						}else{							 
							$('#successMessageId .modal-title').text('Profile Upate');	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");
							$('#successMessageId').modal({backdrop:"static",keyboard:false});					 
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						mainSpinner.stop();	
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){
							showValidationErrors($this,response.errors);
						 
						}else{
							mainSpinner.stop();	
							alert('Something went wrong');
						}
						 
					}
				});
				return false;
			},
			 status:function(id,val){		 
			 	if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){				 
				$.ajax({
					url:"/admin/users/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
						mainSpinner.stop();						
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");		
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllUser.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
						mainSpinner.stop();	
						 alert('some error');
					}
				});
				}			
				
			}else{
				if(confirm("Are you sure you want to change the status to Inactive?")){
				 
				$.ajax({
					url:"/admin/users/status/"+id+"/"+val,
					type:"GET",				
					success:function(response){		
						mainSpinner.stop();						
					if(response.status){
						$('#successMessageId .modal-title').text("status successfully update");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");		
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllUser.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("Status successfully update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
						mainSpinner.stop();	
						 alert('some error');
					}
				});
				}				
			}			
			
			},			 
			 
			 delete:function(id){
		 
			 	if( confirm("Are You Sure Want to Deleted!") ) {			 
				$.ajax({
					url:"/admin/users/delete/"+id,
					type:"GET",
					//dataType:"json",	
					success:function(response){	
						mainSpinner.stop();						
					if(response.status){
						$('#successMessageId .modal-title').text("User Delete");	
						$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#successMessageId').modal({keyboard:false,backdrop:'static'});
						$('#successMessageId').css({'width':'100%'});
						dataTableAllUser.ajax.reload( null, false );   
					}else{
							$('#successMessageId .modal-title').text("User Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
					}						
					},
					error:function(response){
						mainSpinner.stop();	
						 alert('some error');
					}
				});
				}
			}
			
			
	};
	})();
  
  
  var permissionController = (function(){
		return {
			submit:function(THIS){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.json_encode();
				$.ajax({
					url:"/admin/permission",
					type:"POST",
					data:data,
					success:function(response){
						if(response.status){
							mainSpinner.stop();
							$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("User Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							dataTablePermission.ajax.reload(null,false);
							window.location="/admin/permission";	
						}else{
							mainSpinner.stop();
							$('#successMessageId .modal-title').text("User Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");	
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						mainSpinner.stop();
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				});
				return false;
			},

			editSaveSubmit:function(THIS,id){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.json_encode();
				$.ajax({
					url:"/admin/permission/saveEdit/"+id,
					type:"POST",
					data:data,
					success:function(response){
 
						if(response.status){
							mainSpinner.stop();
							$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							
							window.location="/admin/permission";	
						}else{
							mainSpinner.stop();
							$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Update");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");	
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
						
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						mainSpinner.stop();
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				});
				return false;
			},
			delete:function(id){
				if(confirm("Are You Sure Want to Deleted!")){
					mainSpinner.start();
					$.ajax({
						url:"/admin/permission/delete/"+id,
						type:"GET",
						success:function(response){
 
							if(response.status){
								mainSpinner.stop(); 
								dataTablePermission.ajax.reload(null,false);
								$('#successMessageId').modal();
								$('#successMessageId .modal-title').text("Permission Delete");	
								$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
								$('#successMessageId').modal({keyboard:false,backdrop:'static'});
								$('#successMessageId').css({'width':'100%'});
								
							}else{
								mainSpinner.stop();
							$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");	
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});						
								 
							}
						},
						error:function(response){
							mainSpinner.stop();
							 
						}
					});
				}
				return false;
			}
		};
	})();
 
 
 var leadController = (function(){
		return {
			 checked_Ids:[],
			selectLeads:function(){
				var $this = this;
				$this.checked_Ids = [];
				$('.check-box-lead:checked').each(function(){
					if(!(new String("on").valueOf() == $(this).val())){
						$this.checked_Ids.push($(this).val());
					}
				});
				if($this.checked_Ids.length == 0){
					alert('Please select data to delete lead!');
					return false;
				}
					 
					mainSpinner.start();
					
					$.ajax({
					url:"/admin/lead/selectTodeleteLeads",
					type:"POST",
					dataType:"json",
					data:{
						ids:$this.checked_Ids
					},
					success:function(data,textStatus,jqXHR){
							mainSpinner.stop();
							var response = JSON.parse(jqXHR.responseText);
						//	alert(response.statusCode);
				    	if(response.statusCode){
							$('#successMessageId').modal();
								$('#successMessageId .modal-title').text("Lead Delete");	
								$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.data.message+"</div>");			
								$('#successMessageId').modal({keyboard:false,backdrop:'static'});
								$('#successMessageId').css({'width':'100%'});
							dataTablelead.ajax.reload(null,false);						 
							 						 
						 
						 
							 
						}else{
							$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.data.message+"</div>");	
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});
							}
					},
					error:function(jqXHR,textStatus,errorThrown){
						
					}
				});
					 
				return false;
			}
		};
	})();
  
  
  
var rolePermissionController = (function(){
		return {
			submit:function(THIS){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.json_encode();
					
				$.ajax({
					url:"/admin/role-permission",
					type:"POST",
					data:data,
					success:function(response){
						if(response.status){
							mainSpinner.stop();
								$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Delete");	
								$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
								$('#successMessageId').modal({keyboard:false,backdrop:'static'});
								$('#successMessageId').css({'width':'100%'});
							dataTableRolePermission.ajax.reload(null,false);
						}else{
							mainSpinner.stop();
							$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");	
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});								
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						mainSpinner.stop();
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				});
				return false;
			},
			editRoleSaveSubmit:function(THIS,id){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.json_encode();
					
				$.ajax({
					url:"/admin/role-permission/update/"+id,
					type:"POST",
					data:data,
					success:function(response){
						if(response.status){
							mainSpinner.stop();
								$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Delete");	
								$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
								$('#successMessageId').modal({keyboard:false,backdrop:'static'});
								$('#successMessageId').css({'width':'100%'}); 
							window.location="/admin/role-permission";
						}else{
							mainSpinner.stop();
							$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");	
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});								
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						mainSpinner.stop();
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				});
				return false;
			},
			
			delete:function(id){
				if(confirm("Are you sure ??")){ 
					mainSpinner.start();
					$.ajax({
						url:"/admin/role-permission/delete/"+id,
						type:"GET",
						success:function(response){
							if(response.status){
								mainSpinner.stop();
								$('#successMessageId').modal();
								$('#successMessageId .modal-title').text("Permission Delete");	
								$('#successMessageId .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
								$('#successMessageId').modal({keyboard:false,backdrop:'static'});
								$('#successMessageId').css({'width':'100%'});
								dataTableRolePermission.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('#successMessageId').modal();
								$('#successMessageId .modal-title').text("Permission Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");	
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});							
								dataTableRolePermission.ajax.reload(null,false); 
							}
						},
						error:function(response){
							mainSpinner.stop();
							$('#successMessageId').modal();
							$('#successMessageId .modal-title').text("Permission Delete");	
							$('#successMessageId .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");	
							$('#successMessageId').modal({keyboard:false,backdrop:'static'});
							$('#successMessageId').css({'width':'100%'});	
						}
					});
				}
				return false;
			}
		};
	})();

  
  
  
  
	function removeValidationErrors($this){
		$this.find('.form-group').removeClass('has-error');
		$this.find('.help-block').remove();
	}
		 
		function showValidationErrors($this,errors){
 
		$this.find('.form-group').removeClass('has-error');
		$this.find('.help-block').remove();
		for (var key in errors) {
		if(errors.hasOwnProperty(key)){
		var el = $this.find('*[name="'+key+'"]');
		$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
		el.closest('.form-group').addClass('has-error');
		
		}
		}
		}
	 
 	  
	  $(".select_related_courses_side").select2({
			theme: "bootstrap",
			placeholder: "Select Related Course",
			allowClear: true,
			maximumSelectionSize: 6,
			containerCssClass: ":all:",
			width: 'resolve',
			 
		});	 
		
				
		$(".select_courses_module").select2(); 
		$(".select_skills").select2(); 
	 $(".select_related_certifications").select2({
			theme: "bootstrap",
			placeholder: "Select Related Certificate",
			allowClear: true,
			maximumSelectionSize: 6,
			containerCssClass: ":all:",
			width: 'resolve',
			 
		}); 	 
	  $(".select_related_courses").select2(); 
	 
/* $('form').submit(function(){
			$(this).find(':input[type=submit]').prop('disabled', true);
			return true;
			}); */
	 //$('.select_related_courses_side').select2();
	 
	 $('.select_course').select2();
	 $('.select_category').select2({
			theme: "bootstrap",
			placeholder: "Select Category",
			allowClear: true,
			maximumSelectionSize: 6,
			containerCssClass: ":all:",
			width: 'resolve',
			 
		});
		
        if("1" == jQuery('.course_type option:selected').val()){  
        jQuery('.course-module').hide();
        }
        if("1" == jQuery('.course_type_edit option:selected').val()){  
		jQuery('.course-module').hide();
		}
		$(document).on('change','.course_type',function(e){		
			if("1" == jQuery(this).val() ){
			$('.course-module').hide();
		}else{
			$('.course-module').show();
		} 
		});
		$(document).on('change','.course_type_edit',function(e){		
			if("1" == jQuery(this).val() ){
			$('.course-module').hide();			 
		}else{		 
			$('.course-module').show();		
		} 
		});
		
		
		$(document).on('change','.course_type',function(e){		
				if("2" == jQuery(this).val() ){
				if(jQuery('.select_category option:selected').val()){  
				var sid = $('.select_category').val();
				var cid = $('.select_courses_module').val();
				$.ajax({
					"url":"/admin/course/get_course_modul",
					"type":"GET",
					"data": {	'sid': sid,	'cid': cid,	},
					"success":function(data,textStatus,jqXHR){					 
						if(data.length>0){							 
						//	$('.show_courseModule').replaceWith(data);
							$('.show_courseModule').html(data);
						}						 
					}
				});				
				}
				}
				
				if("1" == jQuery(this).val()){
				    
				if(jQuery('.select_category option:selected').val()){  
				var sid = $('.select_category').val();
				var cid = $('.select_related_courses').val();
			
			
				$.ajax({
					"url":"/admin/course/get_course_modul",
					"type":"GET",
					"data": {	'sid': sid,	'cid': cid,	},
					"success":function(data,textStatus,jqXHR){					 
						if(data.length>0){							 
						//	$('.show_courseModule').replaceWith(data);
							$('.show_course_related').html(data);
						}			 
					}
				});				
				}
				}
		});
		
		
		
		if("" == jQuery('#city_territory option:selected').val()){
			jQuery('.online').hide();
			jQuery('.cityNCR').hide();
			jQuery('.allcity').hide();
		}
		 jQuery('#city_territory').change(function(){
		 
		if("Online" == jQuery(this).val() ){
			jQuery('.online').show();
			jQuery('.cityNCR').hide();
			jQuery('.allcity').hide();
			 
		} else if("cityNCR" == jQuery(this).val()){				 
			jQuery('.cityNCR').show();		 
			jQuery('.online').hide();
			jQuery('.allcity').hide();
			
		} else if("allcity" == jQuery(this).val()){			 		 		
			jQuery('.allcity').show();
			jQuery('.online').hide();			 
			jQuery('.cityNCR').hide();
			 
		} 
    	}); 
	
		
		$(document).on('change','.category',function(e){
		
			e.preventDefault();
			$this = $(this);
			if($this.val()=='') return;
	 
		 
				$.ajax({
					"url":"/admin/subcourse/get_subcourse_ajax/"+$this.val(),
					"type":"GET",
					"success":function(data,textStatus,jqXHR){
					 
						if(data.length>0){
							var html = '<option value="">Select Sub Category</option>';
						 
							for(var i in data){
								html+='<option value="'+data[i].id+'">'+data[i].subcategory+'</option>';
							}
							$('.select_subcategory').html(html);
						}
						 
					}
				});
		});
		
		
		jQuery(document).on('click', '.seo-visible', function(event){
		var THIS = jQuery(this);
		var id   = THIS.data('bid');
		THIS.prop('disabled', true);
		if(THIS.is(':checked')){
			/*console.log('true');*/
			var visib = 1;
			
		}else{
			/*console.log('false');*/
			var visib = 0;
		}
		console.log(visib);
		$.ajax({
					"url":"/admin/course/seo-visible",
					"type":"POST",
					"data": {	'course_id': id,	'visib': visib,	},
					"dataType": 'JSON',
					"success":function(response){	
 					
						if(response.status == 1){
					alert(response.msg);
					dataTableAllcourse.ajax.reload(null,false); 
				}
				else{
					if(response.visib == 1){
						THIS.prop('checked', false);
					}
					else if(response.visib == 0){
						THIS.prop('checked', true);
					}
				}
				//alert(JSON.stringify(response));
				THIS.prop('disabled', false);					 
					}
				});	
			});

	
	 	$('.select_subcategory').select2();
	 	$('.select_courses').select2();
	 	$('#capabilities').select2();
		
function handlingOffer() {
	if( "undefined" == typeof window.jQuery ) {
		throw new Error("This code required jQuery");
	}
	 
	var amount_to_decide = jQuery('#amount_to_decide');
	var discount = jQuery('#offer_percentage');	
	var f = parseInt(amount_to_decide.val());
	var d = parseInt(discount.val());	 
	var actualamt = parseInt(f*d/100);
	jQuery('#total_amount').val(amount_to_decide.val()-actualamt);	
	 

}


function isNumericKeyCheck(e){
		var keyCode = e.keyCode || e.charCode;
		if(keyCode>=48&&keyCode<=57)
		return true;
		else
		return false;
		}
	 
	 
	 
$(document).on('change','*[name="role"]',function(){
			var val = $(this).val();
			if(val=='')
				return;
			if(val =='user' || val =='manager' ){
				$('.manager').show();
			}else{
				$('.manager').hide();
			}
			mainSpinner.start();
			$.ajax({
				url:'/admin/role-permission/'+val,
				type:"GET",
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if(data.status){
						$('#capabilities').html(data.html);
						$('#capabilities').trigger('chosen:updated');
					}
					mainSpinner.stop();
				},
				error:function(jqXHR, textStatus, errorThrown){}
			});
		});
	// POPULA

	// ********
	// PICKLIST
		jQuery('#btnRight').click(function (e) {
		  jQuery('select').moveToListAndDelete('#source', '#destination');
		  e.preventDefault();
		});
		jQuery('#btnAllRight').click(function (e) {
		  jQuery('select').moveAllToListAndDelete('#source', '#destination');
		  e.preventDefault();
		});
		jQuery('#btnLeft').click(function (e) {
		  jQuery('select').moveToListAndDelete('#destination', '#source');
		  e.preventDefault();
		});
		jQuery('#btnAllLeft').click(function (e) {
		  jQuery('select').moveAllToListAndDelete('#destination', '#source');
		  e.preventDefault();
		});
	// PICKLIST
	// ********
		$('#role-form2').submit(function(){
		$('#destination option').prop('selected',true);
		return true;
		});

(function ($){   
    $.fn.moveToList = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option:selected');
        if (opts.length == 0) {
            alert("Nothing to move");
        }
        $(destinationList).append($(opts).clone());
    };
 
    $.fn.moveAllToList = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option');
        if (opts.length == 0) {
            alert("Nothing to move");
        }
        $(destinationList).append($(opts).clone());
    };  
    $.fn.moveToListAndDelete = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option:selected');
        if (opts.length == 0) {
            alert("Nothing to move");
        }
        $(opts).remove();
        $(destinationList).append($(opts).clone());
    }; 
    $.fn.moveAllToListAndDelete = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option');
        if (opts.length == 0) {
            alert("Nothing to move");
        }
        $(opts).remove();
        $(destinationList).append($(opts).clone());
    };   
    $.fn.removeSelected = function (list) {
        var opts = $(list + ' option:selected');
        if (opts.length == 0) {
            alert("Nothing to remove");
        }
        $(opts).remove();
    };  
    $.fn.moveUpDown = function (list, btnUp, btnDown) {
        var opts = $(list + ' option:selected');
        if (opts.length == 0) {
            alert("Nothing to move");
        }
        if (btnUp) {
            opts.first().prev().before(opts);
        } else if (btnDown) {
            opts.last().next().after(opts);
        }
    };
})(jQuery);







