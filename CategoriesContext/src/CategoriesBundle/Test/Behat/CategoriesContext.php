<?php

namespace CategoriesBundle\Test\Behat;

use Knp\FriendlyContexts\Context\MinkContext;
use Behat\Mink\Exception\ExpectationException;
use Behat\Gherkin\Node\TableNode;

class CategoriesContext extends MinkContext
{
    /**
     * @Then the :header response header is :value
     *
     * @param string $header
     * @param string $value
     * @throws ExpectationException
     */
    public function headerContains(string $header, string $value)
    {
        $headerValue = $this->getSession()->getResponseHeader($header);

        $this->assert(
            $headerValue == $value,
            sprintf(
                "The element `%s` is not equal to `%s`!",
                $value,
                $headerValue
            )
        );
    }

    /**
     * @Then Json response contains categories
     *
     * @throws ExpectationException
     */
    public function responseContainsCategories()
    {
        $jsonContent = $this->getJsonCategories();

        $this->assert(
            !empty($jsonContent->categories),
            "The categories tree is empty!"
        );
    }

    /**
     * @Then Json response contains categories:
     *
     * @param TableNode $table
     * @throws ExpectationException
     */
    public function jsonResponseContainsCategories(TableNode $table)
    {
        $categories = $this->getCategories($table);

        foreach ($categories as $id => $isValid) {
            $this->assert(
                $isValid,
                sprintf(
                    "Category `%s` does not exists in response!",
                    $id
                )
            );
        }
    }

    /**
     * @Then Json response does not contain categories:
     *
     * @param TableNode $table
     * @throws ExpectationException
     */
    public function jsonResponseDoesNotContainCategories(TableNode $table)
    {
        $categories = $this->getCategories($table);

        foreach ($categories as $id => $isValid) {
            $this->assert(
                !$isValid,
                sprintf(
                    "Category `%s` shouldn't exist in response!",
                    $id
                )
            );
        }
    }

    /**
     * @param TableNode $table
     * @return array
     */
    private function getCategories(TableNode $table): array
    {
        $jsonContent = $this->getJsonCategories();

        $categories = [];

        foreach ($table->getHash() as $row) {
            $categories[$row['id']] = false;

            foreach ($jsonContent->categories as $category) {
                if ($category->id === $row['id']) {
                    $categories[$row['id']] = true;
                }
            }
        }

        return $categories;
    }

    /**
     * @return object
     */
    private function getJsonCategories(): object
    {
        return json_decode(
            $this->getContent()
        );
    }

    /**
     * @return string
     */
    private function getContent(): string
    {
        return $this->getSession()->getPage()->getContent();
    }

    /**
     * @param bool $test
     * @param string $message
     * @throws ExpectationException
     */
    private function assert(bool $test, string $message): void
    {
        if ($test === false) {
            throw new ExpectationException($message, $this->getSession()->getDriver());
        }
    }
}
