<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */

namespace systeminfo\provider;

interface ProviderInterface
{
    public function getOsRelease();

    public function getOsType();

    public function getKernelVersion();

    /**
     * @param \PDO $connection
     * @return mixed
     */
    public function getDbVersion(\PDO $connection);

    /**
     * @param \PDO $connection
     * @return mixed
     */
    public function getDbInfo(\PDO $connection);

    /**
     * @param \PDO $connection
     * @return mixed
     */
    public function getDbType(\PDO $connection);

    /**
     * @return array|null
     */
    public function getMemoryInfo();

    /**
     * @return bool|int
     */
    public function getTotalMem();

    public function getFreeMem();

    public function getDiskUsage();

    public function getTotalSwap();

    public function getFreeSwap();

    /**
     * @return string
     */
    public function getPhpVersion();

    /**
     * @return string
     */
    public function getHostname();

    /**
     * @return string
     */
    public function getArchitecture();

    /**
     * @return bool
     */
    public function isLinuxOs();

    /**
     * @return bool
     */
    public function isWindowsOs();

    /**
     * @return bool
     */
    public function isBSDOs();

    /**
     * @return bool
     */
    public function isMacOs();

    /**
     * @return int|null
     */
    public function getUptime();

    /**
     * @return array|null
     */
    public function getCpuInfo();

    /**
     * @return array|null
     */
    public function getCpuCores();

    /**
     * @return array|null
     */
    public function getCpuModel();

    /**
     * @return array|null
     */
    public function getCpuVendor();

    /**
     * @return mixed
     */
    public function getServerIP();

    /**
     * @return string
     */
    public function getExternalIP();

    /**
     * @return mixed
     */
    public function getServerSoftware();

    /**
     * @return bool
     */
    public function isISS();

    /**
     * @return bool
     */
    public function isNginx();

    /**
     * @return bool
     */
    public function isApache();

    /**
     * @param int $what
     * @return string
     */
    public function getPhpInfo($what = -1);

    /**
     * @return array
     */
    public function getPHPDisabledFunctions();

    /**
     * @param array $hosts
     * @param int $count
     * @return array
     */
    public function getPing(array $hosts = null, $count = 2);

    /**
     * @param integer|boolean $key
     * @return mixed string|array
     */
    public function getLoadAverage($key = false);

    /**
     * @param int $interval
     * @return array
     */
    public function getCpuUsage($interval = 1);

    /**
     * Retrieves data from $_SERVER array
     * @param $key
     * @return mixed|null
     */
    public function getServerVariable($key);

    public function getPhpSapiName();

    /**
     * @return bool
     */
    public function isCliSapi();
}
