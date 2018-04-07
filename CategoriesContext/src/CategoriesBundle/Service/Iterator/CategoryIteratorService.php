<?php

namespace CategoriesBundle\Service\Iterator;

use \RecursiveIteratorIterator;
use Doctrine\Common\Collections\ArrayCollection;
use CategoriesBundle\Entity\Category;

class CategoryIteratorService
{
    /**
     * @param Category[] $categories
     * @param bool|null $isVisible
     * @return RecursiveIteratorIterator|null
     */
    public function getIteratedCategories(array $categories = null, bool $isVisible = null): ?RecursiveIteratorIterator
    {
        if (empty($categories)) {
            return null;
        }

        return new RecursiveIteratorIterator(
            new CategoryIterator(
                new ArrayCollection($categories),
                $isVisible
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );
    }
}
