<?php

namespace Imactool\Gjpzyx;


class Factory
{
    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

    /**
     * @param $name
     * @param array $config
     * @return mixed
     */
    public static function make($name, array $config)
    {
        $namespace = self::studly($name);
        $application = "\\Imactool\\Gjpzyx\\{$namespace}\\{$namespace}";

        if('gjp' == strtolower($name)){
            if (!$config['debug']){
                $config = array_merge($config,self::gjpDefaultConfig());
            }else{
                $config =  array_merge(self::testGjpDefaultConfig(),$config);
            }

        }else if('zyx' == strtolower($name)){
            if (!$config['debug']){
                $config = array_merge($config,self::zyxDefaultConfig());
            }else{
                $config = array(self::testZyxDefaultConfig(),$config);
            }
        }

        return new $application($config);
    }


    /**
     * 管家婆 ERP 正式环境地址参数
     * @return array
     */
    public static function gjpDefaultConfig(){
        return [
            'methodPefix'=>'beefun',
            //线上登录获取授权认证码的地址
            'loginUrl'=>'https://authcentral.wsgjp.com/account/login?',
            //线上接口获取授权认证码的地址
            'oauthUrl'=>'http://apigateway.wsgjp.com.cn/api/login',
            //线上获取token的地址
            'getTokenUrl'=>'http://apigateway.wsgjp.com.cn/api/token',
            //线上接口调用的地址
            'apiUrl'=>'http://apigateway.wsgjp.com.cn/api/',
            //线上管家婆云erp登录地址
            'onlineLoginUrl'=>'http://login.wsgjp.com/'
        ];
    }

    /**
     * 管家婆 ERP 测试环境地址参数
     * @return array
     */
    public static function testGjpDefaultConfig(){
        return [
            'methodPefix'=>'beefun',
            'appKey' 	=> '68943923115886070418838901844741',
            'appSecret' => 'ONxYDyNaCoyTzsp83JoQ3YYuMPHxk3j7',
            'signKey'   => 'lezitiancheng',
            'token'		=> 'WjKsfpVHkPYtKPWkxICIQ7BWLYBvU5jfAL8Wofe3',
            'shopKey'	=> '92a01da5-3e1a-45bb-9277-c29a0586685e',
            //公司名称
            'CompanyName'=>'TestMall',
            //用户名
            'UserId'	=> 'test9',
            //密码
            'Password'	=> 'grasp@909',
            'refreshToken' => 'BwfoCBHxPiR8BCY4OtMTDeoDTosLs8dgRxHQg5fd',
            //线上登录获取授权认证码的地址
            'loginUrl'=>'http://ca.mygjp.com:666/account/login?',
            //线上接口调用的地址
            'apiUrl'=>'http://ca.mygjp.com:8002/api/',
            //线上管家婆云erp登录地址
            'onlineLoginUrl'=>'http://login.wsgjp.com/'
        ];
    }


    /**
     * 章鱼侠 ERP 正式环境地址参数
     * @return array
     */
    public static function zyxDefaultConfig(){
        return [
            'methodPefix'=>'zyx',
            //线上登录获取授权认证码的地址
            'loginUrl'=>'https://authcentral.wsgjp.com/account/login?',
            //线上接口获取授权认证码的地址
            'oauthUrl'=>'http://api.zhangyuxia.com.cn/api/login',
            //线上获取token的地址
            'getTokenUrl'=>'http://api.zhangyuxia.com.cn/api/token',
            //线上接口调用的地址
            'apiUrl'=>'http://api.zhangyuxia.com.cn/api/',
            //线上章鱼侠云erp登录地址
            'onlineLoginUrl'=>'http://login.zhangyuxia.com.cn'
        ];
    }


    /**
     * 章鱼侠 ERP 测试
     */
    public static function testZyxDefaultConfig(){
        return [
            'methodPefix'=>'zyx',
            'appKey' 	=> '68943923115886070418838901844741',
            'appSecret' => 'ONxYDyNaCoyTzsp83JoQ3YYuMPHxk3j7',
            'signKey'   => 'lezitiancheng',
            'token'		=> '0I7dHCByoGxlxAHU8I50MzpPVbN0Nl56goE2YGdP',
            'shopKey'	=> 'e7c5289b-07ee-492f-b84f-97ee9659c8b7',
            //公司名称
            'CompanyName'=>'TestMall',
            //用户名
            'UserId'	=> 'test',
            //密码
            'Password'	=> 'grasp@101',
            'refreshToken' => '548BGezYm6wfTCzeazuk0d0UeR39AUMYJAJv3pGH',
            //线上登录获取授权认证码的地址
            'loginUrl'=>'http://ca.mygjp.com:666/account/login?',
            'apiUrl'=>'http://ca.mygjp.com:8002/api/',
            //线上章鱼侠云erp登录地址
            'onlineLoginUrl'=>'http://login.zhangyuxia.com.cn'
        ];
    }



    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name,...$arguments);
    }

    /**
     * Convert a value to studly caps case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function studly($value)
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }
}