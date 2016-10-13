<?php

namespace Avdb\DoctrineExtra\Tests\Exception;

use Avdb\DoctrineExtra\Exception\DoctrineExtraException;
use Avdb\DoctrineExtra\Exception\ManagerException;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;

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
