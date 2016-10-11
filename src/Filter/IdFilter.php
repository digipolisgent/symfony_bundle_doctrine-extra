<?php

namespace Avdb\DoctrineFilters\Filter;

use Doctrine\ORM\Query\Expr;

class IdFilter extends AbstractFilter
{
    /**
     * Creates a simple root.id = :id expression, with the id parameter filled
     *
     * @param string $root
     * @return Expr\Comparison
     */
    public function createExpression($root)
    {
        return $this->expr()->eq(
            sprintf('%s.id', $root),
            $this->expr()->literal($this->parameter)
        );
    }
}
