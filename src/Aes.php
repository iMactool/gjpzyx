<?php
/**
 * ======================================================
 * Author: cc
 * Desc: AES
 *  ======================================================
 */

namespace Imactool\Gjpzyx;

class Aes
{
    protected $iv = '000000000000000000'; //密钥偏移量IV，可自定义
    protected $encryptKey = '7e4e615af165fe63cbf40e52abbc79e8';//AESkey，可自定义

    /**
     * 设置 密钥偏移量IV
     * @param $iv
     */
    public function setAesIv($iv){
        $this->iv = $iv;
    }

    /**
     * 设置 AESkey
     * @param $key
     */
    public function setAesKey($key){
        $this->encryptKey = $key;
    }

    //加密
    public function encrypt($encryptStr){
        error_reporting(E_ALL & ~E_DEPRECATED); //兼容管家婆使用过时 ASE 加密方式
        $localIV = $this->iv;
        $encryptKey = $this->encryptKey;
        $encryptStr = trim($encryptStr);
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, $localIV);
        mcrypt_generic_init($module, $encryptKey, $localIV);
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $pad = $block - (strlen($encryptStr) % $block);
        $encryptStr .= str_repeat(chr($pad), $pad);
        $encrypted = mcrypt_generic($module, $encryptStr);
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);
        return base64_encode($encrypted);
    }

    //解密
    public function decrypt($encryptStr) {
        error_reporting(E_ALL & ~E_DEPRECATED); //兼容管家婆使用过时 ASE 加密方式
        $localIV = $this->iv;
        $encryptKey = $this->encryptKey;
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, $localIV);
        mcrypt_generic_init($module, $encryptKey, $localIV);
        $encryptedData = base64_decode($encryptStr);
        $encryptedData = mdecrypt_generic($module, $encryptedData);
        return $encryptedData;
    }

}