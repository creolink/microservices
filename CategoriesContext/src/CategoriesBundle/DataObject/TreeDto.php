<?php

namespace CategoriesBundle\DataObject;

use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\Type;

/**
 * @AccessType("public_method")
 */
class TreeDto
{
    /**
     * @Type("array<CategoriesBundle\DataObject\CategoryDto>")
     *
     * @var CategoryDto[]|null
     **/
    private $categories;

    /**
     * @return CategoryDto[]|null
     */
    public function getCategories(): ?array
    {
        return $this->categories;
    }

    /**
     * @param CategoryDto[]|null $categories
     *
     * @return self
     */
    public function setCategories(?array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param CategoryDto $category
     *
     * @return self
     */
    public function addCategory(CategoryDto $category): self
    {
        $this->categories[] = $category;

        return $this;
    }
}
