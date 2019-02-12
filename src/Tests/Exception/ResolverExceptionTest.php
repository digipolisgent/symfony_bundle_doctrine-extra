<?php

namespace DigipolisGent\DoctrineExtra\Tests\Exception;

use DigipolisGent\DoctrineExtra\Exception\DoctrineExtraException;
use DigipolisGent\DoctrineExtra\Exception\ResolverException;
use DigipolisGent\DoctrineExtra\Tests\DoctrineExtraTestCase;

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
