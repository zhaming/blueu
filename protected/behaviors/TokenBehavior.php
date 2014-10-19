<?php

/*
 * 用户认证token
 */

/**
 * 2014-5-19 10:47:04 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * TokenBehavior.php hugb
 *
 */
class TokenBehavior extends BaseBehavior {

    const DEFAULT_EXPIRE_DELTA = 3600;

    public function token() {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-'
                . substr($chars, 8, 4) . '-'
                . substr($chars, 12, 4) . '-'
                . substr($chars, 16, 4) . '-'
                . substr($chars, 20, 12);
        return $uuid;
    }

    public function save($tokenData) {
        $token = new Token();
        $token->id = $this->token();
        $tokenData['token_id'] = $token->id;
        $token->data = CJSON::encode($tokenData);
        $token->expires_at = time() + self::DEFAULT_EXPIRE_DELTA;
        if ($token->save()) {
            return $token->id;
        }
        return false;
    }

    public function get($tokenId) {
        return Token::model()->findByPk($tokenId);
    }

}
