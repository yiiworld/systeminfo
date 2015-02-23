<?php
namespace systeminfo\tests;

use PHPUnit_Framework_TestCase;
use systeminfo\Reader;

class ReaderTest extends PHPUnit_Framework_TestCase
{

    public function testGetOsType()
    {
        $this->assertInternalType('string', Reader::getOsType());
    }

    public function testGetProvider()
    {
        $this->assertInstanceOf('\systeminfo\provider\AbstractProvider', Reader::getProvider());
    }
}
