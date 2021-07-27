# Google +1

## Info

* @version 2.0
* @author Milan Felix Sulc
* @license MIT

## Settings
| Field      | Default               | Setter/Getter | Info                     |
|------------|-----------------------|---------------|--------------------------|
| size       |        standard       | yes/yes       |                          |
| annotation |         inline        | yes           | inline/bubble/none       |
| callback   |          NULL         | yes           |                          |
| url        |          NULL         | yes           |                          |
| mode       |        default        | yes           | default/explicit/dynamic |
| width      |          300          | yes           |                          |
| lang       |           cs          | yes           |                          |
| element    | div class="g-plusone" | yes           | html prototype           |

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

{control plusone:js}

### Render button

Button #1: `{control plusone}`

Button #2: `{control plusone, $url}`

Button #3: `{control plusone, 'www.seznam.com'}`
