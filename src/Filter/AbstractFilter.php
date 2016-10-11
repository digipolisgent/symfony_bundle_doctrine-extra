<?php

namespace Avdb\DoctrineFilters\Filter;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractFilter implements DoctrineFilter
{
    /**
     * Parameter used in the Filter
     *
     * @var mixed
     */
    protected $parameter;

    /**
     * AbstractFilter constructor.
     *
     * @param mixed $parameter
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function addAlias(QueryBuilder $builder, $root)
    {
        
    }

    /**
     * @return mixed
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * @return Expr
     */
    public function expr()
    {
        return new Expr();
    }
}
