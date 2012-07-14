<?php //netteCache[01]000382a:2:{s:4:"time";s:21:"0.54263600 1342252359";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:60:"D:\xampp\htdocs\sandbox\app\templates\Homepage\default.latte";i:2;i:1342040587;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"eb558ae released on 2012-04-04";}}}?><?php

// source file: D:\xampp\htdocs\sandbox\app\templates\Homepage\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '61x6ao8omp')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbfda1dccc15_content')) { function _lbfda1dccc15_content($_l, $_args) { extract($_args)
;foreach (array("Page:default", "Homepage:default") as $l) { if ($_presenter->isLinkCurrent($l)) $_c = true; } if (isset($_c)): ?>
    Ahojda
<?php endif; unset($_c) ?>


<?php foreach (array('Homepage:*') as $l) { if ($_presenter->isLinkCurrent($l)) $_c = true; } if (isset($_c)): ?><div>
    Cau
</div>
<?php endif; unset($_c); 
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 