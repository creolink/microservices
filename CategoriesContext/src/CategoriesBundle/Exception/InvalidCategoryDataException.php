<?php

namespace CategoriesBundle\Exception;

class InvalidCategoryDataException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "", int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
