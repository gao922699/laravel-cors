<?php

namespace gao922699\laravel\cors;

use Closure;
use Exception;

class CorsMiddleware
{
    /**
     * @var array Access-Control-Allow-Origin 配置，支持多个
     */
    public $allowOrigins = [];

    /**
     * @var array Access-Control-Allow-Headers 配置
     */
    public $allowHeaders = [
        'Content-Type',
    ];

    /**
     * @var array Access-Control-Allow-Methods配置
     */
    public $allowMethods = [
        'POST',
        'GET',
    ];

    /**
     * @var bool Access-Control-Allow-Credentials配置，是否开启cookie跨域。为true时前端发送请求也要带上withCredentials属性
     */
    public $allowCredentials = false;

    /**
     * @var int 复杂请求的OPTIONS请求缓存有效期，单位秒
     */
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
