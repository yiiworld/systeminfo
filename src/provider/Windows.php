<?php

namespace systeminfo\provider;

/**
 * Class Windows
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo\os
 */
class Windows extends AbstractProvider
{

    public function getOsRelease()
    {
        // TODO: Implement getOsRelease() method.
    }

    public function getOsType()
    {
        // TODO: Implement getOsType() method.
    }

    public function getCpuUsage($interval = 1)
    {
        return false;
    }

    public function getLoadAverage($key = null)
    {
        return false;
    }

    public function getKernelVersion()
    {
        // TODO: Implement getKernelVersion() method.
    }

    /**
     * @return array|null
     */
    public function getMemoryInfo()
    {
        // TODO: Implement getMemoryInfo() method.
    }

    /**
     * @return bool|int
     */
    public function getTotalMem()
    {
        // TODO: Implement getTotalMem() method.
    }

    public function getFreeMem()
    {
        // TODO: Implement getFreeMem() method.
    }

    public function getTotalSwap()
    {
        // TODO: Implement getTotalSwap() method.
    }

    public function getFreeSwap()
    {
        // TODO: Implement getFreeSwap() method.
    }

    protected function getWMI()
    {
        $wmi = new \COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');

        if (!is_object($wmi)) {
            throw new \RuntimeException('WMI access error. Please enable DCOM in php.ini and allow the current
                user to access the WMI DCOM object.');
        }
    }

    /**
     * @return int|null
     */
    public function getUptime()
    {
        // TODO: Implement getUptime() method.
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
