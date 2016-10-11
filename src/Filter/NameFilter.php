<?php

namespace Avdb\DoctrineFilters\Filter;

use Doctrine\ORM\Query\Expr;

class NameFilter extends AbstractFilter
{
    /**
     * Creates a simple root.name = :name expression, where the parameter is filled
     *
     * @param string $root
     * @return Expr\Comparison
     */
    public function createExpression($root)
    {
        return $this->expr()->eq(
            sprintf('%s.name', $root),
            $this->expr()->literal($this->getParameter())
        );
    }
}
