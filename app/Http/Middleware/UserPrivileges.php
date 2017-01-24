<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use View;
use Config;
class UserPrivileges{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $uri = $request->path();
        $method = $request->method();
        // dd($request->headers->all());
        
        $exceptions = ['/', 'Signin', 'unauthorized', 'logs', 'test','test1'];

        if(in_array($uri, $exceptions)){
            return $next($request);
        }

        // if(!session()->has('role_id')){
        //     return $next($request);
        // }
       /* $access = DB::table('privileges')
        ->where('uri', $uri)
        ->where('method', $method)
        ->where('role_id', session('role_id'))
        ->value('access');
        
        if($access === null || $access === 1){
            return $next($request);
        } elseif($access == null){
            if($request->ajax()) {
                if(explode(",", $request->headers->get('accept'))[0] == "text/html"){
                    $alert = '<script>Utils.msgError("You are no Authorized");</script>';
                    return response(file_get_contents(Config::get('view.paths')[0].DIRECTORY_SEPARATOR.'dasboard.blade.php').PHP_EOL.$alert);
                } else{
                    return response()->json(['access'=>false, 'msg'=>'You are not Authorized']);
                }
            } else {
                return redirect()->guest('unauthorized');
            }
        }*/
    
        return $next($request);
    }
}
