<?php

namespace Avdb\DoctrineExtra\Tests\Exception;

use Avdb\DoctrineExtra\Exception\DoctrineExtraException;
use Avdb\DoctrineExtra\Exception\EntityNotSupportedException;
use Avdb\DoctrineExtra\Exception\ManagerException;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;

class EntityNotSupportedExceptionTest extends DoctrineExtraTestCase
{
    public function testItIsInitializable()
    {
        $e = new EntityNotSupportedException();
        $this->assertInstanceOf(DoctrineExtraException::class, $e);
        $this->assertInstanceOf(ManagerException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}
