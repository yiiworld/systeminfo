<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */

namespace systeminfo\tests;


use systeminfo\Reader;

class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \systeminfo\provider\AbstractProvider
     */
    protected $provider;

    public function setUp()
    {
        $this->provider = Reader::getProvider();
    }

    public function testGetPhpVersion()
    {
        $this->assertEquals(phpversion(), $this->provider->getPhpVersion());
    }

    public function testGetPhpSapiName()
    {
        $this->assertEquals(php_sapi_name(), $this->provider->getPhpSapiName());
    }

    public function testBooleanMethods()
    {
        $this->assertInternalType('boolean', $this->provider->isNginx());
        $this->assertInternalType('boolean', $this->provider->isApache());
        $this->assertInternalType('boolean', $this->provider->isISS());
        $this->assertInternalType('boolean', $this->provider->isBSDOs());
        $this->assertInternalType('boolean', $this->provider->isLinuxOs());
        $this->assertInternalType('boolean', $this->provider->isWindowsOs());
        $this->assertInternalType('boolean', $this->provider->isMacOs());
        $this->assertInternalType('boolean', $this->provider->isCliSapi());
    }

    public function testGetUptime()
    {
        $this->assertInternalType('integer', $this->provider->getUptime());
        $this->assertGreaterThan(0, $this->provider->getUptime());
    }
}
