<?php

namespace DigipolisGent\DoctrineExtra\Tests\Exception;

use DigipolisGent\DoctrineExtra\Exception\DoctrineExtraException;
use DigipolisGent\DoctrineExtra\Tests\DoctrineExtraTestCase;

class DoctrineExtraExceptionTest extends DoctrineExtraTestCase
{
    public function testItIsInitializable()
    {
        $e = new DoctrineExtraException();
        $this->assertInstanceOf(DoctrineExtraException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}
