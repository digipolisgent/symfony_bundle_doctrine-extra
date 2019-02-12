<?php

namespace DigipolisGent\DoctrineExtra\Tests\Exception;

use DigipolisGent\DoctrineExtra\Exception\AssertResultException;
use DigipolisGent\DoctrineExtra\Exception\DoctrineExtraException;
use DigipolisGent\DoctrineExtra\Tests\DoctrineExtraTestCase;

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
