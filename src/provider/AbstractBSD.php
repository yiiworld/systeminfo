<?php
namespace systeminfo\provider;


/**
 * Class AbstractBSD
 * @package systeminfo\provider
 * @author Eugene Terentev <eugene@terentev.net>
 */
abstract class AbstractBSD extends AbstractProvider
{
    /**
     * @return array
     */
    public function getSysctlInfo()
    {
        $data = explode(PHP_EOL, shell_exec("sysctl -A"));
        $result = array();
        foreach ($data as $line) {
            $line = explode(":", $line);
            if (isset($line[0], $line[1])) {
                $result[$line[0]] = trim($line[1]);
            }
        }
        return $result;
    }

    /**
     */
    public function getTotalSwap()
    {
        $meminfo = self::getMemoryInfo();
        preg_match_all('/=(.*?)M/', $meminfo['vm.swapusage'], $res);
        return isset($res[1][0]) ? (int)($res[1][0]) * 1024 * 1024 : null;
    }

    /**s
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
     * @inheritdoc
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

    public function getOsRelease()
    {
        return shell_exec('sw_vers -productVersion');
    }

    /**
     * @inheritdoc string
     */
    public function getKernelVersion()
    {
        return shell_exec('uname -v');
    }

    /**
     * @inheritdoc
     */
    public function getCpuModel()
    {
        $sysctlinfo = $this->getSysctlInfo();
        return array_key_exists('machdep.cpu.brand_string', $sysctlinfo)
            ? $sysctlinfo['machdep.cpu.brand_string']
            : null;
    }

    /**
     * @inheritdoc
     */
    public function getCpuCores()
    {
        $sysctlinfo = $this->getSysctlInfo();
        return array_key_exists('hw.physicalcpu', $sysctlinfo)
            ? $sysctlinfo['hw.physicalcpu']
            : null;
    }

    /**
     * @inheritdoc
     */
    public function getUptime()
    {
        $uptime = shell_exec("sysctl -n kern.boottime | awk '{print $4}' | sed 's/,//'");
        if ($uptime) {
            return (int)(time() - $uptime);
        }
    }

    /**
     * @return bool|int
     */
    public function getFreeSwap()
    {
        $meminfo = self::getMemoryInfo();
        preg_match_all('/=(.*?)M/', $meminfo['vm.swapusage'], $res);
        return isset($res[1][2]) ? intval($res[1][2]) * 1024 * 1024 : null;
    }
}
