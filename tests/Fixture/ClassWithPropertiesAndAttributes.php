<?php

declare(strict_types = 1);

namespace Neontsun\ReadAttribute\Tests\Fixture;

use Neontsun\ReadAttribute\Tests\Fixture\Attribute\FirstPropertyAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\Attribute\SecondPropertyAttribute;

final class ClassWithPropertiesAndAttributes
{
    #[FirstPropertyAttribute]
    private string $firstProperty;

    #[FirstPropertyAttribute]
    private string $secondProperty;

    #[SecondPropertyAttribute]
    private string $thirdProperty;
}
