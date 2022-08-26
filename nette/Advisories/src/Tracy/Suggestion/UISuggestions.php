<?php

namespace Contributte\Advisories\Tracy\Suggestion;

use Tracy\BlueScreen;

class UISuggestions
{

	public static function presenterContext()
	{
		$parts = [];
		$parts[] = '<h3>Wrong</h3>';
		$parts[] = BlueScreen::highlightPhp(trim('
<?php

public function actionDefault()
{
	$service = $this->context->getByType(MyService::class));
}
'), 0, 6);;

		$parts[] = '<h3><span style="color: green">Correct</span> - Constructor injection</h3>';
		$parts[] = BlueScreen::highlightPhp(trim('
<?php

public function __construct(MyService $myService) 
{
	$this->myService = $myService;
}
'), 0, 6);

		$parts[] = '<h3><span style="color: green">Correct</span> - Method injection</h3>';
		$parts[] = BlueScreen::highlightPhp(trim('
<?php

public function injectMyService(MyService $myService) 
{
	$this->myService = $myService;
}
'), 0, 6);

		$parts[] = '<h3><span style="color: green">Correct</span> - Property @inject</h3>';
		$parts[] = BlueScreen::highlightPhp(trim('
<?php

/** @var MyService @inject */
public $myService;
'), 0, 4);

		$parts[] = '<p>See more in Nette documentation (<a href="https://doc.nette.org/en/2.4/di-usage#toc-presenters">https://doc.nette.org/en/2.4/di-usage#toc-presenters</a>).</p>';

		return implode('', $parts);
	}

}
