<?php

namespace CategoriesBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CategoryHttpException extends HttpException
{
    /**
     * @param int $statusCode
     * @param string $message
     */
    public function __construct($statusCode = 400, $message = null)
    {
        parent::__construct($statusCode, $message);
    }
}
