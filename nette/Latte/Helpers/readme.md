## Latte helpers

Custom helpers for your templates.

## Info

* @version 1.0
* @author Milan Felix Sulc <rkfelix@gmail.com>
* @license MIT

## Register

### NEON

```neon
nette.latteFactory:
        setup:
            - addFilter(mailto, NettePlugins\Helpers\Helpers::mailto)
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

    $latte = $this->latteFactory->creat();
    $latte->addFilter('mailto', ['NettePlugins\Helpers\Helpers', 'mailto']);

    // ...

    return $template;
}
```