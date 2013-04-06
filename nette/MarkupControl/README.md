## Markup Control

Add HTML to your form.

## Info

* @version 1.2
* @author Milan Felix Sulc
* @license MIT

## Scheme
    $form->addMarkup(NAME, LABEL, DATA);

## Use case

1) Pure html
    
    $form->addMarkup('myHtmlInput1', 'Pure html', '\<div id="myInput" class="anyClass"></div>');

2) Nette\Utils\Html

    $form->addMarkup('myHtmlInput2', 'Nette\Utils\Html', Nette\Utils\Html::el('img')->src('image.jpg')->alt('photo'));

3) Nette\Templating\Template

    $tpl = new \Nette\Templating\Template();
    $tpl->setSource('xxx');
    $form->addMarkup('myHtmlInput3', 'Nette\Templating\Template', $tpl);

4) Nette\Templating\FileTemplate

    $tpl = $this->getTemplate();
    $tpl->setFile(__DIR__ . '/template.latte');
    $form->addMarkup('myHtmlInput4', 'Nette\Templating\FileTemplate', $tpl);

5) File path

    $form->addMarkup('myHtmlInput5', 'File path', 'home/dir/filetemplate.latte');


## Changelog

**1.2**
- Fixed bugs
- Licence

**1.1**
- phpDocs
- Added manual

**1.0**
- Base idea
