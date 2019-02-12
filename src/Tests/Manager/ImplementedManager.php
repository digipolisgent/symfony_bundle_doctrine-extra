<?php
namespace DigipolisGent\DoctrineExtra\Tests\Manager;

use DigipolisGent\DoctrineExtra\Manager\BaseManager;

class ImplementedManager extends BaseManager
{
    public function getClass()
    {
        return SomeEntity::class;
    }
}
