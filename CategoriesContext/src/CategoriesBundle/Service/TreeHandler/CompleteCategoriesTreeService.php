<?php

namespace CategoriesBundle\Service\TreeHandler;

use CategoriesBundle\DataObject\TreeDto;

class CompleteCategoriesTreeService extends AbstractCategoriesTreeService
{
    /**
     * {@inheritDoc}
     */
    public function getTree(string $slug = null): TreeDto
    {
        return $this->createTree(
            $this->categoryIteratorService->getIteratedCategories(
                $this->repository->findByParent()
            )
        );
    }
}
