<?php

namespace Avdb\DoctrineExtra\Tests\Exception;

use Avdb\DoctrineExtra\Exception\AssertResultException;
use Avdb\DoctrineExtra\Exception\DoctrineExtraException;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;

class AssertResultExceptionTest extends DoctrineExtraTestCase
{
    public function testItIsInitializable()
    {
        $e = new AssertResultException();
        $this->assertInstanceOf(DoctrineExtraException::class, $e);
        $this->assertInstanceOf(AssertResultException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}
