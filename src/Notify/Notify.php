<?php
/**
 * ======================================================
 * Author: cc
 * Created by PhpStorm.
 * Copyright (c)  cc Inc. All rights reserved.
 * Desc: 消息推送，这个功能目前看起来比较....
 *  ======================================================
 */
namespace Imactool\Gjpzyx\Notify;

use Imactool\Gjpzyx\Base\Base;

class Notify extends Base
{
    public $request; //GET 参数
    public $bodyCoent; //请求报文

    public function __construct(array $config)
    {
        $this->request = $_GET;
        $this->bodyCoent =  file_get_contents("php://input");
        parent::__construct($config);

        if (!$this->vaildRequest()){
            return ['code'=>100,'msg'=>'校验失败'];
        }
    }

    public function vaildRequest(){
        $getSign = $this->request['sign'];
//        unset($this->request['sign']);
        $signParams['method']   = $this->request['method'];
        $signParams['id']       = $this->request['id'];
        $signParams['timestamp']= $this->request['timestamp'];
        $signParams['appkey']   = $this->request['appkey'];
        $signParams['shopkey']  = $this->request['shopkey'];
        $signParams['body']     = $this->bodyCoent;

        $checkSign = $this->getSign($signParams);

        if ($checkSign === $getSign){
            return  true;
        }
        return false;
    }

    //获取 URL url参数
    public function getRequest(){
        return $this->request;
    }

    //获取请求报文
    public function getBodyContent(){
        return \json_decode($this->bodyCoent,true);
    }

}