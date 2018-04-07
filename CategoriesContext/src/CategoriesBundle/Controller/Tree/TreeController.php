<?php

namespace CategoriesBundle\Controller\Tree;

use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Service\TreeHandler\CategoriesTreeInterface;
use CategoriesBundle\Exception\CategoryNotFoundException;
use CategoriesBundle\Exception\CategoryHttpException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class TreeController extends FOSRestController
{
    /**
     * @Get("/api/tree")
     *
     * @SWG\Tag(name="Tree controller")
     * @SWG\Response(
     *  response=200, description="Returnend with full tree of all categories (including invisible positions)",
     *  @Model(type=TreeDto::class)
     * )
     * @SWG\Response(
     *  response=500, description="Returned when any internal server error occurs"
     * )
     *
     * @return TreeDto
     * @throws CategoryNotFoundException
     */
    public function getTreeAction(): TreeDto
    {
        return $this->getCompleteCategoriesTreeService()
            ->getTree();
    }

    /**
     * @Get("/api/tree/{slug}")
     *
     * @SWG\Tag(name="Tree controller")
     * @SWG\Response(
     *  response=200, description="Returned with list of parent categories in tree by `slug` value",
     *  @Model(type=TreeDto::class)
     * )
     * @SWG\Response(
     *  response=404, description="Returned when category is not found or `slug` is empty"
     * )
     * @SWG\Response(
     *  response=500, description="Returned when any internal server error occurs"
     * )
     * @SWG\Parameter(
     *  name="slug",
     *  in="path",
     *  type="string",
     *  description="Slug of category to get her child tree"
     * )
     *
     * @param string|null $slug
     * @return TreeDto
     */
    public function getTreeBySlugAction(string $slug = null): TreeDto
    {
        try {
            return $this->getVisibleChildCategoriesTreeService()
                ->getTree($slug);
        } catch (CategoryNotFoundException $exception) {
            throw new CategoryHttpException(
                $exception->getCode(),
                $exception->getMessage()
            );
        }
    }

    /**
     * @return CategoriesTreeInterface|object
     */
    private function getCompleteCategoriesTreeService(): CategoriesTreeInterface
    {
        return $this->get('categories.service.completeCategoriesTree');
    }

    /**
     * @return CategoriesTreeInterface|object
     */
    private function getVisibleChildCategoriesTreeService(): CategoriesTreeInterface
    {
        return $this->get('categories.service.visibleChildCategoriesTree');
    }
}
