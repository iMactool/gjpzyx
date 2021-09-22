## `imactool/gjpzyx` 管家婆ERP 管家婆章鱼侠API.

由于项目里需要用到管家婆或者章鱼侠作为第三方仓库支持，但是 Google、GitHub 一番发现一条都木有。 所以就自己造了一个。
应该是目前第一个比较完善的支持 管家婆 ERP、章鱼侠 ERP 的第三方扩展包了。 使用本扩展之前，请务必确认你已经在 [管家婆-章鱼侠](http://help.mygjp.com/pages/viewpage.action?pageId=48660739) 获取了接口调用权限！

### 注意📢
> 管家婆和章鱼侠接口调用方式基本一致，他们两的区别在于申请的 `appkey` 不一样

### install

```
composer require imactool/gjpzyx
```

# 管家婆
```php
 <?php

require './vendor/autoload.php';

use Imactool\Gjpzyx\Factory;

/**
 * 管家婆接口测试
 */

$config = [
    'debug'=>false, //是否在测试环境下测试,线上必须设置 false
    'appKey' 	=> '',
    'appSecret' => '',
    'signKey'   => '',
    'shopKey'	=> '',
    //线上登录获取授权认证码的地址
    'loginUrl'=>'',
    //线上接口调用的地址
    'apiUrl'=>'http://ca.mygjp.com:8002/api/', //注意，需要 / 结尾
    //线上章鱼侠云erp登录地址
    'onlineLoginUrl'=>''
];

$app = Factory::Gjp($config);

#假设我们的回调地址是：http://example.test/callback.php

//步骤1 获取授权认证码
$redirect_url = 'http://example.test/callback.php';
$redirectUrl = $app->getAuthUrl($redirect_url);
echo "步骤1 获取授权认证码";
var_dump($redirectUrl);

//步骤2 利用授权认证码获取token信息
#获取回到结果的 auth_code
$autoCode = $_GET['auth_code'];

$otken = $app->getTokenInfo($autoCode);
echo "步骤2 利用授权认证码获取token信息  ";
var_dump($otken);
 

# 到这里就可以正常访问API接口
//商品上载，将商城的商品推送到章鱼侠云erp中。
$params = [
    'products'=>[
        'productname'=> '商品名称测试',
        'numid'=>'1234567890123',
        'outerid'=>'20210909',
        'picurl' => 'http://img.yzcdn.cn/upload_files/2016/12/07/FrxeXiN6bKJs0RYXo6hueqca6QHz.jpg',
        'price' => 128.23,
        'stockstatus'=>1,
        'skus' =>[
            'numid'=>34567890123,
            'skuid'=>123123,
            'outerskuid'=>'SP_A_红色_24码',
            'properties'=>'1:11;2:22',
            'propertiesname'=>'红色_24码',
            'qty'=> 100,
            'price'=>139,
            'barcode'=>'100000001231'
        ]
    ]
];
$result = $app->pushProduct($params);
var_export($result);

```

 
