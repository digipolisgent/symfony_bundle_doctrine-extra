<?php

namespace Avdb\DoctrineExtra\Tests\Exception;

use Avdb\DoctrineExtra\Exception\DoctrineExtraException;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;

class DoctrineExtraExceptionTest extends DoctrineExtraTestCase
{
    public function testItIsInitializable()
    {
        $e = new DoctrineExtraException();
        $this->assertInstanceOf(DoctrineExtraException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}
