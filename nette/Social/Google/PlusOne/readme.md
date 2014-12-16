# Google +1

## Info

* @version 2.0
* @author Milan Felix Sulc
* @license MIT

## Settings
| Type   | Field             | Default               | Setter/Getter | Info                     |
|--------|-------------------|-----------------------|---------------|--------------------------|
| string | $size             | standard              | yes/yes       |                          |
| string | $annotation       | inline                | yes/yes       | inline/bubble/none       |
| string | $callback         | NULL                  | yes/yes       |                          |
| string | $url              | NULL                  | yes/yes       |                          |
| int    | $mode             | default               | yes/yes       | default/explicit/dynamic |
| int    | $width            | 300                   | yes/yes       |                          |
| string | $lang             | cs                    | yes/yes       |                          |
| Html   | $elementPrototype | div class="g-plusone" | yes/yes       | html prototype           |
| array  | $properties       | []                    |               |                          |

## Factory

```php
protected function createComponentPlusone() {
    $button = new NettePlugins\Social\Google\PlusOne();
    $button->setMode($button::MODE_DEFAULT);
    $button->setUrl('www.google.com');

    return $button;
}
```

```php
/** @var NettePlugins\Social\Google\IPlusOneFactory @inject */
public $plusOneFactory;

protected function createComponentPlusone() {
    $button = $this->plusOneFactory->create();
    $button->setMode($button::MODE_DEFAULT);
    $button->setUrl('www.google.com');
    
    return $button;
}
```

## Template

### Render javascript

Place before `</body>` or `</head>`.

`{control plusone:js}`

### Render button

Button #1: `{control plusone}`

Button #2: `{control plusone, $url}`

Button #3: `{control plusone, 'www.seznam.com'}`
