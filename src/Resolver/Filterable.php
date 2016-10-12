<?php

namespace Avdb\DoctrineExtra\Resolver;

use Avdb\DoctrineExtra\Filter\DoctrineFilter;
use Doctrine\ORM\QueryBuilder;

/**
 * Class Filterable
 *
 * Use this trait in a Repository or Manager to resolve filters to a QueryBuilder Object
 *
 * @package Avdb\DoctrineExtra\Resolver
 */
trait Filterable
{
    /**
     * Add default filters for each query
     *
     * @var array
     */
    private $filters = [];

    /**
     * @param array $filters
     * @param QueryBuilder $builder
     * @return QueryBuilder
     *
     * @throws \Avdb\DoctrineExtra\Exception\ResolverException
     */
    public function matching($filters = [], QueryBuilder $builder)
    {
        $filters = array_merge($this->filters, $filters);
        Resolver::resolve($filters, $builder);
        
        return $builder;
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
