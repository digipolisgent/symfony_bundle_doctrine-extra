<?php
namespace Avdb\DoctrineExtra\Filter;

use Avdb\DoctrineExtra\Resolver\Resolver;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AggregateFilter
 *
 * @package Avdb\DoctrineExtra\Filter
 * @method DoctrineFilter[] getParameter()
 */
class AggregateFilter extends AbstractFilter
{
    const OR_X  = 'OR_X';
    const AND_X = 'AND_X';

    /**
     * Defines the type of aggregate it would be
     *
     * @var string
     */
    private $operator = self::OR_X;

    /**
     * AggregateFilter constructor.
     *
     * @param array|DoctrineFilter[] $parameter
     * @param string $operator
     */
    public function __construct($parameter = [], $operator = self::OR_X)
    {
        parent::__construct(null);

        if (!is_array($parameter)) {
            throw new \InvalidArgumentException('Parameter should be an array of DoctrineFilters');
        }

        foreach ($parameter as $filter) {
            $this->addFilter($filter);
        }

        $this->operator = $operator;
    }

    /**
     * @inheritdoc
     */
    public function createExpression($root)
    {
        if ($this->operator === self::OR_X) {
            $expr = $this->expr()->orX();
        } else {
            $expr = $this->expr()->andX();
        }

        foreach ($this->getParameter() as $filter) {
            $expr->add($filter->createExpression($root));
        }

        return $expr;
    }

    /**
     * @inheritdoc
     */
    public function addAlias(QueryBuilder $builder, $root)
    {
        foreach ($this->getParameter() as $filter) {
            if (Resolver::isPresent($filter->getAlias(), $builder)) {
                $filter->addAlias($builder, $root);
            }
        }
    }

    /**
     * This will trigger the isPresent to return false so that addAlias will be called
     *
     * @return string
     */
    public function getAlias()
    {
        return 'aggregate';
    }

    /**
     * @param DoctrineFilter $filter
     * @return $this
     */
    public function addFilter(DoctrineFilter $filter)
    {
        $this->parameter[] = $filter;

        return $this;
    }
}
