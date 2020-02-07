<?php

namespace App\Application\Helper;

class BcryptHelper
{
    /**
     * @param $password
     * @return bool|string
     */
    public static function generate($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 11]);
    }
}
