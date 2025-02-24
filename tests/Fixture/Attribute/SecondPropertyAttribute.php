<?php

declare(strict_types = 1);

namespace Neontsun\ReadAttribute\Tests\Fixture\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class SecondPropertyAttribute {}
