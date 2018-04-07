<?php

namespace CategoriesBundle\Repository;

use CategoriesBundle\Entity\Category;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

interface CategoryRepositoryInterface
{
    /**
     * @param string|null $id
     * @return Category|null|object
     */
    public function findOneById(string $id = null): ?Category;

    /**
     * @param string|null $slug
     * @return Category|null|object
     */
    public function findOneBySlug(string $slug = null): ?Category;

    /**
     * @param string|null $parentId
     * @return Category[]
     */
    public function findByParent(string $parentId = null): array;

    /**
     * @param string|null $slug
     * @return Category[]
     */
    public function findBySlug(string $slug = null): ?array;

    /**
     * @param Category $category
     * @return Category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Category $category): Category;

    /**
     * @param Category $category
     * @return Category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Category $category): Category;
}
