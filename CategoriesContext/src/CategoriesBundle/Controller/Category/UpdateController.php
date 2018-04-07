<?php

namespace CategoriesBundle\Controller\Category;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Patch;
use CategoriesBundle\Service\EditCategoryService;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use CategoriesBundle\Exception\CategoryNotFoundException;
use CategoriesBundle\Exception\CategoryHttpException;
use CategoriesBundle\Exception\InvalidJsonDataException;
use CategoriesBundle\Entity\Category;
use CategoriesBundle\Exception\DocumentPatchException;

class UpdateController extends FOSRestController
{
    /**
     * @Patch("/api/category/id/{id}")
     *
     * @SWG\Tag(name="Category controller")
     * @SWG\Response(
     *  response=200, description="Returned with successful updated category visibility",
     *  @Model(type=Category::class)
     * )
     * @SWG\Response(
     *  response=400, description="Returned when there is error in input data"
     * )
     * @SWG\Response(
     *  response=404, description="Returned when category is not found"
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
     * @SWG\Parameter(
     *  name="Category",
     *  in="body",
     *  required=true,
     *  description="Category data",
     *  @SWG\Schema(
     *   type="array", title="Operation",
     *   @SWG\Items(
     *    @SWG\Property(
     *     property="op",
     *     type="string",
     *     description="operation, required, allowed `replace` only",
     *     pattern="replace"
     *    ),
     *    @SWG\Property(
     *     property="path",
     *     type="string",
     *     description="parameter to update, required, allowed `/isVisible` only",
     *     pattern="/isVisible"
     *    ),
     *    @SWG\Property(
     *     property="value",
     *     type="boolean",
     *     description="value of parameter, required, `true` or `false` are allowed",
     *     pattern="`true` or `false`"
     *    )
     *   )
     *  )
     * )
     *
     * @param Request $request
     * @param string $id
     * @return Category
     * @throws CategoryHttpException
     */
    public function patchCategoryAction(Request $request, string $id): Category
    {
        try {
            return $this->getEditCategoryService()
                ->patchVisibility($id, $request->getContent());
        } catch (CategoryNotFoundException | InvalidJsonDataException | DocumentPatchException $exception) {
            throw new CategoryHttpException(
                $exception->getCode(),
                $exception->getMessage()
            );
        }
    }

    /**
     * @return EditCategoryService|object
     */
    private function getEditCategoryService(): EditCategoryService
    {
        return $this->get('categories.service.editCategory');
    }
}
