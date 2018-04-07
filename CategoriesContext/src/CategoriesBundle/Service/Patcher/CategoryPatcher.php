<?php

namespace CategoriesBundle\Service\Patcher;

use Rs\Json\Patch;
use Rs\Json\Patch\FailedTestException;
use Rs\Json\Patch\InvalidOperationException;
use Rs\Json\Patch\InvalidPatchDocumentJsonException;
use Rs\Json\Patch\InvalidTargetDocumentJsonException;
use CategoriesBundle\Exception\CategoryPatchException;
use Rs\Json\Patch\Operations\Replace;

class CategoryPatcher implements DocumentPatcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function patchDocument(string $id, string $json, string $content): string
    {
        try {
            $patch = new Patch($json, $content, Replace::APPLY);

            return $patch->apply();
        } catch (FailedTestException | InvalidOperationException | InvalidPatchDocumentJsonException | InvalidTargetDocumentJsonException $exception) {
            throw new CategoryPatchException(
                sprintf(
                    "Category `%s` cannot be patched",
                    $id
                )
            );
        }
    }
}
