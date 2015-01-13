# Latte Macros

## Info

* @version 1.0
* @author Milan Felix Sulc <rkfelix@gmail.com>
* @license MIT

## Macros

* ifCurrentIn

## Register

### NEON

```neon
nette
    latte:
        macros:
            - NettePlugins\Macros\Macros::install
```

```neon
nette.latteFactory:
    setup:
        - '?->onCompile[] = (function($engine) { NettePlugins\Macros\Macros::install($engine->geCompiler());})'(@self)
```

### TemplateFactory

```php
/**
 * @param UI\Control $control
 * @return Template
 */
public function createTemplate(UI\Control $control)
{
    // ...

    $latte = $this->latteFactory->create();
    $latte->onCompile[] = function(Engine $latte) {
        NettePlugins\Macros\Macros::install($latte->getCompiler());
    };

    // ...

    return $template;
}
```
