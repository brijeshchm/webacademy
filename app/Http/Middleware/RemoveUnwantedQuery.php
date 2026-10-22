<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveUnwantedQuery
{
    public function handle(Request $request, Closure $next)
    {
 
        
            // if ($request->has('v')) {
                
            //     return redirect()->to($request->url(), 301);
            // }

        if ($request->has('v')) {
        abort(410);   // 410 Gone
        }
  
        return $next($request);
    }
}