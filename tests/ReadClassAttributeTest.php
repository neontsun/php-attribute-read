<?php

declare(strict_types = 1);

namespace Neontsun\ReadAttribute\Tests;

use Neontsun\ReadAttribute\Exception\NotContainException;
use Neontsun\ReadAttribute\Exception\NotSupportException;
use Neontsun\ReadAttribute\Exception\UnexpectedTypeException;
use Neontsun\ReadAttribute\ReadAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\Attribute\FirstTestAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\Attribute\SecondTestAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\ClassWithMultiplyAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\ClassWithOneSingleAndTwoMultiplyAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\ClassWithoutAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\ClassWithSingleAttribute;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class ReadClassAttributeTest extends TestCase
{
    use ReadAttribute;

    /**
     * @throws NotContainException
     * @throws NotSupportException
     * @throws UnexpectedTypeException
     * @throws Exception
     * @throws ExpectationFailedException
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function testSuccessReadSingleAttribute(): void
    {
        $attribute = $this->readClassAttribute(ClassWithSingleAttribute::class, FirstTestAttribute::class);

        $this->assertInstanceOf(FirstTestAttribute::class, $attribute);
    }

    /**
     * @throws Exception
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws NotContainException
     * @throws NotSupportException
     * @throws ReflectionException
     * @throws UnexpectedTypeException
     */
    public function testSuccessReadMultiplyAttributes(): void
    {
        $attributes = $this->readClassAttribute(ClassWithMultiplyAttribute::class, SecondTestAttribute::class, true);
		
        $this->assertCount(5, $attributes);

        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(SecondTestAttribute::class, $attribute);
        }
    }

    /**
     * @throws Exception
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws NotContainException
     * @throws NotSupportException
     * @throws ReflectionException
     * @throws UnexpectedTypeException
     */
    public function testSuccessReadSingleAndMultiplyAttributesFromClass(): void
    {
        $firstAttribute = $this->readClassAttribute(ClassWithOneSingleAndTwoMultiplyAttribute::class, FirstTestAttribute::class);
        $secondAttributes = $this->readClassAttribute(ClassWithOneSingleAndTwoMultiplyAttribute::class, SecondTestAttribute::class, true);

        $this->assertInstanceOf(FirstTestAttribute::class, $firstAttribute);
        $this->assertCount(2, $secondAttributes);

        foreach ($secondAttributes as $attribute) {
            $this->assertInstanceOf(SecondTestAttribute::class, $attribute);
        }
    }

    /**
     * @throws Exception
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws NotContainException
     * @throws NotSupportException
     * @throws ReflectionException
     * @throws UnexpectedTypeException
     */
    public function testSuccessReadSingleAttributeWithMultiplyFlag(): void
    {
        $attributes = $this->readClassAttribute(ClassWithSingleAttribute::class, FirstTestAttribute::class, true);
		
        $this->assertCount(1, $attributes);

        $this->assertInstanceOf(FirstTestAttribute::class, $attributes[0]);
    }

    /**
     * @throws NotContainException
     * @throws NotSupportException
     * @throws ReflectionException
     * @throws UnexpectedTypeException
     */
    public function testReadSingleAttributeFromClassWithoutAttributes(): void
    {
        $this->expectException(NotContainException::class);

        $this->readClassAttribute(ClassWithoutAttribute::class, FirstTestAttribute::class);
    }

    /**
     * @throws NotContainException
     * @throws NotSupportException
     * @throws ReflectionException
     * @throws UnexpectedTypeException
     */
    public function testReadMultiplyAttributeFromClassWithoutAttributes(): void
    {
        $this->expectException(NotContainException::class);

        $this->readClassAttribute(ClassWithoutAttribute::class, SecondTestAttribute::class, true);
    }

    /**
     * @throws NotContainException
     * @throws NotSupportException
     * @throws ReflectionException
     * @throws UnexpectedTypeException
     */
    public function testReadRepeatableAttributeWithoutMultiply(): void
    {
        $this->expectException(NotSupportException::class);

        $this->readClassAttribute(ClassWithMultiplyAttribute::class, SecondTestAttribute::class);
    }
}
