#Doctrine Extra's

## 1. Filters
Create Filter objects to easily filter your repository.
This package contains two default Filter objects to use ; 'AggregateFilter' and 'PropertyFilter'. Both are multipurpose
but is is recommended to extend the AbstractFilter and create your own.

The filtering itself can be done by any class that uses the Resolver trait, and uses the Doctrine QueryBuilder object as
 a starting point.

Lets take the following example ;

```
class OrderRepository extends \Doctrine\ORM\EntityRepository
{
    /** Resolves filters **/
    use Resolver;

    public function filter($filters)
    {
        $builder = $this->createQueryBuilder('root');

        return $this->resolve($filters, $builder)->getQuery()->getResult();
    }
}
```

We have an OrderRepository that implements the Resolver trait, and has a method "filter" that accepts an array of
Doctrine Filters or one DoctrineFilter.

#### Using the PropertyFilter
The property filter can be used to filter on any entity's property. Lets Imagine an order has a "category" property,
we want to filter on.

```
/**
 * @var OrderRepository
 */
private $repository;

public function categoryAction($category)
{
    $orders = $this->repository->filter(new PropertyFilter($category, 'category'));
}
```

By now we have filtered orders for a certain category. We can also pass multiple filters as an array into the filter()
method as an argument, they will all be combined in an andX expression.


#### Using the AggregateFilter
In case we want to use multiple filters in an orX expression, we can use the AggregateFilter. In the following example
we will filter all 'new' or 'finished' orders;

```
$orders = $this->repository->filter(
    new AggregateFilter([new StatusFilter('new'),new StatusFilter('finished')]
));
```

We can combine multiple AggregateFilters to make a more complex expression. In the following example we will filter all
'new' or 'finished' orders that have 'multimedia' or 'books' as a category

```
$orders = $this->repository->filter(
    new AggregateFilter([new StatusFilter('new'), new StatusFilter('finished')]),
    new AggregateFilter([new CategoryFilter('multimedia'), new CategoryFilter('books')])
);
```

### Creating a custom DoctrineFilter

#### Simple property filter
We can also implement CategoryFilter if more entities have category as a property and we want to use it often.

If we want to create our own CategoryFilter, which is the most basic form of filtering by filtering on a single direct
property we can do it this way ;

```
class CategoryFilter extends AbstractFilter
{
    public function createExpression($root)
    {
        return $this->expr()->eq(
            sprintf('%s.category', $root),
            $this->expr()->literal($this->parameter)
        );
    }
}
```

We only need to implement the __CreateExpression()__ method, and create a simple __expression that will be used
in the Where clause in the QueryBuilder__. Now this filter can be usd on all entities with the "category" property.

Sometimes we will need a more complex filter. Assume our Order entity has a relationship with User, and User has a
username. We want to filter all orders by a user's username. We can create the following filter ;

#### More advanced example

```
class UserEmailFilter extends AbstractFilter
{
    public function createExpression($root)
    {
        return $this->expr()->eq('user.email', $this->expr()->literal($this->parameter));
    }

    public function getAlias()
    {
        return 'user';
    }

    public function addAlias(QueryBuilder $builder, $root)
    {
       $builder->leftJoin(sprintf('%s.user', $root), 'user');
    }
}
```

This Filter is a bit more complex. Since we are not filtering a direct property of Order, but instead filter on a
property of User which has a association with our Order object, we need to implement two more methods.

The function __getAlias()__ will return a string, the alias defines the object's alias that has the property
we are filtering on. In this case its __'user' because we will filter on user.email__.

The __AddAlias()__ method will be triggered by the Resolver when it checks if the 'user' alias is present in the
QueryBuilder, an alias is present when it is OR selected OR joined. In this case we __Left join our User object to our
'root' object__, in this example 'Order'.

Now we have finished our UserEmailFilter, we can use this filter on any object that has User as a relation. We can
for example have a Reservation entity and a Ticket entity that both have an association with User.

So by now we can do the following ;

```
$reservations = $this->reservationRepository->filter(new UserUsernameFilter('example@doctrine.com'));
$orders = $this->orderRepository->filter(new UserUsernameFilter('example@doctrine.com'));
$tickets = $this->ticketRepository->filter(new UserUSernameFilter('example@doctrine.com'));
```
