<?php

namespace CategoriesBundle\Exception;

class CategoryNotFoundException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
