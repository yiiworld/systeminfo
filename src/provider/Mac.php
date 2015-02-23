<?php

namespace systeminfo\provider;

/**
 * Class Mac
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo\os
 */
class Mac extends AbstractBSD
{

    public function getOsRelease()
    {
        // TODO: Implement getOsRelease() method.
    }

    public function getOsType()
    {
        return 'Mac';
    }

    public function getFreeMem()
    {
        // TODO: Implement getFreeMem() method.
    }

    public function getFreeSwap()
    {
        // TODO: Implement getFreeSwap() method.
    }

    /**
     * @return array|null
     */
    public function getCpuVendor()
    {
        // TODO: Implement getCpuVendor() method.
    }
}
