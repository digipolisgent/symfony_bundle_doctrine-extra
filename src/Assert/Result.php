<?php

namespace Avdb\DoctrineExtra\Assert;

/**
 * Interface Result
 *
 * Different kinds of result forms
 *
 * @package Avdb\DoctrineExtra\Assert
 */
interface Result
{
    const ARRAY      = 'array';
    const PAGINATE   = 'paginated';
    const SINGLE     = 'single';
    const FIRST      = 'first';
    const ITERATE    = 'iterate';
    const COUNT      = 'count';
    const QUERY      = 'query';
    const BUILDER    = 'builder';
}
