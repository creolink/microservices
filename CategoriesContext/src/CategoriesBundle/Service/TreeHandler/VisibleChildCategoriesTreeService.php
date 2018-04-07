<?php

namespace CategoriesBundle\Service\TreeHandler;

use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Exception\CategoryNotFoundException;

class VisibleChildCategoriesTreeService extends AbstractCategoriesTreeService
{
    /**
     * {@inheritDoc}
     */
    public function getTree(string $slug = null): TreeDto
    {
        $categories = $this->repository->findBySlug($slug);

        if (empty($categories)) {
            throw new CategoryNotFoundException(
                sprintf(
                    "Category `%s` not found",
                    $slug
                )
            );
        }

        return $this->createTree(
            $this->categoryIteratorService->getIteratedCategories(
                $categories,
                true
            ),
            false
        );
    }
}
