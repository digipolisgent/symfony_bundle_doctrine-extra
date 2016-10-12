<?php

namespace Avdb\DoctrineExtra\Manager;

use Avdb\DoctrineExtra\Exception\EntityNotFoundException;
use Avdb\DoctrineExtra\Exception\EntityNotSupportedException;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class EntityManager
 *
 * @package Avdb\DoctrineExtra\Manager
 */
abstract class AbstractManager implements Manager
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    private $class;

    /**
     * EntityManager constructor.
     *
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->repository = $manager->getRepository($this->getClass());
        $this->class = $this->getClass();
    }

    /**
     * Fetches an entity by id
     * 
     * @param $id
     * @return null|object
     * @throws EntityNotFoundException
     */
    public function get($id)
    {
        $object = $this->repository->find($id);

        if($object instanceof $this->class) {
            return $object;
        }
        
        throw EntityNotFoundException::fromEntity($this->class, $id);
    }
    
    /**
     * @param $object
     * @throws EntityNotSupportedException
     */
    public function create($object)
    {
        if (!$object instanceof $this->class) {
            throw EntityNotSupportedException::fromClass(get_class($object), $this->class);
        }

        $this->manager->persist($object);
        $this->manager->flush();
    }

    /**
     * @param $object
     * @throws EntityNotSupportedException
     */
    public function update($object)
    {
        if (!$object instanceof $this->class) {
            throw EntityNotSupportedException::fromClass(get_class($object), $this->class);
        }

        $this->manager->persist($object);
        $this->manager->flush();
    }

    /**
     * @param $object
     * @throws EntityNotSupportedException
     */
    public function delete($object)
    {
        if (!$object instanceof $this->class) {
            throw EntityNotSupportedException::fromClass(get_class($object), $this->class);
        }

        $this->manager->remove($object);
        $this->manager->flush();
    }

    /**
     * Entity class the Manager is supporting
     *
     * @return string
     */
    public abstract function getClass();
}
