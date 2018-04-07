<?php

namespace CategoriesBundle\Service\TreeHandler;

use \RecursiveIteratorIterator;
use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Service\Transformer\CategoryTransformer;

class TreeGeneratorService
{
    /**
     * @var CategoryTransformer
     */
    private $transformer;

    /**
     * @param CategoryTransformer $transformer
     */
    public function __construct(CategoryTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param RecursiveIteratorIterator $categories
     * @param bool $hasParent
     * @return TreeDto
     */
    public function createTree(
        RecursiveIteratorIterator $categories,
        bool $hasParent = true
    ): TreeDto {
        $treeDto = new TreeDto();

        foreach ($categories as $category) {
            $depth = $categories->getDepth();

            if (false == $hasParent && $depth == 0) {
                continue;
            }

            if (empty($category)) {
                continue;
            }

            $treeDto->addCategory(
                $this->transformer->transform(
                    $category,
                    $depth
                )
            );
        }

        return $treeDto;
    }
}
