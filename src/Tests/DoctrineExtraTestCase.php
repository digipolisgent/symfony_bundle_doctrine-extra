<?php

namespace DigipolisGent\DoctrineExtra\Tests;

/**
 * Class DoctrineExtraTestCase
 * Base test case for all tests in this bundle
 *
 * @package DigipolisGent\DoctrineExtra\Tests
 */
class DoctrineExtraTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $class
     * @return mixed|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockObject($class)
    {
        $mocker = $this->getMockBuilder($class);
        $mocker->disableOriginalConstructor();

        return $mocker->getMock();
    }
}
