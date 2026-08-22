<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
class RouteServiceProvider extends ServiceProvider
{
    /*
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
  //  public const HOME = '/admin/dashboard';
    public const HOME = '/admin/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
		
        $this->configureRateLimiting();
		$this->removeIndexPhpFromUrl();  
  
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }


   /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    { 
      
		    
    }
	
	
    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
	
	  
	protected function removeIndexPhpFromUrl()
    {        
	 
    
       if (Str::contains(request()->getRequestUri(), '/index.php')  ) {
     
 
            $url = str_replace('/index.php', '', request()->getRequestUri());
            
            $url = str_replace('public/', '', $url);
 
            if (strlen($url) > 0) {
                
                header("Location: $url", true, 301);
              
                exit;
            }
        }
        
        
        if (Str::contains(request()->getRequestUri(), '/public/index.php')  ) {
            $url = str_replace('public/index.php', '', request()->getRequestUri());
          
            if (strlen($url) > 0) {
                header("Location: $url", true, 301);
                exit;
            }
        }
      
        if (Str::contains(request()->getRequestUri(), '/public/')  ) {
            $url = str_replace('public/', '', request()->getRequestUri());
          
            if (strlen($url) > 0) {
                header("Location: $url", true, 301);
                exit;
            }
        }
        
        if (Str::contains(request()->getRequestUri(), '/public')  ) {
            $url = str_replace('public', '', request()->getRequestUri());
          
            if (strlen($url) > 0) {
                header("Location: $url", true, 301);
                exit;
            }
        }

         if (Str::contains(request()->getRequestUri(), '')  ) {
            $url = str_replace('', '', request()->getRequestUri());
          
            if (strlen($url) > 0) {
                header("Location: $url", true, 301);
                exit;
            }
        }
        
    }
	
}
