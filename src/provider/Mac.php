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
}
