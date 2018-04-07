<?php

namespace CategoriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @AccessType("public_method")
 *
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * @Type("string")
     * @var string
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @Type("boolean")
     * @SerializedName("isVisible")
     * @var bool
     *
     * @ORM\Column(name="is_visible", type="boolean")
     */
    private $isVisible;

    /**
     * @Type("array<CategoriesBundle\Entity\Category>")
     * @var Category[]
     *
     * @ORM\OneToMany(targetEntity="CategoriesBundle\Entity\Category", mappedBy="parentCategory")
     **/
    private $children;

    /**
     * @Type("CategoriesBundle\Entity\Category")
     * @SerializedName("parentCategory")
     * @var Category|null
     *
     * @ORM\ManyToOne(targetEntity="CategoriesBundle\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
    private $parentCategory;

    /**
     * @Type("string")
     * @var string
     *
     * @ORM\Column(type="string", length=48)
     */
    private $slug;

    /**
     * @Type("string")
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Category constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param bool $isVisible
     *
     * @return self
     */
    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsVisible(): bool
    {
        return $this->isVisible;
    }

    /**
     * @return Category[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Category[] $children
     *
     * @return self
     */
    public function setChildren($children): self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getParentCategory(): ?Category
    {
        return $this->parentCategory;
    }

    /**
     * @param Category|null $parentCategory
     *
     * @return self
     */
    public function setParentCategory(Category $parentCategory = null): self
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
