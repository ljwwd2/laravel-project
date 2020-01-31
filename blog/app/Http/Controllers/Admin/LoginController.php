<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Org\code\Code;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Model\User;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class LoginController extends Controller
{
    //后台登录页
    public function login(){
//        echo "1";
        return view('admin.login');

    }

    //验证码
    public function code(){
        $code = new Code();
        return $code->make();

    }

    //处理用户登录的方法
    public function doLogin(Request $request)
    {
//        1.接收表单提交的数据
        $input = $request->except('_token');

//        2.进行表单验证
//        $validator = Validator::make('需要验证的表单数据','验证规则','错误提示信息');
        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash',
        ];


        $msg = [
            'username.required'=>'用户名必须输入',
            'username.between'=>'用户名长度必须在4-18位之间',
            'password.required'=>'密码必须输入',
            'password.between'=>'密码长度必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是数字，字母，下划线',

        ];



        $validator = Validator::make($input,$rule,$msg);

        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }






//    3.验证是否有此用户（用户名，密码，验证码）
        if(strtolower($input['code']) != strtolower(session()->get('code')) )  //strtolower是大小写转化
        {
            return redirect('admin/login')->with('errors','验证码错误');
        }






      $user = User::where('user_name',$input['username'])->first();


    if(!$user){
        return redirect('admin/login')->with('errors','用户名为空');
}
//    else{
//        return redirect('admin/login')->with('errors','在失败');
//
//    }

    if($input['password'] != Crypt::decrypt($user->user_pass)){

        return redirect('admin/login')->with('errors','密码错误');//跳转到登录页，并且反馈密码错误
    }





//        4.保存用户信息


        session()->put('user',$user);

//        5.跳转到后台首页

        return redirect('admin/index');
//        redirect()  跳转到的意思
}






    //加密算法


    public function jiami()
    {
//        1.md5加密，生成一个32位的字符串
//        md5加密可以加一个‘盐值’
//        $str = 'salt'. '123456';
//        return md5($str);


//        2.哈希加密
//        $str = '12356';
//
//        $hash = Hash::make('123456');
//
//        if(Hash::check($str,$hash))
//        {
//            return '密码正确';
//        }
//        else
//        {
//            return ' 密码错误';
//        }


//        3.crpyt加密
        $str = '123456';
        $crypt_str = 'eyJpdiI6IlYzUEtCc2NEcTlKTDUwU2UwYTdEYnc9PSIsInZhbHVlIjoiMDZqdU5xbnY1VVl5MDJLd2pUaVNMQT09IiwibWFjIjoiMjUxYjZmYWY2YTY1NDhkNzFlZmI1MTIwZTUzYjc2NWNiM2Y5YTYxMjg0ZDNiYTJlYzIwNDZhNTAwN2FiMjMxMiJ9';
//       $crypt_str = Crypt::encrypt($str);
//        return $crypt_str;

        if(Crypt::decrypt($crypt_str) == $str)//解密后比较
        {
            return '密码正确';
        }



    }

    //后台首页
    public function index(){
        return view('admin.index');

    }

    //后台欢迎页
    public function welcome(){
        return view('admin.welcome');
    }



    //退出登录
    public function logout(){
        //清空session中的用户信息
        session()->flush();//清空操作
        //跳转到登录页面
        return redirect('admin/login');
    }



}



