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
                $result = $builder->getQuery()->getResult($hydration);
                break;
            case Result::PAGINATE:
                $result =  new Paginator($builder);
                break;
            case Result::SINGLE:
                $result = $builder->getQuery()->getOneOrNullResult($hydration);
                break;
            case Result::FIRST:
                $result = $builder->setMaxResults(1)->getQuery()->getResult();
                $result =  count($result) > 0 ? $result[0] : null;
                break;
            case Result::ITERATE:
                $result =  $builder->getQuery()->iterate();
                break;
            case Result::COUNT:
                $result = new Paginator($builder);
                $result = $result->count();
                break;
            case Result::QUERY:
                $result = $builder->getQuery();
                break;
            case Result::BUILDER:
                $result = $builder;
                break;
            default:
                throw new AssertResultException(sprintf('Unknown result assertion "%s"', $this->assert));
        }

        $this->assert = Result::ARRAY;
        return $result;

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
