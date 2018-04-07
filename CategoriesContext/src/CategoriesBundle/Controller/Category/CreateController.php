<?php

namespace CategoriesBundle\Controller\Category;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Post;
use CategoriesBundle\Service\CreateCategoryService;
use Symfony\Component\HttpFoundation\Request;
use CategoriesBundle\Exception\CategoryHttpException;
use CategoriesBundle\Exception\InvalidCategoryDataException;
use CategoriesBundle\Exception\InvalidJsonDataException;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use CategoriesBundle\Entity\Category;
use CategoriesBundle\Exception\SaveCategoryException;

class CreateController extends FOSRestController
{
    /**
     * @Post("/api/category")
     *
     * @SWG\Tag(name="Category controller")
     * @SWG\Response(
     *  response=200, description="Success, Returned with successful created category (with category data)",
     *  @Model(type=Category::class)
     * )
     * @SWG\Response(
     *  response=400, description="Error, Returned when there is error in input data"
     * )
     * @SWG\Response(
     *  response=500, description="Error, Returned when any internal server error occurs"
     * )
     * @SWG\Parameter(
     *  name="Category",
     *  in="body",
     *  required=true,
     *  description="Category data",
     *  @SWG\Schema(
     *   type="object", title="Category",
     *   @SWG\Property(
     *    property="parentCategory",
     *    type="string",
     *    description="id of parent category, required empty string `""""` for main category or UUID of parent category",
     *    pattern="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12} ex. `04c9cec3-230b-11e8-a938-0242c0640a02`"
     *   ),
     *   @SWG\Property(
     *    property="isVisible",
     *    type="boolean",
     *    description="visibility flag, required bool value `true` or `false`",
     *    pattern="`true` or `false`"
     *   ),
     *   @SWG\Property(
     *    property="slug",
     *    type="string",
     *    minLength=1,
     *    maxLength=40,
     *    description="slug/link of category, required string",
     *    pattern="[0-9a-zA-Z]|[-] ex. `Abcd-0129`"
     *   ),
     *   @SWG\Property(
     *    property="name",
     *    type="string",
     *    minLength=1,
     *    description="name of category, required string"
     *   ),
     *  )
     * )
     *
     * @param Request $request
     * @return Category
     * @throws CategoryHttpException
     */
    public function createCategoryAction(Request $request)
    {
        try {
            return $this->getCreateCategoryService()
                ->createCategory(
                    $request->getContent()
                );
        } catch (InvalidCategoryDataException | InvalidJsonDataException | SaveCategoryException $exception) {
            throw new CategoryHttpException(
                $exception->getCode(),
                $exception->getMessage()
            );
        }
    }

    /**
     * @return CreateCategoryService|object
     */
    private function getCreateCategoryService(): CreateCategoryService
    {
        return $this->get('categories.service.createCategory');
    }
}
