<?php

namespace gao922699\laravel\cors;

use Closure;
use Exception;

class CorsMiddleware
{
    protected $config = [
        'allowOrigins' => [],
        'allowHeaders' => ['Content-Type'],
        'allowMethods' => [
            'POST',
            'GET'
        ],
        'allowCredentials' => false,
        'maxAge' => 68400,
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next, ...$config)
    {
        $this->config = $config;
        $response = $next($request);
        if (empty($this->config['allowOrigins'])) {
            throw new Exception('Allow origins is not set');
        }
        $origin = $request->header('Origin');
        if ($origin){
            if (in_array($origin, $this->allowOrigins)) {
                if ($request->isMethod('OPTIONS')) {
                    $response->header('Access-Control-Allow-Origin', $origin);
                    if ($this->allowCredentials) $response->header('Access-Control-Allow-Credentials', 'true');
                    $response->header('Access-Control-Allow-Methods', implode(',', $this->config['allowMethods']));
                    $response->header('Access-Control-Allow-Headers', implode(',', $this->config['allowHeaders']));
                    $response->header('Access-Control-Max-Age', $this->config['maxAge']);
                } else {
                    $response->header('Access-Control-Allow-Origin', $origin);
                    if ($this->allowCredentials) $response->header('Access-Control-Allow-Credentials', 'true');
                }
            }
        }
        return $response;
    }
}
