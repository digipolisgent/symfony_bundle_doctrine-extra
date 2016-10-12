<?php

namespace Avdb\DoctrineExtra\Assert;

use Avdb\DoctrineExtra\Exception\AssertResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class Assertable
 *
 * @package Avdb\DoctrineExtra\Assert
 */
trait Assertable
{
    /**
     * The result form that should be asserted
     *
     * @var string
     */
    protected $assert = Result::ARRAY;

    /**
     * Returns the asserted result for a QueryBuilder
     *
     * @param QueryBuilder $builder
     * @param int $hydration
     * @return array|\Doctrine\ORM\Internal\Hydration\IterableResult|Query|QueryBuilder|Paginator|int|mixed
     * @throws AssertResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function assertResult(QueryBuilder $builder, $hydration = Query::HYDRATE_OBJECT)
    {
        switch($this->assert) {
            case Result::ARRAY:
                return $builder->getQuery()->getResult($hydration);
            case Result::PAGINATE:
                return new Paginator($builder);
            case Result::SINGLE:
                return $builder->getQuery()->getOneOrNullResult($hydration);
            case Result::FIRST:
                $result = $builder->setMaxResults(1)->getQuery()->getResult();
                return count($result) > 0 ? $result[0] : null;
            case Result::ITERATE:
                return $builder->getQuery()->iterate();
            case Result::COUNT:
                $paginator = new Paginator($builder);
                return $paginator->count();
            case Result::QUERY:
                return $builder->getQuery();
            case Result::BUILDER:
                return $builder;
            default:
                throw new AssertResultException(sprintf('Unknown result assertion "%s"', $this->assert));
        }
    }

    /**
     * Sets the result to Single
     *
     * @return $this
     */
    public function single()
    {
        $this->assert = Result::SINGLE;
        return $this;
    }

    /**
     * Sets the result to First
     *
     * @return $this
     */
    public function first()
    {
        $this->assert = Result::FIRST;
        return $this;
    }

    /**
     * Sets the result to Paginator
     *
     * @return $this
     */
    public function paginate()
    {
        $this->assert = Result::PAGINATE;
        return $this;
    }

    /**
     * Sets the result to Iterator
     *
     * @return $this
     */
    public function iterate()
    {
        $this->assert = Result::ITERATE;
        return $this;
    }

    /**
     * Sets the result to Count
     *
     * @return $this
     */
    public function count()
    {
        $this->assert = Result::COUNT;
        return $this;
    }

    /**
     * Sets the result to Query
     *
     * @return $this
     */
    public function query()
    {
        $this->assert = Result::QUERY;
        return $this;
    }

    /**
     * Sets the result to QueryBuilder
     *
     * @return $this
     */
    public function builder()
    {
        $this->assert = Result::BUILDER;
        return $this;
    }
}
