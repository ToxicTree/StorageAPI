<?php

namespace App\Http\Middleware;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $headers = [
            //'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE, HEAD',
            //'Access-Control-Allow-Credentials' => 'true',
            //'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
            //'Access-Control-Allow-Headers'     => $request->header('Access-Control-Request-Headers')
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response('')->withHeaders($headers);
        }

        $response = $next($request);

        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        return $response;
    }
}
