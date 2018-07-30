<?php

namespace gao922699\laravel\cors;

use Closure;
use Exception;

class CorsMiddleware
{
    public $allowOrigins = [];

    public $allowHeaders = [
        'Content-Type',
    ];

    public $allowMethods = [
        'POST',
        'GET',
    ];

    public $allowCredentials = false;

    public $maxAge = 86400;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (empty($this->allowOrigins)) {
            throw new Exception('Allow origins is not set');
        }
        $origin = $request->header('Origin');
        if (in_array($origin, $this->allowOrigins)) {
            if ($request->isMethod('OPTIONS')) {
                $response->header('Access-Control-Allow-Origin', $origin);
                if ($this->allowCredentials) $response->header('Access-Control-Allow-Credentials', 'true');
                $response->header('Access-Control-Allow-Methods', implode(',', $this->allowMethods));
                $response->header('Access-Control-Allow-Headers', implode(',', $this->allowHeaders));
                $response->header('Access-Control-Max-Age', $this->maxAge);
            } else {
                $response->header('Access-Control-Allow-Origin', $origin);
                if ($this->allowCredentials) $response->header('Access-Control-Allow-Credentials', 'true');
            }
        }
        return $response;
    }
}
