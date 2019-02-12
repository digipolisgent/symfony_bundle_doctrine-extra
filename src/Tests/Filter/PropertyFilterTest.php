<?php

namespace DigipolisGent\DoctrineExtra\Tests\Filter;

use DigipolisGent\DoctrineExtra\Filter\DoctrineFilter;
use DigipolisGent\DoctrineExtra\Filter\PropertyFilter;
use DigipolisGent\DoctrineExtra\Tests\DoctrineExtraTestCase;
use Doctrine\ORM\Query\Expr\Comparison;

class PropertyFilterTest extends DoctrineExtraTestCase
{
    /**
     * @var PropertyFilter
     */
    private $filter;

    const PARAMETER = 'some_param';
    const PROPERTY  = 'property';
    const ROOT = 'root';

    public function setUp()
    {
        $this->filter = new PropertyFilter(self::PARAMETER, self::PROPERTY);
    }

    public function itIsInitializable()
    {
        $this->assertInstanceOf(DoctrineFilter::class, $this->filter);
        $this->assertInstanceOf(PropertyFilter::class, $this->filter);
    }

    public function testParameterAndPropertyAreSetThroughConstruct()
    {
        $reflect = new \ReflectionClass($this->filter);
        $property = $reflect->getProperty('property');
        $property->setAccessible(true);

        $this->assertEquals(self::PARAMETER, $this->filter->getParameter());
        $this->assertEquals(self::PROPERTY, $property->getValue($this->filter));
    }

    public function testShouldCreateEqExpr()
    {
        $expr = $this->filter->createExpression(self::ROOT);

        $this->assertInstanceOf(Comparison::class, $expr);
        $this->assertEquals(sprintf('%s.%s', self::ROOT, self::PROPERTY), $expr->getLeftExpr());
        $this->assertEquals('=', $expr->getOperator());
        $this->assertEquals(sprintf('\'%s\'', self::PARAMETER), (string)$expr->getRightExpr());
    }
}
