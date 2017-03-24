<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
     public function handle($request, Closure $next)
    {
    	$http_referer=$_SERVER['HTTP_REFERER']; //获取上次地址

    	$member=$request->session()->get('member','');
    	if ($member=='') {
    		return redirect('/login?return_url='.urldecode($http_referer));
    	}
        
        
        

        return $next($request);
    }
}
