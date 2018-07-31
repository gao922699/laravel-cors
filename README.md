# laravel-cors
一个laravel的cors跨域中间件

# 安装
composer require gao922699/laravel-cros

# 使用
在app/Http/Middleware文件夹中添加文件内容如下：
<pre><code>
namespace App\Http\Middleware;
use gao922699\laravel\cors\CorsMiddleware;
class Cors extends CorsMiddleware
{
    public $allowOrigins = [
    'http://localhost/',
    'http://www.testdomain.com/',
    ];
    public $maxAge = 3600;
    //还有allowHeaders,allowMethods可以配置
}
</code></pre>
配置kernel.php，在$routeMiddleware中加入:
<pre><code>
'cors' => \App\Http\Middleware\Cors::class,
</code></pre>
路由或者controller的__construct中加入：
<pre><code>
//路由文件中
Route::middleware('cors);
//Controller中
$this->middleware('cors');
</code></pre>

# 注意事项
laravel的路由模式规定了访问的方式，如果是复杂请求，正式请求前会有一个OPTIONS方式的请求，请在路由文件中单独指定；

如果你想过滤所有OPTIONS请求统一处理，可以在路由中进行如下处理：
<pre><code>
Route::middleware('cors')->options('/{all}', function (Request $request) {
})->where(['all' => '([a-zA-Z0-9-_]|/)+']);
</code></pre>

