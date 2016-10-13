<?php

namespace Avdb\DoctrineExtra\Tests\Exception;

use Avdb\DoctrineExtra\Exception\DoctrineExtraException;
use Avdb\DoctrineExtra\Exception\ResolverException;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;

class ResolverExceptionTest extends DoctrineExtraTestCase
{
    public function testItIsInitializable()
    {
        $e = new ResolverException();
        $this->assertInstanceOf(DoctrineExtraException::class, $e);
        $this->assertInstanceOf(ResolverException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}
