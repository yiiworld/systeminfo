<?php

namespace systeminfo\provider;

/**
 * Class BSD
 * @author Eugene Terentev <eugene@terentev.net>
 * @package systeminfo\os
 */
class BSD extends AbstractBSD
{

    public function getOsRelease()
    {
        // TODO: Implement getOsRelease() method.
    }

    public function getOsType()
    {
        return 'BSD';
    }

    public function getFreeMem()
    {
        // TODO: Implement getFreeMem() method.
    }

    /**
     * @inheritdoc
     */
    public function getCpuVendor()
    {
        // TODO: Implement getCpuVendor() method.
    }
}
