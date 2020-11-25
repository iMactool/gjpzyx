<?php
/**
 * ======================================================
 * Author: cc
 * Desc:管家婆章鱼侠API
 *  ======================================================
 */
namespace Imactool\Gjpzyx;


use Imactool\Gjpzyx\Aes;
//use Imactool\Gjpzyx\Http;

class Gjpzyx
{

    protected $config;

    /**
     * 初始化配置项
     * Gjpzyx constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        date_default_timezone_set('PRC');
        $this->config = $config;
    }

   public  function getSign(array $params){
       ksort($params);
       $sign_arr = [];
       foreach($params as $k=>$v){
           $sign_arr[] = $k.$v;
       }
       $sign_str = implode('',$sign_arr).$this->config['signKey'];
       $sign_str = $this->characet($sign_str);
       $sign_str = strtoupper(md5($sign_str));
       return $sign_str;

    }

    public function characet($data){
        if( !empty($data) ){
            $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
            if( $fileType != 'UTF-8'){
                $data = mb_convert_encoding($data ,'utf-8' , $fileType);
            }
        }
        return $data;
    }

    /**
     * Aes
     * @return \Imactool\Gjpzyx\Aes
     */
    public function aesFace(){
        static  $aes = null;
        if (is_null($aes)){
            $aes = new Aes();
            $iv = mb_substr($this->config['appSecret'],5,16); //获取偏移量
            $aes->setAesIv($iv);
            $encryptKey = $this->config['appSecret']; //转换密码
            $aes->setAesKey($encryptKey);
        }
        return $aes;
    }


    /**
     * 处理加密数据
     * @param $params
     * @return array
     */
    public function makeSecretData($params){

        $p = $this->aesFace()->encrypt(trim(\json_encode($params,JSON_UNESCAPED_SLASHES)));
        $paramsJson = [
            'appkey'=>trim($this->config['appKey']),
            'p'=>$p,
            'signkey'=>trim($this->config['signKey'])
        ];
        $sign = $this->sha256(json_encode($paramsJson,JSON_UNESCAPED_SLASHES));

        return ['p'=>$p,'sign'=>$sign];
    }

    function sha256($data, $rawOutput=false)
    {
        if(!is_scalar($data)){
            return false;
        }
        $data = (string)$data;
        $rawOutput = !!$rawOutput;
        return hash('sha256', $data, $rawOutput);
    }

}