<?php

namespace Avdb\DoctrineExtra\Tests\Filter;

use Avdb\DoctrineExtra\Filter\AbstractFilter;
use Avdb\DoctrineExtra\Filter\DoctrineFilter;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;
use Doctrine\ORM\Query\Expr;

class AbstractFilterTest extends DoctrineExtraTestCase
{
    /**
     * @var AbstractFilterImplementation
     */
    private $filter;

    const PARAMETER =  'test_param';

    public function setUp()
    {
        $this->filter = new AbstractFilterImplementation(self::PARAMETER);
    }

    public function testImplementsDoctrineFilter()
    {
        $this->assertInstanceOf(DoctrineFilter::class, $this->filter);
        $this->assertInstanceOf(AbstractFilter::class, $this->filter);
    }

    public function testParameterWasSetThroughConstruct()
    {
        $this->assertEquals(self::PARAMETER, $this->filter->getParameter());
    }

    public function testDefaultAliasShouldReturnNull()
    {
        $this->assertNull($this->filter->getAlias());
    }

    public function testExprShouldReturnExpressionBuilder()
    {
        $this->assertInstanceOf(Expr::class, $this->filter->expr());
    }
}
