<?php

namespace CategoriesBundle\Service;

use CategoriesBundle\Exception\CategoryNotFoundException;
use CategoriesBundle\Entity\Category;
use CategoriesBundle\Repository\CategoryRepositoryInterface;

class CategoryDataService
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $repository;

    /**
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function getCategoryById(string $id): Category
    {
        $category = $this->repository->findOneById($id);

        if (empty($category)) {
            throw new CategoryNotFoundException(
                $this->createErrorMessage($id)
            );
        }

        return $category;
    }

    /**
     * @param string $slug
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function getCategoryBySlug(string $slug): Category
    {
        $category = $this->repository->findOneBySlug($slug);

        if (empty($category)) {
            throw new CategoryNotFoundException(
                $this->createErrorMessage($slug)
            );
        }

        return $category;
    }

    /**
     * @param string $category
     * @return string
     */
    private function createErrorMessage(string $category): string
    {
        return sprintf(
            "Category `%s `not found",
            $category
        );
    }
}
