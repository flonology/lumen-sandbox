<?php
namespace App\Http\Middleware;
use Closure;

class CatchAllOptionsRequestsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if ($request->isMethod('OPTIONS')) {
        app('router')->options($request->path(), function() {
          return response('Welcome', 200);
        });
      }

      return $next($request);
    }
}
