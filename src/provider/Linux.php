<?php

namespace systeminfo\provider;

/**
 * Class Linux
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo\os
 */
class Linux extends Provider
{
    public $osType = 'Linux';

    public function getUptime()
    {
        $uptime = @file_get_contents('/proc/uptime');
        if ($uptime) {
            $uptime = explode('.', $uptime);
            return isset($uptime[0]) ? $uptime[0] : null;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getOsRelease()
    {
        if (self::getIsWindows()) {
            return null;
        } elseif (self::getIsBSD()) {
            return shell_exec('sw_vers -productVersion');
        } else {
            return shell_exec('/usr/bin/lsb_release -ds');
        }
    }

    /**
     * @return string
     */
    public function getKernelVersion()
    {
        if (self::getIsWindows()) {
            return null;
        } elseif (self::getIsBSD()) {
            return shell_exec('uname -v');
        } else {
            return shell_exec('/bin/uname -r');
        }
    }

    /**
     */
    public function getTotalSwap()
    {
        if (self::getIsWindows()) {
            //todo
        } elseif (self::getIsBSD()) {
            $meminfo = self::getMemoryInfo();
            preg_match_all('/=(.*?)M/', $meminfo['vm.swapusage'], $res);
            return isset($res[1][0]) ? intval($res[1][0]) * 1024 * 1024 : null;
        } else {
            $meminfo = self::getMemoryInfo();
            return isset($meminfo['SwapTotal']) ? intval($meminfo['SwapTotal']) * 1024 : null;
        }
        return null;
    }

    /**
     * @return bool|int
     */
    public function getTotalMem()
    {
        if (self::getIsWindows()) {
            //todo
        } elseif (self::getIsBSD()) {
            $meminfo = self::getMemoryInfo();
            return isset($meminfo['net.local.dgram.recvspace'])
                ? intval($meminfo['net.local.dgram.recvspace']) * 1024 * 1024
                : null;
        } else {
            $meminfo = self::getMemoryInfo();
            return isset($meminfo['MemTotal']) ? intval($meminfo['MemTotal']) * 1024 : null;
        }
        return null;
    }

    /**
     * @return array|null
     */
    public function getMemoryInfo()
    {
        if (self::getIsWindows()) {
            return null; // todo: Windows
        } elseif (self::getIsBSD()) {
            return self::getBSDInfo();
        } else {
            $data = @explode("\n", file_get_contents("/proc/meminfo"));
            if ($data) {
                $meminfo = array();
                foreach ($data as $line) {
                    $line = explode(":", $line);
                    if (isset($line[0]) && isset($line[1])) {
                        $meminfo[$line[0]] = trim($line[1]);
                    }
                }
                return $meminfo;
            }
        }

        return null;
    }

    /**
     * @return bool|int
     */
    public function getFreeMem()
    {
        if (self::getIsWindows()) {
            //todo
        } elseif (self::getIsBSD()) {
            //todo
        } else {
            $meminfo = self::getMemoryInfo();
            return isset($meminfo['MemFree']) ? (int) $meminfo['MemFree'] * 1024 : null;
        }
        return null;
    }

    /**
     */
    public function getFreeSwap()
    {
        $meminfo = self::getMemoryInfo();
        return isset($meminfo['SwapFree']) ? intval($meminfo['SwapFree']) * 1024 : null;
    }


}
