<?php
namespace App\Http\Middleware;
use Closure;


class CorsMiddleware
{
    const HEADERS = [
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE',
        'Access-Control-Allow-Headers' => 'authorization, content-type',
        'Access-Control-Allow-Origin' => '*'
    ];

    /**
     * If you want to access the API from another Domain, you need to allow
     * Cross-Origin Resource Sharing (CORS).
     *
     * This means to also send the appropriate headers and respond to the incoming
     * OPTIONS request, which is known as “pre-flight”.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
     * @see routes/web.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        foreach (self::HEADERS as $name => $value) {
            $response->header($name, $value);
        }

        return $response;
    }
}
