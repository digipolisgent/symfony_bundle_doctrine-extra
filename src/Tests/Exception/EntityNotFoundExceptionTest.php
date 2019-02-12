<?php

namespace DigipolisGent\DoctrineExtra\Tests\Exception;

use DigipolisGent\DoctrineExtra\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityNotFoundException as DoctrineEntityNotFoundException;
use DigipolisGent\DoctrineExtra\Tests\DoctrineExtraTestCase;

class EntityNotFoundExceptionTest extends DoctrineExtraTestCase
{
    public function testItIsInitializable()
    {
        $e = new EntityNotFoundException();
        $this->assertInstanceOf(DoctrineEntityNotFoundException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}
