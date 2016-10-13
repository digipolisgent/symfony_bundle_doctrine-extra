<?php

namespace Avdb\DoctrineExtra\Tests\Filter;

use Avdb\DoctrineExtra\Filter\AbstractFilter;
use Doctrine\ORM\Query\Expr;

class AbstractFilterImplementation extends AbstractFilter
{
    /**
     * @param string $root
     * @return Expr\Comparison
     */
    public function createExpression($root)
    {
        return $this->expr()->eq(
            sprintf('%s.test', $root),
            $this->expr()->literal($this->parameter)
        );
    }
}
