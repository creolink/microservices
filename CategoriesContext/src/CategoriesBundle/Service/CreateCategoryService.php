<?php

namespace CategoriesBundle\Service;

use CategoriesBundle\Exception\SaveCategoryException;
use CategoriesBundle\Validator\JsonSchemaValidatorInterface;
use CategoriesBundle\Repository\CategoryRepositoryInterface;
use CategoriesBundle\Entity\Category;
use JMS\Serializer\SerializerInterface;
use CategoriesBundle\DataObject\CategoryDto;
use CategoriesBundle\Service\Transformer\CategoryTransformer;
use CategoriesBundle\Exception\InvalidCategoryDataException;
use CategoriesBundle\Exception\InvalidJsonDataException;
use Doctrine\ORM\ORMException;

class CreateCategoryService
{
    /**
     * @var JsonSchemaValidatorInterface
     */
    private $jsonSchemaValidator;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $repository;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var CategoryTransformer
     */
    private $transformer;

    /**
     * @param JsonSchemaValidatorInterface $jsonSchemaValidator
     * @param CategoryRepositoryInterface $repository
     * @param CategoryTransformer $transformer
     * @param SerializerInterface $serializer
     */
    public function __construct(
        JsonSchemaValidatorInterface $jsonSchemaValidator,
        CategoryRepositoryInterface $repository,
        CategoryTransformer $transformer,
        SerializerInterface $serializer
    ) {
        $this->jsonSchemaValidator = $jsonSchemaValidator;
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->transformer = $transformer;
    }

    /**
     * @param string|null $content
     * @return Category
     *
     * @throws InvalidCategoryDataException
     * @throws InvalidJsonDataException
     * @throws SaveCategoryException
     */
    public function createCategory(string $content = null): Category
    {
        if ($this->jsonSchemaValidator->validate($content)) {
            $categoryDto = $this->removeTags(
                $this->createCategoryDto($content)
            );

            $this->validateSlug($categoryDto);
            $this->validateName($categoryDto);

            $category = $this->transformer->reverseTransform(
                $categoryDto,
                $this->getParentCategory($categoryDto)
            );

            try {
                return $this->repository->save($category);
            } catch (ORMException $exception) {
                throw new SaveCategoryException(
                    sprintf(
                        "Parent category `%s` does not exists!",
                        $categoryDto->getParentCategory()
                    )
                );
            }
        }
    }

    /**
     * @param CategoryDto $categoryDto
     * @return Category|null
     *
     * @throws InvalidCategoryDataException
     */
    private function getParentCategory(CategoryDto $categoryDto): ?Category
    {
        if (!empty($categoryDto->getParentCategory())) {
            $parentCategory = $this->repository->findOneById(
                $categoryDto->getParentCategory()
            );

            if (empty($parentCategory)) {
                throw new InvalidCategoryDataException(
                    sprintf(
                        "Parent category `%s` does not exists!",
                        $categoryDto->getParentCategory()
                    )
                );
            }

            return $parentCategory;
        }

        return null;
    }

    /**
     * @param string $data
     * @return CategoryDto|object
     */
    private function createCategoryDto(string $data): CategoryDto
    {
        return $this->serializer->deserialize($data, CategoryDto::class, 'json');
    }

    /**
     * @param CategoryDto $categoryDto
     * @return CategoryDto
     */
    private function removeTags(CategoryDto $categoryDto): CategoryDto
    {
        return $categoryDto->setName(
            strip_tags(
                $categoryDto->getName()
            )
        );
    }

    /**
     * @param CategoryDto $categoryDto
     * @return void
     *
     * @throws InvalidCategoryDataException
     */
    private function validateName(CategoryDto $categoryDto): void
    {
        if (empty($categoryDto->getName())) {
            throw new InvalidCategoryDataException(
                "Category name contains invalid signs or is empty!"
            );
        }
    }

    /**
     * @param CategoryDto $categoryDto
     * @return void
     *
     * @throws InvalidCategoryDataException
     */
    private function validateSlug(CategoryDto $categoryDto): void
    {
        $category = $this->repository->findOneBySlug(
            $categoryDto->getSlug()
        );

        if (!empty($category)) {
            throw new InvalidCategoryDataException(
                sprintf(
                    "Category with slug `%s` already exists!",
                    $categoryDto->getSlug()
                )
            );
        }
    }
}
