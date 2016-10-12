<?php

namespace Avdb\DoctrineExtra\Filter;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineFilter
 *
 * @package Avdb\DoctrineExtra\Filter
 */
interface DoctrineFilter
{
    /**
     * Creates an expression that should be added to the QueryBuilder
     *
     * @param string $root name of the root alias
     * @return Expr
     */
    public function createExpression($root);

    /**
     * Adds the alias to the QueryBuilder
     *
     * eg: UserNameFilter -> we need to add 'User' alias to the QueryBuilder
     * as the expression will contain user.name
     *
     * @param QueryBuilder $builder
     * @param string $root
     * @return void
     */
    public function addAlias(QueryBuilder $builder, $root);

    /**
     * Returns the alias of the entity where the filter is applied on
     * When this function returns null, the root alias is assumed
     *
     * eg OrderStatusFilter :
     *
     * Filters for example on a customer element that has an order object that in turn has a status
     * In this case the root alias could be root (representing the customer object)
     * The alias would be 'order' representing the relation as root.order
     *
     * The query would be be for example ;
     *
     * SELECT Entity\Customer root JOIN root.order order WHERE order.status = :status
     * $resolver->resolve([OrderStatusFilter('some-status')], $queryBuilder);
     *
     * @return string|null
     */
    public function getAlias();

    /**
     * Returns the parameter that the filter is using, wrapped in a Literal expression
     *
     * @return mixed
     */
    public function getParameter();
}
