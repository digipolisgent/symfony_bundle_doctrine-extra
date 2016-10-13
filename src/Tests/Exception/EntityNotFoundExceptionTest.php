<?php

namespace Avdb\DoctrineExtra\Tests\Exception;

use Avdb\DoctrineExtra\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityNotFoundException as DoctrineEntityNotFoundException;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;

class EntityNotFoundExceptionTest extends DoctrineExtraTestCase
{
    public function testItIsInitializable()
    {
        $e = new EntityNotFoundException();
        $this->assertInstanceOf(DoctrineEntityNotFoundException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}
