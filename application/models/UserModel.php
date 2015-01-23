<?php

class UserModel {

	/**
     * Session token renewer
     */
	public function checkToken($token)
    {
        if(!empty($token)) {
            $token = base64_decode($token . '=');
            $token_arr = explode('::', $token, 3); // TODO: validate username and timestamp
            if($token_arr > time()) {
                $raw_token =  $token_arr[0] . '::' . $token_arr[1];
                $new_token = hash_hmac('SHA512', $raw_token . SESSION_TOKEN_SALT, SESSION_TOKEN_KEY);
                if($new_token === $token_arr[2])
                {
                    return true;
                }
            } else {
                return $this->renew($token_array[0], $token_array[2]);
            }
        }
        return false;
    }

    /**
     *
     */
    private function renew($user, $token = null)
    {
        if(!empty($token)) {
            $db = Database::getInstance();
            $query = $db->prepare('SELECT session_token FROM users WHERE username = :user LIMIT 1');
            $query->execute(array(':user' => $user));
            $res = $query->fetch();
            if($token === $res->session_token) {
                $raw_token =  $user . '::' . (time() + 1800); // set token for half an hour from now
                $token_hash = hash_hmac('SHA512', $raw_token . SESSION_TOKEN_SALT, SESSION_TOKEN_KEY); // hash with key
                return substr(base64_encode($raw_token . "::" . $token_hash), 0, -1); // encode and remove last character
            }
            /* TODO: move to login
            $raw_token =  'Martin Turjak' . '::' . (time() + 1800); // set token for half an hour from now
            $token_hash = hash_hmac('SHA512', $raw_token . SESSION_TOKEN_SALT, SESSION_TOKEN_KEY); // hash with key
            echo substr(base64_encode($raw_token . "::" . $token_hash), 0, -1); // encode and remove last character
            die();
            */
        }
        return false;
    }
}