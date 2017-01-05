<?php

namespace Avdb\DoctrineExtra\Manager;

use Avdb\DoctrineExtra\Assert\Assertable;
use Avdb\DoctrineExtra\Exception\EntityNotFoundException;
use Avdb\DoctrineExtra\Exception\EntityNotSupportedException;
use Avdb\DoctrineExtra\Exception\ValidationException;
use Avdb\DoctrineExtra\Filter\DoctrineFilter;
use Avdb\DoctrineExtra\Resolver\Resolver;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Internal\Hydration\IterableResult;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * The validator, can be null
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * EntityManager constructor.
     *
     * @param ObjectManager $manager
     * @param ValidatorInterface $validator
     */
    public function __construct(ObjectManager $manager, ValidatorInterface $validator = null)
    {
        $this->validator = $validator;
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
     * @param array $orderBy
     * @return array|IterableResult|Query|QueryBuilder|Paginator|int|mixed
     * @throws \Avdb\DoctrineExtra\Exception\AssertResultException
     * @throws \Avdb\DoctrineExtra\Exception\ResolverException
     */
    public function filter($filters = [], $orderBy = [])
    {
        if ($filters instanceof DoctrineFilter) {
            $filters = [$filters];
        }

        if(!isset($orderBy['order'], $orderBy['sort'])) {
            $orderBy['order'] = 'DESC';
            $orderBy['sort']  = 'root.id';
        }

        $builder = $this->repository->createQueryBuilder('root');
        $builder->orderBy($orderBy['sort'], $orderBy['order']);

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

        $this->save($object);
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

        $this->save($object);
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
     * Saves an object to the database, but validates upon saving when validator is present
     *
     * @param $object
     * @throws ValidationException
     */
    protected function save($object)
    {
        if (null !== $this->validator) {
            $validation = $this->validator->validate($object);
            
            if($validation->count() > 0) {
                throw new ValidationException($validation);
            }
        }

        $this->manager->persist($object);
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
