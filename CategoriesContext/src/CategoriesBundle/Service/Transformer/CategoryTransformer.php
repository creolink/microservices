<?php

namespace CategoriesBundle\Service\Transformer;

use CategoriesBundle\Entity\Category;
use CategoriesBundle\DataObject\CategoryDto;

class CategoryTransformer
{
    /**
     * @param Category $category
     * @param int $depth
     * @return CategoryDto
     */
    public function transform(Category $category, int $depth = 0): CategoryDto
    {
        $categoryDto = new CategoryDto();

        $categoryDto->setId($category->getId());
        $categoryDto->setIsVisible($category->getIsVisible());
        $categoryDto->setName($category->getName());
        $categoryDto->setSlug($category->getSlug());
        $categoryDto->setDepth($depth);

        return $categoryDto;
    }

    /**
     * @param CategoryDto $categoryDto
     * @param Category|null $parentCategory
     * @return Category
     */
    public function reverseTransform(CategoryDto $categoryDto, Category $parentCategory = null): Category
    {
        $category = new Category();

        $category->setIsVisible($categoryDto->getIsVisible());
        $category->setName($categoryDto->getName());
        $category->setSlug($categoryDto->getSlug());
        $category->setParentCategory($parentCategory);
        $category->setId($categoryDto->getId());

        return $category;
    }
}
