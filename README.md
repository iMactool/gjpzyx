<h1 align="center"> gjpzyx </h1>

<p align="center"> 管家婆ERP 管家婆章鱼侠API.</p>
由于项目里需要用到管家婆或者章鱼侠作为第三方仓库支持，但是 Google、GitHub 一番发现一条都木有。
所以就自己造了一个。

应该是目前第一个比较完善的支持 管家婆 ERP、章鱼侠 ERP 的第三方扩展包了。
使用本扩展之前，请务必确认你已经在 [管家婆-章鱼侠](http://help.mygjp.com/pages/viewpage.action?pageId=48660739) 获取了接口调用权限！


## Installing

```shell
$ composer require imactool/gjpzyx:dev-main -vvv
```

具体索要参数和返回参数请按产品文档查阅

管家婆ERP文档：[点我查看](http://help.mygjp.com/pages/viewpage.action?pageId=48660745)

章鱼侠ERP文档：[点我查看](http://help.zhangyuxia.com.cn/pages/viewpage.action?pageId=48660745)

## Usage

### 管家婆

- 初始化

```php

require './vendor/autoload.php';
use Imactool\Gjpzyx\Factory;

$config = [
    'debug'=>false, //是否在测试环境下测试,线上必须设置 false
    'appKey' 	=> '',
    'appSecret' => '',
    'signKey'   => '',
    'token'		=> '',
    'shopKey'	=> '',
    //公司名称
    'CompanyName'=>'',
    //用户名
    'UserId'	=> '',
    //密码
    'Password'	=> '',
    'refreshToken' => '',
    //线上登录获取授权认证码的地址
    'loginUrl'=>'',
    //线上接口调用的地址
    'apiUrl'=>'http://ca.mygjp.com:8002/api/', //注意，需要 / 结尾
    //线上章鱼侠云erp登录地址
    'onlineLoginUrl'=>''
];
 
$app = Factory::Gjp($config);
如果是章鱼侠ERP
$app = Factory::Zyx($config);
其他调用方式都是一模一样
```
   
- querySaleQty() 批量获取ERP商品基本资料的库存信息 

```php

$parsm = [
    'numid'=>'324324324324',
    'ktypeids'=>[154274961429839227,154274961429839299],
    'iscalcsaleqty'=>true,
    'pagesize'=>100,
    'pageno' => 1
];
$productquery = $app->querySaleQty($parsm);


```

- pushStoreInfo() 上载门店信息

```php
$storeArr = [
	'Id' =>1,
	'storecode'=>'sdf',
	'storename'=>'测试',
	'storetype'=>3,
	'image'=>'',
	'storephonenumber'=>'18355522221',
	'storeaddress'=>'门店地址'
];

$store = $app->pushStoreInfo($storeArr);

```

- pushOrderRefund()  售后单添加

```php
$refundOrder = [
	'refundnumber' =>'1154654656151',
	'tradeid'=>'123123151561561',
	'refundcreatetime'=>'2017-07-11 11:11:11',
	'refundtype'=>0,
	'refundstatus'=>1,
	'oid'=>'2345446546',
	'qty'=>1,
    'refundfee'=>100,
    //...其他参数
];

$result = $app->pushOrderRefund($refundOrder);

```
    
其他具体可以查看代码

TODO

- 目前参数没有做过滤处理
- 文档完善
- 代码完善
- tests


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/imactool/gjpzyx/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/imactool/gjpzyx/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT