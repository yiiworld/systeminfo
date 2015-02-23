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
        return shell_exec('/bin/uname -r');
    }

    /**
     */
    public function getTotalSwap()
    {
        $meminfo = self::getMemoryInfo();
        return isset($meminfo['SwapTotal']) ? intval($meminfo['SwapTotal']) * 1024 : null;
    }

    /**
     * @return bool|int
     */
    public function getTotalMem()
    {
        $meminfo = self::getMemoryInfo();
        return isset($meminfo['MemTotal']) ? intval($meminfo['MemTotal']) * 1024 : null;
    }

    /**
     * @return array|null
     */
    public function getMemoryInfo()
    {
        $data = @explode("\n", file_get_contents("/proc/meminfo"));
        $meminfo = array();
        foreach ($data as $line) {
            $line = explode(":", $line);
            if (isset($line[0]) && isset($line[1])) {
                $meminfo[$line[0]] = trim($line[1]);
            }
        }
        return $meminfo;
    }

    /**
     * @return bool|int
     */
    public function getFreeMem()
    {
        $meminfo = self::getMemoryInfo();
        return isset($meminfo['MemFree']) ? (int) $meminfo['MemFree'] * 1024 : null;
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

    /**
     * @return array|null
     */
    public function getCpuModel()
    {
        // TODO: Implement getCpuModel() method.
    }

    /**
     * @return array|null
     */
    public function getCpuVendor()
    {
        // TODO: Implement getCpuVendor() method.
    }
}
