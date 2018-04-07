<?php

namespace CategoriesBundle\Service\Iterator;

use Doctrine\Common\Collections\Collection;
use CategoriesBundle\Entity\Category;
use \RecursiveIterator;

class CategoryIterator implements RecursiveIterator
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var bool|null
     */
    private $isVisible = null;

    /**
     * @param Collection $collection
     * @param bool|null $isVisible
     */
    public function __construct(Collection $collection, bool $isVisible = null)
    {
        $this->collection = $collection;
        $this->isVisible = $isVisible;
    }

    /**
     * {@inheritDoc}
     */
    public function hasChildren()
    {
        $current = $this->collection->current();

        if ($current instanceof Category && !$this->isValid($current)) {
            return false;
        }

        return !$current->getChildren()
            ->isEmpty();
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {
        return new CategoryIterator(
            $this->current()->getChildren(),
            $this->isVisible
        );
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        $current = $this->collection->current();

        return $this->isValid($current) ? $current : null;
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->collection->next();
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->collection->key();
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return $this->collection->current() instanceof Category;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->collection->first();
    }

    /**
     * @param Category $current
     * @return bool
     */
    private function isValid(Category $current): bool
    {
        return isset($this->isVisible)
            ? $current->getIsVisible() == $this->isVisible
            : true;
    }
}
