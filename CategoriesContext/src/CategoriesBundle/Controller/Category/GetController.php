<?php

namespace CategoriesBundle\Controller\Category;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use CategoriesBundle\Entity\Category;
use CategoriesBundle\Exception\CategoryHttpException;
use CategoriesBundle\Exception\CategoryNotFoundException;
use CategoriesBundle\Service\CategoryDataService;

class GetController extends FOSRestController
{
    /**
     * @Get("/api/category/{slug}")
     *
     * @SWG\Tag(name="Category controller")
     * @SWG\Response(
     *  response=200, description="Returned with successful request for category by `slug` value",
     *  @Model(type=Category::class)
     * )
     * @SWG\Response(
     *  response=400, description="Returned when there is error in input data"
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
     *  description="Slug of category to get its data"
     * )
     *
     * @param string $slug
     * @return Category
     * @throws CategoryHttpException
     */
    public function getCategoryBySlugAction(string $slug): Category
    {
        try {
            return $this->getCategoryDataService()
                ->getCategoryBySlug($slug);
        } catch (CategoryNotFoundException $exception) {
            throw new CategoryHttpException(
                $exception->getCode(),
                $exception->getMessage()
            );
        }
    }

    /**
     * @Get("/api/category/id/{id}")
     *
     * @SWG\Tag(name="Category controller")
     * @SWG\Response(
     *  response=200, description="Returned with succesful request for category by `id` value",
     *  @Model(type=Category::class)
     * )
     * @SWG\Response(
     *  response=400, description="Returned when there is error in input data"
     * )
     * @SWG\Response(
     *  response=404, description="Returned when category is not found or `id` is empty"
     * )
     * @SWG\Response(
     *  response=500, description="Returned when any internal server error occurs"
     * )
     * @SWG\Parameter(
     *  name="id",
     *  in="path",
     *  type="string",
     *  description="UUID of category to get its data, format xxxxxxxx-xxxx-Mxxx-Nxxx-xxxxxxxxxxxx"
     * )
     *
     * @param string $id
     * @return Category
     * @throws CategoryHttpException
     */
    public function getCategoryByIdAction(string $id): Category
    {
        try {
            return $this->getCategoryDataService()
                ->getCategoryById($id);
        } catch (CategoryNotFoundException $exception) {
            throw new CategoryHttpException(
                $exception->getCode(),
                $exception->getMessage()
            );
        }
    }

    /**
     * @return CategoryDataService|object
     */
    private function getCategoryDataService(): CategoryDataService
    {
        return $this->get('categories.service.categoryData');
    }
}
