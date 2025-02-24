<?php

declare(strict_types = 1);

namespace Neontsun\ReadAttribute\Tests\Fixture;

use Neontsun\ReadAttribute\Tests\Fixture\Attribute\FirstTestAttribute;
use Neontsun\ReadAttribute\Tests\Fixture\Attribute\SecondTestAttribute;

#[SecondTestAttribute]
#[FirstTestAttribute]
#[SecondTestAttribute]
class ClassWithOneSingleAndTwoMultiplyAttribute {}
