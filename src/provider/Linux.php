<?php

namespace systeminfo\provider;

/**
 * Class Linux
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo\os
 */
class Linux extends AbstractProvider
{
    public function getUptime()
    {
        $uptime = @file_get_contents('/proc/uptime');
        if ($uptime) {
            $uptime = explode('.', $uptime);
            return (int) array_shift($uptime);
        }
        return false;
    }

    /**
     * @return string
     */
    public function getOsRelease()
    {
        return shell_exec('/usr/bin/lsb_release -ds');
    }

    /**
     * @inheritdoc
     */
    public function getKernelVersion()
    {
        if (self::isWindowsOs()) {
            return null;
        } elseif (self::isBSDOs()) {
            return shell_exec('uname -v');
        } else {
            return shell_exec('/bin/uname -r');
        }
    }

    /**
     */
    public function getTotalSwap()
    {
        if (self::isWindowsOs()) {
            //todo
        } elseif (self::isBSDOs()) {
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
        if (self::isWindowsOs()) {
            //todo
        } elseif (self::isBSDOs()) {
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
        if (self::isWindowsOs()) {
            return null; // todo: Windows
        } elseif (self::isBSDOs()) {
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
        if (self::isWindowsOs()) {
            //todo
        } elseif (self::isBSDOs()) {
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


    public function getOsType()
    {
        return 'Linux';
    }
}
