<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\CategoriesController;
use App\Http\Controllers\Web\CoursesController;
use App\Http\Controllers\Web\DoctorateController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LeadController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\StaticPageController;
use Illuminate\Support\Facades\Route;

/*
| Public website routes (server-rendered Blade). Paths mirror the React
| router exactly. Pages are placeholder stubs for now; other agents fill them
| in. The /api/* routes (routes/api.php) are untouched and remain the source
| of truth for JSON behaviour.
*/



 Route::get('/cache-clear/', function () {

	$exitCode = Artisan::call('config:clear');
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('cache:clear');
	//$exitCode = Artisan::call('route:cache');
	Artisan::call('optimize:clear');

	// $exitCode = Artisan::call('optimize');

	return '<h1>Cache cleared</h1>';
});


Route::get('/', HomeController::class)->name('home');
Route::get('/privacy-policy', [PageController::class,'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-conditions', [PageController::class,'termsConditions'])->name('terms.conditions');
Route::get('/refund-cancellation-policy',[PageController::class,'refundCancellationPolicy'])->name('refund.cancellation.policy');



Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'blogdetails'])->name('blog.show');



Route::post('/enquiry', [CoursesController::class, 'enquiry'])->middleware('throttle:leads')->name('courses.enquiry');

//Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoriesController::class, 'show'])->name('categories.show');

Route::get('/about-us', [StaticPageController::class, 'about'])->name('aboutUs');
Route::get('/contact-us', [StaticPageController::class, 'contact'])->name('contactUs');
Route::get('/enquiry', [StaticPageController::class, 'enquiry'])->name('enquiry');
Route::get('/scholarship', [StaticPageController::class, 'scholarship'])->name('scholarship');
Route::get('/corporate-training', [StaticPageController::class, 'corporateTraining'])->name('corporate-training');

// Public lead intake (contact / enquiry / scholarship / corporate-training forms).
Route::post('/leads', [LeadController::class, 'store'])->middleware('throttle:leads')->name('leads.store');

Route::get('/doctorate', [DoctorateController::class, 'index'])->name('doctorate');
Route::get('/doctorate/{slug}', [DoctorateController::class, 'show'])->name('doctorate.show');

Route::get('/universities/{slug}', [DoctorateController::class, 'university'])->name('universities.show');
Route::get('/courses', [CoursesController::class, 'index'])->name('courses');
Route::get('/courses/{slug}', [CoursesController::class, 'coursesDetails'])->name('courses.show');



/*
| Server-rendered admin panel. Auth uses the App\Services\AdminAuth service
| directly (session token stored in the Laravel session). The /api/*
| endpoints stay untouched. Same throttle limiters as the API login/forgot.
*/

Auth::routes();

Route::prefix('admin')->name('admin.')->group(function () {
	
 

Route::get('login',function(){
	if(Auth::user()){
		return redirect(route('admin.dashboard'));
	}else{	
		return view('admin.user.login');		
	}
}); 
//Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
Route::get('check',[App\Http\Controllers\Auth\AuthController::class, 'check']);
Route::post('otp', [App\Http\Controllers\Auth\AuthController::class, 'authenticate']);
Route::get('/otp',[App\Http\Controllers\Auth\AuthController::class, 'getOTP']);

Route::post('/login',[App\Http\Controllers\Auth\AuthController::class, 'authenticate']);
Route::post('/check/login',[App\Http\Controllers\Auth\AuthController::class, 'authenticate']);
Route::get('/logout/',[App\Http\Controllers\Auth\AuthController::class, 'logout']);

Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

// *****************
// ROLES PERMISSIONS	
	Route::get('/permission',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'index']);
	Route::get('/permission/add',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'add']);
	Route::post('/permission',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'permissionStore']);
	Route::get('/permission/get-permission',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'getPaginatedPermissions']);
	Route::get('/permission/edit/{id}',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'editPermission']);
	Route::post('/permission/saveEdit/{id}',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'updatePermission']);
	Route::get('/permission/delete/{id}',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'destroyPermission']);
	
	Route::get('/role-permission',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'rolePermissionIndex']);
	Route::post('/role-permission',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'rolePermissionStore']);
	Route::get('/role-permission/get-role-permission',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'getPaginatedRolesPermissions']);
	Route::get('/role-permission/update/{id}',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'editRolePermission']);
	Route::post('/role-permission/update/{id}',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'updateRolePermission']);
	Route::get('/role-permission/delete/{id}',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'destroyRolePermission']);
	Route::get('/role-permission/{id}',[App\Http\Controllers\Admin\RolesPermissionsController::class, 'getRolePermissions']);
// ROLES PERMISSIONS
// *****************
 
 
 
 	  //lead 
    Route::get('lead',[App\Http\Controllers\Admin\LeadController::class, 'index']);
    Route::get('lead-analysis',[App\Http\Controllers\Admin\LeadController::class,'leadanalysis']);
    Route::get('get-lead',[App\Http\Controllers\Admin\LeadController::class,'getLeadPagination']);
    Route::post('lead/selectTodeleteLeads',[App\Http\Controllers\Admin\LeadController::class,'selectTodeleteLeads']);
    Route::get('getleadcount',[App\Http\Controllers\Admin\LeadController::class,'getleadcount']);
   
    Route::get('monthly-lead-analysis',[App\Http\Controllers\Admin\LeadController::class,'monthlyleadanalysis']);
    Route::get('lead/get-monthly-lead-analysis',[App\Http\Controllers\Admin\LeadController::class,'getMonthlyPaginationLeadAnalysis']);
    Route::get('course-assignment',[App\Http\Controllers\Admin\LeadController::class,'courseassignment']);  
    Route::get('get-assign-course',[App\Http\Controllers\Admin\LeadController::class,'getCourseAssignmentPagination']);



 //User Profile
Route::get('/profile',[App\Http\Controllers\Admin\ProfileController::class, 'index']); 
Route::post('/profile',[App\Http\Controllers\Admin\ProfileController::class, 'edit']);
Route::get('/profile/del_icon/{id}',[App\Http\Controllers\Admin\ProfileController::class, 'del_icon']);
Route::get('/profile/view/{id}',[App\Http\Controllers\Admin\ProfileController::class, 'view']);
Route::get('/profile/delete/{id}',[App\Http\Controllers\Admin\ProfileController::class, 'destroy']);
Route::get('/profile/status/{id}/{val}',[App\Http\Controllers\Admin\ProfileController::class, 'status']);


Route::get('/change-password/',[App\Http\Controllers\Admin\ChangepasswordController::class, 'index']);
Route::post('/change-password/',[App\Http\Controllers\Admin\ChangepasswordController::class, 'edit']);
 
// users
Route::get('users',[App\Http\Controllers\Admin\UserController::class, 'index']);
Route::get('users/add',[App\Http\Controllers\Admin\UserController::class, 'create']);
Route::post('users/save',[App\Http\Controllers\Admin\UserController::class, 'saveUser']); 
Route::get('/users/edit/{id}',[App\Http\Controllers\Admin\UserController::class, 'edit']);
Route::post('/users/editSaveUser/{id}',[App\Http\Controllers\Admin\UserController::class, 'editSaveUser']);
Route::get('/users/status/{id}/{val}',[App\Http\Controllers\Admin\UserController::class, 'status']);
Route::get('/users/delete/{id}',[App\Http\Controllers\Admin\UserController::class, 'delete']);
Route::get('/users/get-user',[App\Http\Controllers\Admin\UserController::class, 'getUserPagination']);
Route::get('/users/del_icon/{id}',[App\Http\Controllers\Admin\UserController::class, 'del_icon']);


// course
Route::get('course', [App\Http\Controllers\Admin\CourseController::class, 'index'])->middleware('auth');
Route::get('course/add',[App\Http\Controllers\Admin\CourseController::class, 'add'])->middleware('auth');
Route::get('course/edit/{id}', [App\Http\Controllers\Admin\CourseController::class, 'edit']);
Route::post('course/saveCourseTitle', [App\Http\Controllers\Admin\CourseController::class, 'saveCourseTitle']);
Route::post('course/editSaveCourseTitle/{id}', [App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseTitle']);
Route::post('course/editSaveCourseOverview/{id}', [App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseOverview']);
Route::post('course/editSaveCourseAbout/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseAbout']);
Route::post('course/editSaveCourseLearn/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseLearn']);
Route::post('course/editSaveTrainerAbout/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveTrainerAbout']);
Route::post('course/editSaveCourseExtraContent/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseExtraContent']);
Route::post('course/editSaveCourseTopic/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseTopic']);
Route::post('course/editSaveCourseAboutExcel/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseAboutExcel']);
Route::post('course/editSaveCourseBatchVisibility/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseBatchVisibility']);
Route::post('course/editSaveCurriculum/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCurriculum']);
Route::post('course/editSaveCourseCurriculum/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseCurriculum']);
Route::post('course/editSaveCourseRelated/{id}', [App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseRelated']);
Route::post('course/editSaveCourseCertificate/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveCourseCertificate']);
Route::post('course/editSaveFAQ/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveFAQ']);
Route::post('course/editSaveTestimonial/{id}',[App\Http\Controllers\Admin\CourseController::class, 'editSaveTestimonial']);
Route::get('/course/get-course',[App\Http\Controllers\Admin\CourseController::class, 'getCoursePagination'] );
Route::get('/course/del_icon/{id}',[App\Http\Controllers\Admin\CourseController::class, 'del_icon']);
Route::get('/course/del_image/{id}',[App\Http\Controllers\Admin\CourseController::class, 'del_image']);
Route::get('/course/get_course_ajax',[App\Http\Controllers\Admin\CourseController::class, 'getCourseAjax']);
Route::get('/course/delete/{id}',[App\Http\Controllers\Admin\CourseController::class, 'delete']);
Route::get('/course/courseContentDelete/{id}',[App\Http\Controllers\Admin\CourseController::class, 'courseContentDelete']);
Route::get('/course/courseAboutExcelDelete/{id}',[App\Http\Controllers\Admin\CourseController::class, 'courseAboutExcelDelete']);
 
Route::post('/course/status/{id}/{val}',[App\Http\Controllers\Admin\CourseController::class, 'status']);
Route::post('/course/seo-visible',[App\Http\Controllers\Admin\CourseController::class, 'seovisible']);
 
Route::get('/course/download-template', [App\Http\Controllers\Admin\CourseController::class, 'downloadExcelFormate'])
    ->name('course.download-template');


Route::get('/course/get_course_modul',[App\Http\Controllers\Admin\CourseController::class, 'getCourseMadul']);
Route::get('/course/get_course_modul_edit',[App\Http\Controllers\Admin\CourseController::class, 'getCourseMadulEdit']);
Route::get('/course/get_course_releted_edit',[App\Http\Controllers\Admin\CourseController::class, 'getCourseReletedEdit']);

// SEO PAge


Route::get('seopage',[App\Http\Controllers\Admin\SeoPageController::class, 'index'])->middleware('auth');

//Route::get('seopage', 'Admin\SeoPageController@index')->middleware('auth');

Route::get('/seopage/add',[App\Http\Controllers\Admin\SeoPageController::class, 'add']);


Route::get('seopage/edit/{id}', [App\Http\Controllers\Admin\SeoPageController::class, 'edit']);
Route::post('seopage/saveCourseTitle',[App\Http\Controllers\Admin\SeoPageController::class, 'saveCourseTitle'] );
Route::post('seopage/editSaveCourseSeoTitle/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseTitle']);
Route::post('seopage/editSaveCourseAboutExtra/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseAboutExtra'] );
Route::post('seopage/editSaveCourseOverview/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseOverview'] );
Route::post('seopage/editSaveCourseSeoAbout/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseSeoAbout']);
Route::post('seopage/editSaveCourseSeoTopic/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseSeoTopic']);
Route::post('seopage/editSaveTrainerAbout/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveTrainerAbout']);
Route::post('seopage/editSaveCourseLearn/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseLearn']);
Route::post('seopage/editSaveCourseExtraContent/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseExtraContent']);
Route::post('seopage/editSaveCourseAboutExcel/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseAboutExcel'] );
Route::post('seopage/editSaveCourseBatchVisibility/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseBatchVisibility'] );
Route::post('seopage/editSaveCurriculum/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCurriculum']);
Route::post('seopage/editSaveCourseCurriculum/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseCurriculum'] );
Route::post('seopage/editSaveCourseRelated/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseRelated'] );
Route::post('seopage/editSaveCourseCertificate/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveCourseCertificate'] );
Route::post('seopage/editSaveFAQ/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveFAQ']);
Route::post('seopage/editSaveTestimonial/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'editSaveTestimonial']);
Route::get('/seopage/get-seopage',[App\Http\Controllers\Admin\SeoPageController::class, 'getCoursePagination']);
Route::get('/seopage/del_icon/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'del_icon']);
Route::get('/seopage/del_image/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'del_image']);
Route::get('/seopage/get_course_ajax',[App\Http\Controllers\Admin\SeoPageController::class, 'getCourseAjax']);
Route::get('/seopage/delete/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'delete']);
Route::get('/seopage/courseContentDelete/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'courseContentDelete']);
Route::get('/seopage/courseAboutExcelDelete/{id}',[App\Http\Controllers\Admin\SeoPageController::class, 'courseAboutExcelDelete']);
Route::post('/seopage/downloadExcelFormate',[App\Http\Controllers\Admin\SeoPageController::class, 'downloadExcelFormate']);
Route::post('/seopage/status/{id}/{val}',[App\Http\Controllers\Admin\SeoPageController::class, 'status']);

Route::post('/seopage/get_coursesubcategory',[App\Http\Controllers\Admin\SeoPageController::class, 'getCourseSubCategory']);
Route::post('/seopage/get_coursecategoryType',[App\Http\Controllers\Admin\SeoPageController::class, 'get_coursecategoryType']);
Route::post('/seopage/get_category_course',[App\Http\Controllers\Admin\SeoPageController::class, 'getCourseName']);
Route::post('/seopage/get_courseCity',[App\Http\Controllers\Admin\SeoPageController::class, 'getCourseCity']);
Route::post('/seopage/get_courseCityOnline',[App\Http\Controllers\Admin\SeoPageController::class, 'getcourseCityOnline']);
Route::post('/seopage/get_courseNCRCity',[App\Http\Controllers\Admin\SeoPageController::class, 'getcourseNCRCity']);

Route::post('/seocategory_pdf/get_seocategory_pdf',[App\Http\Controllers\Admin\SeoPageController::class, 'getSEOCategoryPDF']);
Route::post('/get_seocategory_course_pdf/get_seocourse_pdf',[App\Http\Controllers\Admin\SeoPageController::class, 'getSEOCoursePdf']);

Route::get('/course/get_seo_course_releted_edit',[App\Http\Controllers\Admin\SeoPageController::class, 'getSEOCourseReletedEdit']);
 

// Course Master

Route::get('coursemaster',[App\Http\Controllers\Admin\CourseMasterController::class, 'index']);
 
Route::get('coursemaster/add',[App\Http\Controllers\Admin\CourseMasterController::class, 'add']);
Route::get('coursemaster/edit/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'edit']);
Route::post('coursemaster/saveCourseMasterTitle',[App\Http\Controllers\Admin\CourseMasterController::class, 'saveCourseMasterTitle']);
Route::post('coursemaster/editSaveCourseCurriculumExcel/{id}', [App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseCurriculumExcel']);
Route::get('/coursemaster/masterCurriculumExcelDelete/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'masterCurriculumExcelDelete']);
Route::post('coursemaster/editSaveCourseMasterTitle/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseMasterTitle'] );
Route::post('coursemaster/editSaveCourseMasterAbout/{id}', [App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseMasterAbout']);
 
 
Route::post('coursemaster/editSaveCourseToolsCovered/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseToolsCovered'] );
Route::post('coursemaster/editSaveCourseClients/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseClients']);
Route::post('coursemaster/editSaveCourseStructure/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseStructure']);
Route::post('coursemaster/editSaveCourseMasterPlacement/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseMasterPlacement']);
Route::post('coursemaster/editSaveCourseMasterRelated/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseMasterRelated']);
Route::post('coursemaster/editSaveCourseFooter/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveCourseFooter'] );
Route::post('coursemaster/editSaveFAQ/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveFAQ']);
Route::post('coursemaster/editSaveTestimonial/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'editSaveTestimonial']);
Route::get('/coursemaster/get-courseMaster',[App\Http\Controllers\Admin\CourseMasterController::class, 'getCourseMasterPagination']);
Route::get('/coursemaster/del_icon/{id}', [App\Http\Controllers\Admin\CourseMasterController::class, 'del_icon']);
Route::get('/coursemaster/del_image/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'del_image']); 
Route::get('/coursemaster/delete/{id}',[App\Http\Controllers\Admin\CourseMasterController::class, 'delete']);
Route::post('/coursemaster/status/{id}/{val}',[App\Http\Controllers\Admin\CourseMasterController::class, 'status']);


// certificate
 
Route::get('certificate',[App\Http\Controllers\Admin\CertificateController::class, 'index']);
Route::get('certificate/add', [App\Http\Controllers\Admin\CertificateController::class, 'add']);
Route::get('certificate/edit/{id}',[App\Http\Controllers\Admin\CertificateController::class, 'edit']);
Route::post('certificate/saveCertificateTitle',[App\Http\Controllers\Admin\CertificateController::class, 'saveCertificateTitle'] );
Route::post('certificate/editSaveCertificateTitle/{id}', [App\Http\Controllers\Admin\CertificateController::class, 'editSaveCertificateTitle']);
Route::post('certificate/editSaveCertificateOverview/{id}', [App\Http\Controllers\Admin\CertificateController::class, 'editSaveCertificateOverview']);
Route::post('certificate/editSaveCertificateCurriculum/{id}',[App\Http\Controllers\Admin\CertificateController::class, 'editSaveCertificateCurriculum'] );
Route::post('certificate/editSaveCertificateRelated/{id}', [App\Http\Controllers\Admin\CertificateController::class, 'editSaveCertificateRelated']);
Route::post('certificate/editSaveFAQ/{id}',[App\Http\Controllers\Admin\CertificateController::class, 'editSaveFAQ']);
Route::get('/certificate/get-certificate',[App\Http\Controllers\Admin\CertificateController::class, 'getCertificatePagination'] );
Route::get('/certificate/del_icon/{id}',[App\Http\Controllers\Admin\CertificateController::class, 'del_icon']);
Route::get('/certificate/get_certificate_ajax',[App\Http\Controllers\Admin\CertificateController::class, 'getCertificateAjax']);
Route::get('/certificate/delete/{id}',[App\Http\Controllers\Admin\CertificateController::class, 'delete']);

 
// Category
Route::get('category',[App\Http\Controllers\Admin\CategoryController::class, 'index']);
Route::get('category/add',[App\Http\Controllers\Admin\CategoryController::class, 'create']);
Route::post('category/save',[App\Http\Controllers\Admin\CategoryController::class, 'saveCategory']); 
Route::get('/category/edit/{id}',[App\Http\Controllers\Admin\CategoryController::class, 'edit']);
Route::post('/category/editSaveCategory/{id}',[App\Http\Controllers\Admin\CategoryController::class, 'editSaveCategory']);
Route::post('/category/status/{id}/{val}',[App\Http\Controllers\Admin\CategoryController::class, 'status']);
Route::get('/category/delete/{id}',[App\Http\Controllers\Admin\CategoryController::class, 'delete']);
Route::get('/category/get-category',[App\Http\Controllers\Admin\CategoryController::class, 'getCategoryPagination']);
Route::get('/category/del_icon/{id}',[App\Http\Controllers\Admin\CategoryController::class, 'del_icon']);
Route::post('/getcategory/get_video_link',[App\Http\Controllers\Admin\CategoryController::class, 'getvideolink']);

// Sub Category
Route::get('subcategory',[App\Http\Controllers\Admin\SubCategoryController::class, 'index']);
Route::get('subcategory/add',[App\Http\Controllers\Admin\SubCategoryController::class, 'create']);
Route::post('subcategory/save',[App\Http\Controllers\Admin\SubCategoryController::class, 'saveSubCategory']); 
Route::get('/subcategory/edit/{id}',[App\Http\Controllers\Admin\SubCategoryController::class, 'edit']);
Route::post('/subcategory/editSaveSubCategory/{id}',[App\Http\Controllers\Admin\SubCategoryController::class, 'editSaveSubCategory']);
Route::get('/subcategory/delete/{id}',[App\Http\Controllers\Admin\SubCategoryController::class, 'delete']);
Route::get('/subcategory/get-subcategory',[App\Http\Controllers\Admin\SubCategoryController::class, 'getSubCategoryPagination']);
Route::get('/subcourse/get_subcourse_ajax/{id}',[App\Http\Controllers\Admin\SubCategoryController::class, 'getSubCourseAjax']);
Route::post('/subcategory/get_subcategory',[App\Http\Controllers\Admin\SubCategoryController::class, 'getSubCategory']);

Route::post('/subcategory_pdf/get_subcategory_pdf',[App\Http\Controllers\Admin\SubCategoryController::class, 'getSubCategoryPDF']);
Route::post('/get_category_course_pdf/get_course_pdf',[App\Http\Controllers\Admin\SubCategoryController::class, 'getCoursePdf']);

Route::post('/subcategory/status/{id}/{val}',[App\Http\Controllers\Admin\SubCategoryController::class, 'status']);
Route::get('/subcategory/del_icon/{id}',[App\Http\Controllers\Admin\SubCategoryController::class, 'del_icon']);
Route::get('/subcategory/del_image/{id}',[App\Http\Controllers\Admin\SubCategoryController::class, 'del_image']);

//course city
Route::get('city',[App\Http\Controllers\Admin\CityController::class, 'index']);
Route::get('city/add',[App\Http\Controllers\Admin\CityController::class, 'create']);
Route::post('city/save',[App\Http\Controllers\Admin\CityController::class, 'saveCity']); 
Route::get('/city/edit/{id}',[App\Http\Controllers\Admin\CityController::class, 'edit']);
Route::post('/city/editSaveCity/{id}',[App\Http\Controllers\Admin\CityController::class, 'editSaveCity']);
Route::get('/city/delete/{id}',[App\Http\Controllers\Admin\CityController::class, 'delete']);
Route::get('/city/get-city',[App\Http\Controllers\Admin\CityController::class, 'getCityPagination']);
Route::get('/city/status/{id}/{val}',[App\Http\Controllers\Admin\CityController::class, 'status']);
//
//Payment Mode
Route::get('payment-mode',[App\Http\Controllers\Admin\PaymentModeController::class, 'index']);
Route::get('payment-mode/add',[App\Http\Controllers\Admin\PaymentModeController::class, 'create']);
Route::post('payment-mode/save',[App\Http\Controllers\Admin\PaymentModeController::class, 'savePayMode']); 
Route::get('/payment-mode/edit/{id}',[App\Http\Controllers\Admin\PaymentModeController::class, 'edit']);
Route::post('/payment-mode/editSavepayMode/{id}',[App\Http\Controllers\Admin\PaymentModeController::class, 'editSavePayMode']);
Route::get('/payment-mode/delete/{id}',[App\Http\Controllers\Admin\PaymentModeController::class, 'delete']);
Route::get('/payment-mode/get-payment-mode',[App\Http\Controllers\Admin\PaymentModeController::class, 'getPayModePagination']);
Route::get('/payment-mode/status/{id}/{val}',[App\Http\Controllers\Admin\PaymentModeController::class, 'status']);
Route::get('/payment-mode/del_icon/{id}',[App\Http\Controllers\Admin\PaymentModeController::class, 'del_icon']);
 
 
// Tools Covered
Route::get('toolscovered',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'index']);
Route::get('toolscovered/add',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'create']);
Route::post('toolscovered/save',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'saveToolsCovered']); 
Route::get('/toolscovered/edit/{id}',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'edit']);
Route::post('/toolscovered/editSaveToolsCovered/{id}',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'editSaveToolsCovered']);
Route::post('/toolscovered/status/{id}/{val}',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'status']);
Route::get('/toolscovered/delete/{id}',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'delete']);
Route::get('/toolscovered/get-toolscovered',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'getToolsCoveredPagination']);
Route::get('/toolscovered/del_icon/{id}',[App\Http\Controllers\Admin\ToolsCoveredController::class, 'del_icon']);



// Client
Route::get('client',[App\Http\Controllers\Admin\ClientController::class, 'index']);
Route::get('client/add',[App\Http\Controllers\Admin\ClientController::class, 'create']);
Route::post('client/save',[App\Http\Controllers\Admin\ClientController::class, 'saveClient']); 
Route::get('/client/edit/{id}',[App\Http\Controllers\Admin\ClientController::class, 'edit']);
Route::post('/client/editSaveClient/{id}',[App\Http\Controllers\Admin\ClientController::class, 'editSaveClient']);
Route::post('/client/status/{id}/{val}',[App\Http\Controllers\Admin\ClientController::class, 'status']);
Route::get('/client/delete/{id}',[App\Http\Controllers\Admin\ClientController::class, 'delete']);
Route::get('/client/get-client',[App\Http\Controllers\Admin\ClientController::class, 'getClientPagination']);
Route::get('/client/del_icon/{id}',[App\Http\Controllers\Admin\ClientController::class, 'del_icon']);

 
// Social
Route::get('social',[App\Http\Controllers\Admin\SocialController::class, 'index']);
Route::get('social/add',[App\Http\Controllers\Admin\SocialController::class, 'create']);
Route::post('social/save',[App\Http\Controllers\Admin\SocialController::class, 'saveSocial']); 
Route::get('/social/edit/{id}',[App\Http\Controllers\Admin\SocialController::class, 'edit']);
Route::post('/social/editSaveSocial/{id}',[App\Http\Controllers\Admin\SocialController::class, 'editSaveSocial']);
Route::get('/social/delete/{id}',[App\Http\Controllers\Admin\SocialController::class, 'delete']);
Route::get('/social/get-social',[App\Http\Controllers\Admin\SocialController::class, 'getSocialPagination']);
Route::get('/social/del_icon/{id}', [App\Http\Controllers\Admin\SocialController::class, 'del_icon']);


 
 
 //FAQs
Route::get('FAQs',[App\Http\Controllers\Admin\FAQsController::class, 'index']);
Route::get('FAQs/add',[App\Http\Controllers\Admin\FAQsController::class, 'create']);
Route::post('FAQs/save',[App\Http\Controllers\Admin\FAQsController::class, 'saveFAQs']); 
Route::get('/FAQs/edit/{id}',[App\Http\Controllers\Admin\FAQsController::class, 'edit']);
Route::post('/FAQs/editSaveFAQs/{id}',[App\Http\Controllers\Admin\FAQsController::class, 'editSaveFAQs']);
Route::get('/FAQs/delete/{id}',[App\Http\Controllers\Admin\FAQsController::class, 'delete']);
Route::get('/FAQs/get-FAQs',[App\Http\Controllers\Admin\FAQsController::class, 'getFAQsPagination']);
 
  
 //Blog
Route::get('blog',[App\Http\Controllers\Admin\BlogController::class, 'index']);
Route::get('blog/add',[App\Http\Controllers\Admin\BlogController::class, 'create']);
Route::post('blog/save',[App\Http\Controllers\Admin\BlogController::class, 'saveBlog']); 
Route::get('/blog/edit/{id}',[App\Http\Controllers\Admin\BlogController::class, 'edit']);
Route::post('/blog/editSaveBlog/{id}',[App\Http\Controllers\Admin\BlogController::class, 'editSaveBlog']);
Route::post('/blog/editSaveContent/{id}',[App\Http\Controllers\Admin\BlogController::class, 'editSaveContent']);
Route::post('/blog/editSaveImage/{id}',[App\Http\Controllers\Admin\BlogController::class, 'editSaveImage']);
Route::post('/blog/editSaveFaq/{id}',[App\Http\Controllers\Admin\BlogController::class, 'editSaveFaq']);
Route::get('/blog/delete/{id}',[App\Http\Controllers\Admin\BlogController::class, 'delete']);
Route::get('/blog/get-blog',[App\Http\Controllers\Admin\BlogController::class, 'getBlogPagination']);
Route::get('/blog/del_icon/{id}',[App\Http\Controllers\Admin\BlogController::class, 'del_icon']);
Route::get('/blog/del_image/{id}', [App\Http\Controllers\Admin\BlogController::class, 'del_image']);
Route::get('/blog/status/{id}/{val}',[App\Http\Controllers\Admin\BlogController::class, 'status']);
 
 //Reviews
Route::get('reviews',[App\Http\Controllers\Admin\ReviewsController::class, 'index']);
Route::get('reviews/add',[App\Http\Controllers\Admin\ReviewsController::class, 'create']);
Route::post('reviews/save',[App\Http\Controllers\Admin\ReviewsController::class, 'saveReviews']); 
Route::get('/reviews/edit/{id}',[App\Http\Controllers\Admin\ReviewsController::class, 'edit']);
Route::post('/reviews/editSaveReviews/{id}',[App\Http\Controllers\Admin\ReviewsController::class, 'editSaveReviews']);
Route::get('/reviews/delete/{id}',[App\Http\Controllers\Admin\ReviewsController::class, 'delete']);
Route::get('/reviews/get-reviews',[App\Http\Controllers\Admin\ReviewsController::class, 'getReviewsPagination']);
Route::get('/reviews/del_icon/{id}',[App\Http\Controllers\Admin\ReviewsController::class, 'del_icon']);
 Route::get('/reviews/status/{id}/{val}',[App\Http\Controllers\Admin\ReviewsController::class, 'status']);
 
 
 
 //testimonial
Route::get('testimonial',[App\Http\Controllers\Admin\TestimonialController::class, 'index']);
Route::get('testimonial/add',[App\Http\Controllers\Admin\TestimonialController::class, 'create']);
Route::post('testimonial/save',[App\Http\Controllers\Admin\TestimonialController::class, 'saveTestimonial']); 
Route::get('/testimonial/edit/{id}',[App\Http\Controllers\Admin\TestimonialController::class, 'edit']);
Route::post('/testimonial/editSaveTestimonial/{id}',[App\Http\Controllers\Admin\TestimonialController::class, 'editSaveTestimonial']);
Route::get('/testimonial/delete/{id}',[App\Http\Controllers\Admin\TestimonialController::class, 'delete']);
Route::get('/testimonial/get-testimonial',[App\Http\Controllers\Admin\TestimonialController::class, 'getTestimonialPagination']);
Route::get('/testimonial/del_icon/{id}',[App\Http\Controllers\Admin\TestimonialController::class, 'del_icon']);
Route::get('/testimonial/status/{id}/{val}', [App\Http\Controllers\Admin\TestimonialController::class, 'status']); 
 
 
 
 //placement
Route::get('placement',[App\Http\Controllers\Admin\PlacementController::class, 'index']);
Route::get('placement/add',[App\Http\Controllers\Admin\PlacementController::class, 'create']);
Route::post('placement/save',[App\Http\Controllers\Admin\PlacementController::class, 'savePlacement']); 
Route::get('/placement/edit/{id}',[App\Http\Controllers\Admin\PlacementController::class, 'edit']);
Route::post('/placement/editSavePlacement/{id}',[App\Http\Controllers\Admin\PlacementController::class, 'editSavePlacement']);
Route::get('/placement/delete/{id}',[App\Http\Controllers\Admin\PlacementController::class, 'delete']);
Route::get('/placement/get-placement',[App\Http\Controllers\Admin\PlacementController::class, 'getPlacementPagination']);
Route::get('/placement/del_icon/{id}',[App\Http\Controllers\Admin\PlacementController::class, 'del_icon']);
Route::get('/placement/status/{id}/{val}',[App\Http\Controllers\Admin\PlacementController::class, 'status']); 
 
 
 //Careers
Route::get('careers',[App\Http\Controllers\Admin\CareersController::class, 'index']);
Route::get('careers/add',[App\Http\Controllers\Admin\CareersController::class, 'create']);
Route::post('careers/saveCareers',[App\Http\Controllers\Admin\CareersController::class, 'saveCareers']); 
Route::get('/careers/edit/{id}',[App\Http\Controllers\Admin\CareersController::class, 'edit']);
Route::post('/careers/editSaveCareers/{id}',[App\Http\Controllers\Admin\CareersController::class, 'editSaveCareers']);
Route::get('/careers/delete/{id}',[App\Http\Controllers\Admin\CareersController::class, 'delete']);
Route::get('/careers/get-careers',[App\Http\Controllers\Admin\CareersController::class, 'getCareersPagination']);
Route::get('/careers/del_icon/{id}',[App\Http\Controllers\Admin\CareersController::class, 'del_icon']);
Route::get('/careers/status/{id}/{val}',[App\Http\Controllers\Admin\CareersController::class, 'status']);
 
//Course PDF
Route::get('coursepdf',[App\Http\Controllers\Admin\CoursePDFController::class, 'index']);
Route::get('coursepdf/add',[App\Http\Controllers\Admin\CoursePDFController::class, 'create']);
Route::post('coursepdf/save',[App\Http\Controllers\Admin\CoursePDFController::class, 'saveCoursePDF']); 
Route::get('/coursepdf/edit/{id}',[App\Http\Controllers\Admin\CoursePDFController::class, 'edit']);
Route::post('/coursepdf/editSaveCoursePDF/{id}',[App\Http\Controllers\Admin\CoursePDFController::class, 'editSaveCoursePDF']);
Route::get('/coursepdf/delete/{id}',[App\Http\Controllers\Admin\CoursePDFController::class, 'delete']);
Route::get('/coursepdf/get-coursepdf',[App\Http\Controllers\Admin\CoursePDFController::class, 'getCoursePDFPagination']);
Route::get('/coursepdf/del_icon/{id}', [App\Http\Controllers\Admin\CoursePDFController::class, 'del_icon']);
Route::get('/coursepdf/status/{id}/{val}',[App\Http\Controllers\Admin\CoursePDFController::class, 'status']);
Route::get('/coursepdf/coursepdfstatus/{id}/{val}',[App\Http\Controllers\Admin\CoursePDFController::class, 'coursepdfstatus']);
 
 
//Home Slider
Route::get('homeslider',[App\Http\Controllers\Admin\HomesliderController::class, 'index']);
Route::get('homeslider/add',[App\Http\Controllers\Admin\HomesliderController::class, 'create']);
Route::post('homeslider/save',[App\Http\Controllers\Admin\HomesliderController::class, 'saveHomeslider']); 
Route::get('/homeslider/edit/{id}',[App\Http\Controllers\Admin\HomesliderController::class, 'edit']);
Route::post('/homeslider/editSaveHomeslider/{id}',[App\Http\Controllers\Admin\HomesliderController::class, 'editSaveHomeslider']);
Route::get('/homeslider/delete/{id}',[App\Http\Controllers\Admin\HomesliderController::class, 'delete']);
Route::get('/homeslider/del_icon/{id}',[App\Http\Controllers\Admin\HomesliderController::class, 'del_icon']);
Route::get('/homeslider/get-homeslider',[App\Http\Controllers\Admin\HomesliderController::class, 'getHomesliderPagination']);
Route::get('/homeslider/status/{id}/{val}',[App\Http\Controllers\Admin\HomesliderController::class, 'status']);  

//Mobile Home Banner
Route::get('/mobilebanner/get-mobilebanner',[App\Http\Controllers\Admin\HomesliderController::class, 'getmobilebannerPagination']);
Route::get('/mobilebanner/edit/{id}',[App\Http\Controllers\Admin\HomesliderController::class, 'mobileBannerEdit']);
Route::post('/mobilebanner/editMobilebanner/{id}',[App\Http\Controllers\Admin\HomesliderController::class, 'editMobilebanner']);
Route::get('/mobilebanner/delete/{id}',[App\Http\Controllers\Admin\HomesliderController::class, 'deleteBanner']);
Route::get('/mobilebanner/status/{id}/{val}',[App\Http\Controllers\Admin\HomesliderController::class, 'statusBanner']);
Route::get('/mobilebanner/del_icon/{id}',[App\Http\Controllers\Admin\HomesliderController::class, 'del_icon_banner']);

 
    // Auth (public)
    // Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    // Route::middleware('throttle:admin-auth')->post('/login', [AdminController::class, 'login'])->name('login.submit');
    //Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    //Route::middleware('throttle:admin-forgot')->post('/forgot-password', [AdminController::class, 'forgotPassword'])->name('forgot');
    // Route::middleware('throttle:admin-auth')->post('/reset-password', [AdminController::class, 'resetPassword'])->name('reset');

    // Authenticated area
    Route::middleware('admin.web')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::middleware('throttle:admin-auth')->post('/change-password', [AdminController::class, 'changePassword'])->name('change-password');

        // WhatsApp chats
        Route::post('/whatsapp', [AdminController::class, 'storeWhatsapp'])->name('whatsapp.store');
        Route::post('/whatsapp/{id}', [AdminController::class, 'updateWhatsapp'])->name('whatsapp.update');
        Route::delete('/whatsapp/{id}', [AdminController::class, 'destroyWhatsapp'])->name('whatsapp.destroy');

        // Placement proofs
        Route::post('/proofs', [AdminController::class, 'storeProof'])->name('proofs.store');
        Route::delete('/proofs/{id}', [AdminController::class, 'destroyProof'])->name('proofs.destroy');

        // Video stories
        Route::post('/videos', [AdminController::class, 'storeVideo'])->name('videos.store');
        Route::post('/videos/{id}', [AdminController::class, 'updateVideo'])->name('videos.update');
        Route::delete('/videos/{id}', [AdminController::class, 'destroyVideo'])->name('videos.destroy');

        // Courses
        // Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
        // Route::post('/courses/{id}', [AdminController::class, 'updateCourse'])->name('courses.update');
        // Route::delete('/courses/{id}', [AdminController::class, 'destroyCourse'])->name('courses.destroy');

        // Testimonials / reviews
        Route::post('/reviews', [AdminController::class, 'storeReview'])->name('reviews.store');
        Route::post('/reviews/{id}/visibility', [AdminController::class, 'toggleReview'])->name('reviews.toggle');
        Route::delete('/reviews/{id}', [AdminController::class, 'destroyReview'])->name('reviews.destroy');
    });
});

// Wildcard 404 — must be last. Anything under /api falls through to the
// API exception handler (JSON), preserving existing API behaviour.
Route::fallback(function (\Illuminate\Http\Request $request) {
    if ($request->is('api/*')) {
        abort(410);
    }

    return response()->view('errors.410', [], 410);
});
