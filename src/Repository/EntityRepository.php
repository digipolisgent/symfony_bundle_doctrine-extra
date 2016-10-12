<?php

namespace Avdb\DoctrineExtra\Repository;

use Avdb\DoctrineExtra\Assert\Assertable;
use Avdb\DoctrineExtra\Filter\DoctrineFilter;
use Avdb\DoctrineExtra\Resolver\Filterable;
use Avdb\DoctrineExtra\Resolver\Resolver;
use Doctrine\ORM\Internal\Hydration\IterableResult;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class EntityRepository
 *
 * This base entity repository is able to filter & assert the result !
 *
 * @package Avdb\DoctrineExtra\EntityRepository
 */
class EntityRepository extends \Doctrine\ORM\EntityRepository
{
    /** Assert Results */
    use Assertable;

    /** Resolve Filters */
    use Resolver;

    /**
     * Add default filters for each query
     *
     * @var array
     */
    private $filters = [];

    /**
     * Filters for a set of results, asserts the result
     *
     * @param $filters
     * @return array|IterableResult|Query|QueryBuilder|Paginator|int|mixed
     */
    public function filter($filters)
    {
        $builder = $this->createQueryBuilder('root');
        $filters = array_merge($this->filters, $filters);

        return $this->assertResult(
            $this->resolve($filters, $builder)
        );
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
