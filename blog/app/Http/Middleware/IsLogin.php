<?php

namespace App\Http\Middleware;

use Closure;

class IsLogin
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

        if(session()->get('user')){
            return $next($request);
        }else{//                                 提示信息
            return redirect('admin/login')->with('errors','请注意一下素质，按照正常方式登录。');
        }

        //中间件
//        1，先声明一个中间件     （使用代码  php artisan make:middleware IsLogin
//        2，写中间件的业务逻辑  （在声明的 Middleware/IsLogin.php中写
//        3，注册中间件  （Http/在Kernel.php中
//        4，使用   （在路由里面有使用

    }
}
