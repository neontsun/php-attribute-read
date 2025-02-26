<?php

declare(strict_types = 1);

namespace Neontsun\ReadAttribute;

use Neontsun\ReadAttribute\Exception\NotContainException;
use Neontsun\ReadAttribute\Exception\NotSupportException;
use Neontsun\ReadAttribute\Exception\UnexpectedTypeException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

use function count;
use function is_string;
use function sprintf;

trait ReadAttribute
{
	/**
	 * @template T of object
	 * @param class-string|object $value
	 * @param class-string<T> $attribute
	 * @throws ReflectionException
	 */
	public function hasClassAttribute(object|string $value, string $attribute): bool
	{
		$attributes = (new ReflectionClass($value))->getAttributes($attribute, ReflectionAttribute::IS_INSTANCEOF);
		
		return [] !== $attributes;
	}
	
    /**
     * @template T of object
     * @param class-string|object $value
     * @param class-string<T> $attribute
     * @return ($allowMultiply is true ? list<T> : T)
     * @throws NotSupportException
     * @throws ReflectionException
     * @throws NotContainException
     * @throws UnexpectedTypeException
     */
    public function readClassAttribute(object|string $value, string $attribute, bool $allowMultiply = false)
    {
        $attributes = (new ReflectionClass($value))->getAttributes($attribute, ReflectionAttribute::IS_INSTANCEOF);

        if ([] === $attributes) {
            throw new NotContainException(
                sprintf(
                    'The %s attribute is not registered in class %s',
                    is_string($value) ? $value : $value::class,
                    $attribute,
                ),
            );
        }

        if (! $allowMultiply && count($attributes) > 1) {
            throw new NotSupportException(sprintf('Declaring more than one %s attribute is not supported', $attribute));
        }

        if (! $allowMultiply) {
            $reflectionAttribute = $attributes[0];

            $attributeInstance = $reflectionAttribute->newInstance();

            if (! $attributeInstance instanceof $attribute) {
                throw new UnexpectedTypeException($attribute, $attributeInstance);
            }

            return $attributeInstance;
        }

        $instances = [];

        foreach ($attributes as $reflectionAttribute) {
            $attributeInstance = $reflectionAttribute->newInstance();

            if (! $attributeInstance instanceof $attribute) {
                throw new UnexpectedTypeException($attribute, $attributeInstance);
            }

            $instances[] = $attributeInstance;
        }

        return $instances;
    }

    /**
     * @param class-string|object $value
     * @param iterable<non-empty-string> $properties
     * @param class-string $attribute
     * @throws ReflectionException
     */
    public function propertiesHaveAnAttribute(object|string $value, iterable $properties, string $attribute): bool
    {
        if ([] === $properties) {
            return false;
        }

        $reflectionClass = new ReflectionClass($value);

        foreach ($properties as $property) {
            $reflectionProperty = $reflectionClass->getProperty($property);

            if ([] === $reflectionProperty->getAttributes($attribute, ReflectionAttribute::IS_INSTANCEOF)) {
                return false;
            }
        }

        return true;
    }
}
