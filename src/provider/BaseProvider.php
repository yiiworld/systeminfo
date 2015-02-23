<?php
namespace systeminfo\provider;

/**
 * Class BaseProvider
 * @package systeminfo\provider
 * @author Eugene Terentev <eugene@terentev.net>
 */
class BaseProvider extends AbstractProvider
{

    public function getOsRelease()
    {
        // TODO: Implement getOsRelease() method.
    }

    public function getOsType()
    {
        // TODO: Implement getOsType() method.
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
