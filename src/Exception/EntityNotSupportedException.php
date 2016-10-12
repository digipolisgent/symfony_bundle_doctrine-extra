<?php

namespace Avdb\DoctrineExtra\Exception;

class EntityNotSupportedException extends ManagerException
{
    /**
     * @param $class
     * @param $supports
     * @return EntityNotSupportedException
     */
    public static function fromClass($class, $supports)
    {
        return new self(
            sprintf('Entity %s is not supported by this Manager, expected %s', $class, $supports)
        );
    }
}
