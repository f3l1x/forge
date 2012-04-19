## MarkupControl

Add HTML to your form

Use case
-----

* 1) Pure html 
    
		$form->addMarkup('myHtmlInput1', 'Pure html', '\<div id="myInput" class="anyClass"></div>');

* 2) Nette\Utils\Html

		$form->addMarkup('myHtmlInput2', 'Nette\Utils\Html', Nette\Utils\Html::el('img')->src('image.jpg')->alt('photo'));

* 3) Nette\Templating\Template

		$tpl = new \Nette\Templating\Template();
		$tpl->setSource('xxx');
		$form->addMarkup('myHtmlInput3', 'Nette\Templating\Template', $tpl);

* 4) Nette\Templating\FileTemplate

		$tpl = $this->getTemplate();
		$tpl->setFile(__DIR__ . '/template.latte');
		$form->addMarkup('myHtmlInput4', 'Nette\Templating\FileTemplate', $tpl);
