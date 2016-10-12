<?php
namespace Avdb\DoctrineExtra\Manager;

use Avdb\DoctrineExtra\Exception\EntityNotFoundException;
use Avdb\DoctrineExtra\Exception\EntityNotSupportedException;

/**
 * Class EntityManager
 *
 * @package Avdb\DoctrineExtra\Manager
 */
interface Manager
{
    /**
     * Fetches an entity by id
     *
     * @param $id
     * @return null|object
     * @throws EntityNotFoundException
     */
    public function get($id);

    /**
     * @param $object
     * @throws EntityNotSupportedException
     */
    public function create($object);

    /**
     * @param $object
     * @throws EntityNotSupportedException
     */
    public function update($object);

    /**
     * @param $object
     * @throws EntityNotSupportedException
     */
    public function delete($object);

    /**
     * Entity class the Manager is supporting
     *
     * @return string
     */
    public function getClass();
}
