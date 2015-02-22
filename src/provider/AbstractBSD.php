<?php
namespace systeminfo\provider;


/**
 * Class AbstractBSD
 * @package systeminfo\provider
 * @author Eugene Terentev <eugene@terentev.net>
 */
abstract class AbstractBSD extends Provider
{
    /**
     * @return array
     */
    public function getBSDInfo()
    {
        $data = explode(PHP_EOL, shell_exec("sysctl -A"));  // system_profiler SPHardwareDataType
        $result = array();
        foreach ($data as $line) {
            $line = explode(":", $line);
            if (isset($line[0]) && isset($line[1])) {
                $result[$line[0]] = trim($line[1]);
            }
        }
        return $result;
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


}
