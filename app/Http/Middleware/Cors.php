<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Illuminate\Http\Response  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        $corsConfig = Config::get('cors');
        $allowedOrigins = $corsConfig['allowed_origins'];

        if (in_array($request->server('HTTP_ORIGIN'), $allowedOrigins)) {
            $headers = [
                'Access-Control-Allow-Origin' => $request->server('HTTP_ORIGIN'),
                'Access-Control-Allow-Methods' => implode(',', $corsConfig['allowed_methods']),
                'Access-Control-Allow-Headers' => implode(',', $corsConfig['allowed_headers']),
            ];

            if ($corsConfig['supports_credentials']) {
                $headers['Access-Control-Allow-Credentials'] = 'true';
            }

            if (isset($corsConfig['exposed_headers'])) {
                $headers['Access-Control-Expose-Headers'] = implode(',', $corsConfig['exposed_headers']);
            }

            if (isset($corsConfig['max_age'])) {
                $headers['Access-Control-Max-Age'] = $corsConfig['max_age'];
            }

            // Add any additional CORS headers as needed based on your configuration

            (new Response())->headers->set($headers);
        }

        return $next($request);
    }
}