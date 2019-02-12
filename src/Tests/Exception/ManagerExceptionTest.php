<?php

namespace DigipolisGent\DoctrineExtra\Tests\Exception;

use DigipolisGent\DoctrineExtra\Exception\DoctrineExtraException;
use DigipolisGent\DoctrineExtra\Exception\ManagerException;
use DigipolisGent\DoctrineExtra\Tests\DoctrineExtraTestCase;

class ManagerExceptionTest extends DoctrineExtraTestCase
{
    public function testItIsInitializable()
    {
        $e = new ManagerException();
        $this->assertInstanceOf(DoctrineExtraException::class, $e);
        $this->assertInstanceOf(ManagerException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}
