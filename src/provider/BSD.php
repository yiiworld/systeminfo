<?php

namespace systeminfo\provider;

/**
 * Class BSD
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo\os
 */
class BSD extends AbstractBSD
{

    public function getOsRelease()
    {
        // TODO: Implement getOsRelease() method.
    }

    public function getOsType()
    {
        return 'BSD';
    }

    /**
     * @return bool|int
     */
    public function getFreeSwap()
    {
        if (self::getIsWindows()) {
            //todo
        } elseif (self::getIsBSD()) {
            $meminfo = self::getMemoryInfo();
            preg_match_all('/=(.*?)M/', $meminfo['vm.swapusage'], $res);
            return isset($res[1][2]) ? intval($res[1][2]) * 1024 * 1024 : null;
        } else {
            $meminfo = self::getMemoryInfo();
            return isset($meminfo['SwapFree']) ? intval($meminfo['SwapFree']) * 1024 : null;
        }
        return null;
    }
}
