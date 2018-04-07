<?php

namespace CategoriesBundle\Validator;

use CategoriesBundle\Exception\InvalidJsonDataException;

interface JsonSchemaValidatorInterface
{
    /**
     * @param string|null $content
     * @return bool
     * @throws InvalidJsonDataException
     */
    public function validate(string $content = null): bool;
}
