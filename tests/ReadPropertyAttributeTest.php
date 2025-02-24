<?php

declare(strict_types = 1);

namespace Neontsun\ReadAttribute\Tests;

use Neontsun\ReadAttribute\ReadAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\Attribute\FirstPropertyAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\Attribute\SecondPropertyAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\ClassWithPropertiesAndAttributes;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class ReadPropertyAttributeTest extends TestCase
{
    use ReadAttribute;

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testPropertiesHaveAttribute(): void
    {
        $have = $this->propertiesHaveAnAttribute(
            ClassWithPropertiesAndAttributes::class,
            [
                'firstProperty',
                'secondProperty',
            ],
            FirstPropertyAttribute::class,
        );

        $this->assertTrue($have);
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testPropertiesDoesNotHaveAttribute(): void
    {
        $have = $this->propertiesHaveAnAttribute(
            ClassWithPropertiesAndAttributes::class,
            [
                'secondProperty',
                'thirdProperty',
            ],
            FirstPropertyAttribute::class,
        );

        $this->assertFalse($have);
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testPropertiesDoesNotHaveAttributeWithAnotherAttribute(): void
    {
        $have = $this->propertiesHaveAnAttribute(
            ClassWithPropertiesAndAttributes::class,
            [
                'firstProperty',
                'secondProperty',
                'thirdProperty',
            ],
            SecondPropertyAttribute::class,
        );

        $this->assertFalse($have);
    }
}
