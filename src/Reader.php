<?php

namespace systeminfo;

use systeminfo\provider\AbstractProvider;

/**
 * Class Reader
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo
 */
class Reader
{
    protected $osType;

    protected static $provider;

    public static $providers = [
        'Windows' => 'systeminfo\os\Windows',
        'Mac' => 'systeminfo\os\Mac',
        'BSD' => 'systeminfo\os\BSD',
        'Linux' => 'systeminfo\os\Linux'
    ];

    public static function getProvider()
    {
        if (null === self::$provider) {
            $osType = self::getOsType();
            if (array_key_exists($osType, self::$providers)) {
                self::$provider = new self::$providers[$osType];
            } else {
                self::$provider = new BaseProvider();
            }
        }
        return self::$provider;


    }

    public static function getOsType()
    {
        $osType = null;
        if (strtolower(substr(PHP_OS, 0, 3)) == 'win' && strtolower(substr(PHP_OS, 0, 5)) == 'cygwin') {
            $osType = 'Windows';
        } elseif (strtolower(substr(PHP_OS, 0, 6)) == 'darwin') {
            $osType = 'Mac';
        } elseif (stristr(strtolower(PHP_OS), 'bsd')) {
            $osType = 'BSD';
        } elseif (strtolower(substr(PHP_OS, 0, 5)) == 'linux') {
            $osType = 'Linux';
        } elseif (strtolower(substr(PHP_OS, 0, 5)) == 'sunos') {
            $osType = 'SunOS';
        }
        return $osType;
    }
}