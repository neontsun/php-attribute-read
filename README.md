# php-attribute-read

```php

#[\Attribute(\Attribute::TARGET_CLASS)]
final class CustomAttribute {}

#[CustomAttribute]
final class Foo
{

}

use Neontsun\ReadAttribute\ReadAttribute;

final class Controller 
{
    use ReadAttribute;
    
    public function __invoke() 
    {
        $attribute = $this->readClassAttribute(Foo::class, CustomAttribute::class);
        
        if ($attribute instanceof CustomAttribute) {
            // true
        }
    }
}

```