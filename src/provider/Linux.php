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
        $uptime = file_get_contents('/proc/uptime');
        $uptime = explode('.', $uptime);
        return (int) array_shift($uptime);
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
        $meminfo = $this->getMemoryInfo();
        return array_key_exists('SwapTotal', $meminfo) ? (int) $meminfo['SwapTotal'] : null;
    }

    /**
     * @return bool|int
     */
    public function getTotalMem()
    {
        $meminfo = $this->getMemoryInfo();
        return array_key_exists('MemTotal', $meminfo) ? (int) $meminfo['MemTotal'] : null;
    }

    /**
     * @return array|null
     */
    public function getMemoryInfo()
    {
        $data = explode("\n", file_get_contents("/proc/meminfo"));
        $meminfo = array();
        foreach ($data as $line) {
            $line = explode(":", $line);
            if (isset($line[0], $line[1])) {
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
        $memInfo = $this->getMemoryInfo();

        $memFree = array_key_exists('MemFree', $memInfo) ? (int) $memInfo['MemFree'] : null;
        $cached  = array_key_exists('Cached', $memInfo) ? (int) $memInfo['Cached'] : null;

        $result = ($memFree ?: null) + ($cached ?: null);

        return $result ?: null;
    }

    /**
     */
    public function getFreeSwap()
    {
        $meminfo = $this->getMemoryInfo();
        return array_key_exists('SwapFree', $meminfo) ? (int) $meminfo['SwapFree'] : null;
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
