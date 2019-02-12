<?php
namespace DigipolisGent\DoctrineExtra\Resolver;

use DigipolisGent\DoctrineExtra\Exception\ResolverException;
use DigipolisGent\DoctrineExtra\Filter\DoctrineFilter;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Class FilterResolver
 * Resolves filters to the QueryBuilder object
 *
 * @package DigipolisGent\DoctrineExtra\Resolver
 */
trait Resolver
{
    /**
     * Adds the filters to the QueryBuilder
     *
     * @param DoctrineFilter[]|DoctrineFilter $filters
     * @param QueryBuilder $builder
     * @return QueryBuilder
     * @throws ResolverException
     */
    public function resolve($filters = [], QueryBuilder $builder)
    {
        $root = $this->resolveRoot($builder);
        $expr = $builder->expr()->andX();

        if ($filters instanceof DoctrineFilter) {
            $filters = [$filters];
        }

        if (!is_array($filters)) {
            throw new ResolverException('Expected a DoctrineFilter or an array of DoctrineFilters');
        }

        foreach ($filters as $filter) {
            $alias = $filter->getAlias() ?: $root;

            if (!$filter instanceof DoctrineFilter) {
                throw new ResolverException(
                    sprintf('Could not resolve %s, can only handle DoctrineFilter instances', get_class($filter))
                );
            }

            $expr->add($filter->createExpression($root));

            if (false === $this->isPresent($alias, $builder)) {
                $filter->addAlias($builder, $root);
            }
        }

        if (count($expr->getParts()) > 0) {
            $builder->andWhere($expr);
        }

        return $builder;
    }

    /**
     * Returns the root select element
     *
     * @param QueryBuilder $builder
     * @return string
     * @throws ResolverException
     */
    protected function resolveRoot(QueryBuilder $builder)
    {
        $select = $builder->getDQLPart('select');

        if (!is_array($select) || !$select || !(string)$select[0]) {
            throw new ResolverException('Could not resolve the root selector from the QueryBuilder object');
        }

        return (string)$select[0];
    }

    /**
     * Checks if an alias is present in the QueryBuilder (selected or joined)
     *
     * @param $alias
     * @param QueryBuilder $builder
     * @return bool
     */
    protected function isPresent($alias, QueryBuilder $builder)
    {
        foreach ((array)$builder->getDQLPart('select') as $select) {
            if ((string)$select === $alias) {
                return true;
            }
        }

        foreach ((array)$builder->getDQLPart('join') as $joinedAlias => $expr) {
            /**  @var Expr\Join[] $expr */
            if ($joinedAlias === $alias) {
                return true;
            }

            foreach ((array)$expr as $join) {
                if ($join->getAlias() === $alias) {
                    return true;
                }
            }
        }

        return false;
    }
}
