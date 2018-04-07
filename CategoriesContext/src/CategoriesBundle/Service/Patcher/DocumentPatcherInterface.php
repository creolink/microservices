<?php

namespace CategoriesBundle\Service\Patcher;

use CategoriesBundle\Exception\DocumentPatchException;

interface DocumentPatcherInterface
{
    /**
     * @param string $id
     * @param string $json
     * @param string $content
     * @return string
     * @throws DocumentPatchException
     */
    public function patchDocument(string $id, string $json, string $content): string;
}
