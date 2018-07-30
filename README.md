# laravel-cors
一个laravel的cors跨域中间件

# 安装
composer require gao922699/laravel-cros

# 使用
php artisan make:middleware Cros
文件内容如下：
<pre><code>
namespace App\Http\Middleware;
use gao922699\laravel\cors\CorsMiddleware;
class Cors extends CorsMiddleware
{
    public $allowOrigins = [
    'http://localhost/',
    'http://www.testdomain.com/',
    ];
    public $maxAge = 100;
    //还有allowHeaders,allowMethods可以配置
}
</code></pre>
配置kernel.php，在$routeMiddleware中加入:
<pre><code>
'cors' => \App\Http\Middleware\Cors::class,
</code></pre>
路由或者controller的__construct中加入：
<pre><code>
$this->middleware('cors');
</code></pre>
