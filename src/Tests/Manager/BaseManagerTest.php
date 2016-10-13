<?php

namespace Avdb\DoctrineExtra\Tests\Manager;

use Avdb\DoctrineExtra\Manager\Manager;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

class BaseManagerTest extends DoctrineExtraTestCase
{
    /**
     * @var ImplementedManager
     */
    private $manager;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repo;

    public function setUp()
    {
        $this->em = $this->getMockObject(ObjectManager::class);
        $this->repo = $this->getMockObject(EntityRepository::class);

        $this->em->method('getRepository')
            ->with(SomeEntity::class)
            ->willReturn($this->repo);

        $this->manager = new ImplementedManager($this->em);
    }

    public function testItIsInitializable()
    {
        $this->assertInstanceOf(Manager::class, $this->manager);
    }
}
