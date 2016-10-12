<?php

namespace Avdb\DoctrineExtra\Exception;

class EntityNotFoundException extends \Doctrine\ORM\EntityNotFoundException
{
    /**
     * @param string $class
     * @param string $param
     * @param string $identifier
     * @return EntityNotFoundException
     */
    public static function fromEntity($class, $param, $identifier  = 'id')
    {
        return new self(sprintf('Entity %s with %s \'%s\' was not found', $class, $identifier, $param));
    }
}
