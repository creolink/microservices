<?php

namespace CategoriesBundle\Validator;

use Symfony\Component\Config\FileLocatorInterface;
use JsonSchema\Validator;
use JsonSchema\Exception\InvalidSchemaException;
use \InvalidArgumentException;
use CategoriesBundle\Exception\InvalidJsonDataException;

class JsonSchemaValidator implements JsonSchemaValidatorInterface
{
    /**
     * @var FileLocatorInterface
     */
    protected $fileLocator;

    /**
     * @var string
     */
    protected $schema;

    /**
     * @param FileLocatorInterface $fileLocator
     * @param string $schema
     */
    public function __construct(FileLocatorInterface $fileLocator, string $schema)
    {
        $this->fileLocator = $fileLocator;
        $this->schema = $schema;
    }

    /**
     * {@inheritDoc}
     */
    public function validate(string $content = null): bool
    {
        if (empty($content)) {
            throw new InvalidJsonDataException("No data in content");
        }

        $json = json_decode($content);

        $validator = new Validator();
        $validator->validate(
            $json,
            json_decode($this->loadSchema())
        );

        if ($validator->isValid()) {
            return true;
        } else {
            $errors = [];

            $errors[] = 'JSON does not validate. Violations:';
            foreach ($validator->getErrors() as $error) {
                $errors[] = sprintf('[%s] %s', $error['property'], $error['message']);
            }

            throw new InvalidJsonDataException(json_encode($errors));
        }
    }

    /**
     * @return string
     * @throws InvalidSchemaException
     */
    private function loadSchema(): string
    {
        try {
            return file_get_contents(
                $this->fileLocator->locate($this->schema)
            );
        } catch (InvalidArgumentException $exception) {
            throw new InvalidSchemaException(
                sprintf(
                    "Schema file `%s` does not exists!",
                    $this->schema
                )
            );
        }
    }
}
