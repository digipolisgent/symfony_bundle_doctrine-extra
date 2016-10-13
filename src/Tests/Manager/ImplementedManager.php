<?php
namespace Avdb\DoctrineExtra\Tests\Manager;

use Avdb\DoctrineExtra\Manager\BaseManager;

class ImplementedManager extends BaseManager
{
    public function getClass()
    {
        return SomeEntity::class;
    }
}
