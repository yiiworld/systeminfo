<?php

namespace systeminfo\provider;

/**
 * Class Windows
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo\os
 */
class Windows extends Provider
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
}
