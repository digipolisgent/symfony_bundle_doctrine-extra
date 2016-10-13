<?php

namespace Avdb\DoctrineExtra\Tests\Filter;

use Avdb\DoctrineExtra\Filter\AggregateFilter;
use Avdb\DoctrineExtra\Filter\DoctrineFilter;
use Avdb\DoctrineExtra\Filter\PropertyFilter;
use Avdb\DoctrineExtra\Tests\DoctrineExtraTestCase;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Orx;

class AggregateFilterTest extends DoctrineExtraTestCase
{
    /**
     * @var AggregateFilter
     */
    private $filter;

    /**
     * @var DoctrineFilter[]
     */
    private $filters;

    public function setUp()
    {
        $this->filters = [
            new PropertyFilter('test_param', 'parameter'),
            new PropertyFilter('test_param_2', 'parameter_2')
        ];

        $this->filter = new AggregateFilter($this->filters);
    }

    public function testItIsInitializable()
    {
        $this->assertInstanceOf(DoctrineFilter::class, $this->filter);
        $this->assertInstanceOf(AggregateFilter::class, $this->filter);
    }

    public function testParameterShouldBeAnArrayWithFilters()
    {
        $this->assertEquals($this->filter->getParameter(), $this->filters);
    }

    public function testShouldCreateOrXExpressionByDefault()
    {
        $this->assertInstanceOf(Orx::class, $this->filter->createExpression('root'));
    }

    public function testShouldCreateAndXExpressionWhenAndXFlagIsPassedThroughConstructor()
    {
        $filter = new AggregateFilter($this->filters, AggregateFilter::AND_X);
        $this->assertInstanceOf(Andx::class, $filter->createExpression('root'));
    }

    public function testCreateExpressionShouldBeCalledOnAllChildFiltersWithRootArgument()
    {
        $filter = new AggregateFilter([]);

        $mock1 = $this->getMockObject(DoctrineFilter::class);
        $mock2 = $this->getMockObject(DoctrineFilter::class);

        $mock1->expects($this->once())
            ->method('createExpression')
            ->with('root');

        $mock2->expects($this->once())
            ->method('createExpression')
            ->with('root');

        $filter->addFilter($mock1);
        $filter->addFilter($mock2);

        $filter->createExpression('root');
    }

    public function testGetAliasShouldReturnAggregate()
    {
        $this->assertEquals('aggregate', $this->filter->getAlias());
    }

    public function testCanAddFilter()
    {
        $filter = new AggregateFilter();
        $child = new PropertyFilter('some_prop', 'property');

        $filter->addFilter($child);

        $this->assertCount(1, $filter->getParameter());
        $this->assertEquals($child, $filter->getParameter()[0]);
    }
}
