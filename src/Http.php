<?php
/**
 * ======================================================
 * Author: cc
 * Desc: 封装HTTP请求
 *  ======================================================
 */
namespace Imactool\Gjpzyx;

use GuzzleHttp\Client;
use Imactool\Gjpzyx\Exceptions\HttpException;
use Imactool\Gjpzyx\Exceptions\InvalidArgumentException;

class Http
{

    protected $guzzleOptions;
    protected $baseUri ;

    /**
     * get a Guzzle http client
     * @return Client
     */
    public function getHttpClient()
    {
        if (!isset($this->guzzleOptions['base_uri'])){
            $this->guzzleOptions['base_uri'] = $this->baseUri;
        }
        return new Client($this->guzzleOptions);
    }

    /**
     * 用户可以自定义 guzzle 实例的参数，比如超时时间等
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    public function setApiUrl($api){
        $this->baseUri = trim($api,'/').'/';
        return $this;
    }

    public function httpPost( array $postData,$uri=''){
        try {
            $httpClient = $this->getHttpClient()->request('POST',$uri,['form_params'=>$postData]);
            $response = $httpClient->getBody()->getContents();
            return \json_decode($response,true);
        }catch (\Exception $e){
            throw new HttpException($e->getMessage(),$e->getCode(),$e);
        }
    }

}