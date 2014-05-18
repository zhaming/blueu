<?php

class McryptComponent {

    const cipher = MCRYPT_DES;
    const modes = MCRYPT_MODE_ECB;
    const key_length = 8;
    const key = 'wanthings';

    /**
     * 加密
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    public static function encryption($str) {
        $key = self::key;
        if (strlen($key) > self::key_length) {
            $key = substr($key, 0, self::key_length);
        }
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::cipher, self::modes), MCRYPT_RAND);
        return base64_encode(mcrypt_encrypt(self::cipher, $key, trim($str), self::modes, $iv));
    }

    /**
     * 解密
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    public static function decryption($str) {
        //$key = Yii::app()->params['pdKey'];
        $key = self::key;
        if (strlen($key) > self::key_length) {
            $key = substr($key, 0, self::key_length);
        }
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::cipher, self::modes), MCRYPT_RAND);
        return trim(mcrypt_decrypt(self::cipher, $key, base64_decode(trim($str)), self::modes, $iv));
    }

}