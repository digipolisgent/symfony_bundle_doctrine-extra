<?php

namespace DigipolisGent\DoctrineExtra\Filter;

use Doctrine\ORM\Query\Expr;

class PropertyFilter extends AbstractFilter
{
    /**
     * Property where there's filtered
     *
     * @var string
     */
    private $property;

    /**
     * PropertyFilter constructor.
     *
     * @param mixed $parameter
     * @param $property
     */
    public function __construct($parameter, $property)
    {
        parent::__construct($parameter);
        $this->property = $property;
    }

    /**
     * @param string $root
     * @return Expr\Comparison
     */
    public function createExpression($root)
    {
        return $this->expr()->eq(sprintf('%s.%s', $root, $this->property), $this->expr()->literal($this->parameter));
    }
}
