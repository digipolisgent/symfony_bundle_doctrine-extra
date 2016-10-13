<?php

namespace Avdb\DoctrineExtra\Manager;

use Avdb\DoctrineExtra\Assert\Assertable;
use Avdb\DoctrineExtra\Exception\EntityNotFoundException;
use Avdb\DoctrineExtra\Exception\EntityNotSupportedException;
use Avdb\DoctrineExtra\Filter\DoctrineFilter;
use Avdb\DoctrineExtra\Resolver\Resolver;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Internal\Hydration\IterableResult;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class EntityManager
 *
 * @package Avdb\DoctrineExtra\Manager
 */
abstract class BaseManager implements Manager
{
    /** Assert Results */
    use Assertable;

    /** Resolve Filters */
    use Resolver;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * Add default filters for each query
     *
     * @var array
     */
    private $filters = [];

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
     * Entity class the Manager is supporting
     *
     * @return string
     */
    public abstract function getClass();

    /**
     * Filters for a set of results, asserts the result
     *
     * @param DoctrineFilter[]|array|DoctrineFilter $filters
     * @return array|IterableResult|Query|QueryBuilder|Paginator|int|mixed
     */
    public function filter($filters = [])
    {
        $builder = $this->repository->createQueryBuilder('root');
        $filters = array_merge($this->filters, $filters);

        return $this->assertResult(
            $this->resolve($filters, $builder)
        );
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
     * Adds a default filter
     *
     * @param DoctrineFilter $filter
     */
    public function addFilter(DoctrineFilter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * Get the default filters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
