<?php

namespace CategoriesBundle\Test\Unit\Traits;

use CategoriesBundle\Entity\Category;
use CategoriesBundle\Test\Unit\Fixtures\Exception\FixtureNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;

trait FixturesTrait
{
    /**
     * @param string $fixture
     * @return array
     * @throws FixtureNotFoundException
     */
    protected function loadFixture(string $fixture): array
    {
        if (empty($fixture)) {
            throw new FixtureNotFoundException("Provide fixture file");
        }

        return json_decode(
            file_get_contents(
                FixturesInterface::FIXTURES_PATH . $fixture
            )
        );
    }

    /**
     * @param array $objects
     * @param Category $parentCategory
     * @return Category[]
     */
    private function createCategories(array $objects = null, Category &$parentCategory = null)
    {
        $categories = [];

        foreach ($objects as $object) {
            $category = new Category();

            $category->setIsVisible($object->isVisible);
            $category->setName($object->name);
            $category->setSlug($object->slug);
            $category->setId($object->id);

            if (!empty($parentCategory)) {
                $category->setParentCategory($parentCategory);
            }

            if (!empty($object->children)) {
                $category->setChildren(
                    new ArrayCollection(
                        $this->createCategories($object->children, $category)
                    )
                );
            }

            $categories[] = $category;
        }

        return $categories;
    }
}