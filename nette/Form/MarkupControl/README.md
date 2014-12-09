## Markup Control

Add HTML to your form.

## Info

* @version 1.2
* @author Milan Felix Sulc <rkfelix@gmail.com>
* @license MIT

## Register

Anywhere. (e.q. before you used in a form)

```php
Nette\Forms\Controls\MoneyControl::register();
```

## Scheme
```php
$form->addMarkup(NAME, LABEL, DATA);
```

## Use case

1) Pure html

```php
$form->addMarkup('myHtmlInput1', 'Pure html', '\<div id="myInput" class="anyClass"></div>');
```

2) Nette\Utils\Html

```php
$form->addMarkup('myHtmlInput2', 'Nette\Utils\Html', Nette\Utils\Html::el('img')->src('image.jpg')->alt('photo'));
```

3) Template

```php
$tpl = new Nette\Bridges\ApplicationLatte\Template();
$tpl->setSource('xxx');
$form->addMarkup('myHtmlInput3', 'Nette\Bridges\ApplicationLatte\Template', $tpl);
```

4) FileTemplate

```php
$tpl = new Nette\Bridges\ApplicationLatte\Template();
$tpl->setFile(__DIR__ . '/template.latte');
$form->addMarkup('myHtmlInput4', 'Nette\Bridges\ApplicationLatte\Template', $tpl);
```

5) File path

```php
$form->addMarkup('myHtmlInput5', 'File path', __DIR__ . '/app/templates/control.latte');
```

## Changelog

**1.3**
- Update readme
- Update to Nette 2.2

**1.2**
- Fix some bugs
- Added licence

**1.1**
- Update phpDocs
- Added manual

**1.0**
- Base idea