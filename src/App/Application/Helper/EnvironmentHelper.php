<?php

namespace App\Application\Helper;

class EnvironmentHelper
{
    /**
     * @return bool
     */
    public static function isProduction(): bool
    {
        $env = getenv('APPLICATION_ENV');
        return $env === false || $env === 'prod';
    }

    /**
     * @return bool
     */
    public static function isStage(): bool
    {
        return getenv('APPLICATION_ENV') === 'stage';
    }

    /**
     * @return bool
     */
    public static function isDev(): bool
    {
        return getenv('APPLICATION_ENV') === 'dev';
    }
}

