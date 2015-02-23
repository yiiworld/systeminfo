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

    protected function getWMI()
    {

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
}
