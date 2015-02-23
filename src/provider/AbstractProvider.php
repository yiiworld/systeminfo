<?php

namespace systeminfo\provider;

/**
 * Class BaseInfo
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo\os
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @return string
     */
    public function getPhpVersion()
    {
        return phpversion();
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return php_uname('n');
    }

    /**
     * @return string
     */
    public function getArchitecture()
    {
        return php_uname('m');
    }

    public function isLinuxOs()
    {
        return $this->getOsType() === 'Linux';
    }

    /**
     * @return bool
     */
    public function isWindowsOs()
    {
        return $this->getOsType() === 'Windows';
    }

    /**
     * @return bool
     */
    public function isBSDOs()
    {
        return $this->getOsType() === 'BSD';
    }

    public function isMacOs()
    {
        return $this->getOsType() === 'Mac';
    }

    /**
     * @param bool $key
     * @return array|null
     */
    public function getCpuinfo($key = false)
    {
        if (self::isWindowsOs()) {
            return null; // todo: Windows
        } elseif (self::isBSDOs()) {
            $osxinfo = self::getBSDInfo();
            if ($key == 'model name') {
                return isset($osxinfo['machdep.cpu.brand_string']) ? $osxinfo['machdep.cpu.brand_string'] : null;
            } elseif ($key == 'cpu cores') {
                return isset($osxinfo['hw.physicalcpu']) ? $osxinfo['hw.physicalcpu'] : null;
            }
        } else {
            $cpuinfo = @file_get_contents('/proc/cpuinfo');
            if ($cpuinfo) {
                $cpuinfo = explode("\n", $cpuinfo);
                $values = [];
                foreach ($cpuinfo as $v) {
                    $v = array_map("trim", explode(':', $v));
                    if (isset($v[0]) && isset($v[1])) {
                        $values[$v[0]] = $v[1];
                    }
                }
                return $key ?
                    (isset($values[$key]) ? $values[$key] : null)
                    : $values;
            }
        }
        return null;
    }

    /**
     * @return array|null
     */
    public function getCpuCores()
    {
        return $this->getCpuinfo('cpu cores');
    }

    /**
     * @return mixed
     */
    public function getServerIP()
    {
        return $this->isISS() ? $this->getServerVariable('LOCAL_ADDR') : $this->getServerVariable('SERVER_ADDR');
    }

    /**
     * @return string
     */
    public function getExternalIP()
    {
        $cmd = 'dig +short myip.opendns.com @resolver1.opendns.com';
        exec($cmd, $output);
        if (is_array($output) && !empty($output)) {
            return trim($output[0]);
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getServerSoftware()
    {
        return $this->getServerVariable('SERVER_SOFTWARE');
    }

    /**
     * @return bool
     */
    public function isISS()
    {
        return strpos(strtolower($this->getServerSoftware()), 'microsoft-iis') !== false;
    }

    /**
     * @return bool
     */
    public function isNginx()
    {
        return strpos(strtolower($this->getServerSoftware()), 'nginx') !== false;
    }

    /**
     * @return bool
     */
    public function isApache()
    {
        return strpos(strtolower(self::getServerSoftware()), 'apache') !== false;
    }

    /**
     * @param int $what
     * @return string
     */
    public function getPhpInfo($what = -1)
    {
        ob_start();
        phpinfo($what);
        return ob_get_clean();
    }

    /**
     * @return array
     */
    public function getPHPDisabledFunctions()
    {
        return array_map('trim', explode(',', ini_get('disable_functions')));
    }

    /**
     * @param array $hosts
     * @param int $count
     * @return array
     */
    public function getPing(array $hosts = null, $count = 2)
    {
        if (!$hosts) {
            $hosts = array("gnu.org", "github.com", "wikipedia.org");
        }
        $ping = [];
        for ($i = 0; $i < count($hosts); $i++) {
            $command = self::isWindowsOs()
                ? 'ping' // todo: Windows
                : "/bin/ping -qc {$count} {$hosts[$i]} | awk -F/ '/^rtt/ { print $5 }'";
            $result = array();
            exec($command, $result);
            $ping[$hosts[$i]] = isset($result[0]) ? $result[0] : false;
        }
        return $ping;
    }

    /**
     * @param integer|boolean $key
     * @return mixed string|array
     */
    public function getLoadAverage($key = false)
    {
        $la = array_combine([1,5,15], sys_getloadavg());
        return ($key !== false && array_key_exists($key, $la)) ? $la[$key] : $la;
    }

    /**
     * @param int $interval
     * @return array
     */
    public function getCpuUsage($interval = 1)
    {
        $stat = function() {
            $stat = @file_get_contents('/proc/stat');
            $stat = explode("\n", $stat);
            $result = [];
            foreach ($stat as $v) {
                $v = explode(" ", $v);
                if (isset($v[0])
                    && strpos(strtolower($v[0]), 'cpu') === 0
                    && preg_match('/cpu[\d]/sim', $v[0])
                ) {
                    $result[] = array_slice($v, 1, 4);
                }

            }
            return $result;
        };
        $stat1 = $stat();
        usleep($interval * 1000000);
        $stat2 = $stat();
        $usage = [];
        for ($i = 0; $i < self::getCpuCores(); $i++) {
            $total = array_sum($stat2[$i]) - array_sum($stat1[$i]);
            $idle = $stat2[$i][3] - $stat1[$i][3];
            $usage[$i] = $total !== 0 ? ($total - $idle) / $total : 0;
        }
        return $usage;
    }

    /**
     *
     */
    public function getDiskUsage()
    {
        // todo: Function
    }

    /**
     * @param \PDO $connection
     * @return mixed
     */
    public function getDbInfo(\PDO $connection)
    {
        return $connection->getAttribute(\PDO::ATTR_SERVER_INFO);
    }

    /**
     * @param \PDO $connection
     * @return mixed
     */
    public function getDbType(\PDO $connection)
    {
        return $connection->getAttribute(\PDO::ATTR_DRIVER_NAME);
    }

    /**
     * @param $connection
     * @return string
     */
    public function getDbVersion(\PDO $connection)
    {
        if (is_a($connection, 'PDO')) {
            return $connection->getAttribute(\PDO::ATTR_SERVER_VERSION);
        } else {
            return mysqli_get_server_info($connection);
        }
    }

    /**
     * Retrieves data from $_SERVER array
     * @param $key
     * @return mixed|null
     */
    public function getServerVariable($key)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
    }

    public function getPhpSapiName()
    {
        return php_sapi_name();
    }

    public function isCliSapi()
    {
        return strtolower(substr($this->getPhpSapiName(), 0, 3)) === 'cli';
    }
}
