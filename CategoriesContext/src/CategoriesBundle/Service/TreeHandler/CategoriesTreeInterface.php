<?php

namespace CategoriesBundle\Service\TreeHandler;

use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Exception\CategoryNotFoundException;

interface CategoriesTreeInterface
{
    /**
     * @param string|null $slug
     * @return TreeDto
     * @throws CategoryNotFoundException
     */
    public function getTree(string $slug = null): TreeDto;
}
