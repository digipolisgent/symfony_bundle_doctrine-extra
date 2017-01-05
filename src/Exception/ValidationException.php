<?php

namespace Avdb\DoctrineExtra\Exception;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \Exception
{
    /**
     * @var ConstraintViolationList
     */
    private $errors;

    /**
     * ValidationException constructor.
     *
     * @param ConstraintViolationList|ConstraintViolationListInterface $errors
     */
    public function __construct(ConstraintViolationListInterface $errors)
    {
        parent::__construct('Validation failed');
        $this->errors = $errors;
    }

    /**
     * @param bool $formatted
     * @return ConstraintViolationList
     */
    public function getErrors($formatted = true)
    {
        if (false === $formatted) {
            return $this->errors;
        }

        $errors = [];

        foreach($this->errors as $violation) {
            $errors[$violation->getPropertyPath()] =  $violation->getMessage();
        }

        return $errors;
    }
}
