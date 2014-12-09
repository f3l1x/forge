# Google +1

## Info

* @version 1.3
* @author Milan Felix Sulc
* @license MIT

## Factory

```php
    protected function createComponentPlusone() {
        $button = new NettePlugins\Social\Google\PlusOne();
        $button->setMode($button::MODE_HTML5);
        $button->setUrl('www.nette.org');

        return $button;
    }
```

## Template

    Script in <head /> or before </body>
    {plusone:javascript}

    Button: {plusone}