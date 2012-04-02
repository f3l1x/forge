<?php
/*
 * MarkupControl
 *
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * Version 2, December 2004
 *
 * Copyright (C) 2012:
 * @ Milan Felix Sulc <rkfelix@gmail.com>
 * @ Petr Stuchl4n3k Stuchlik <stuchl4n3k@gmail.com>
 *
 * Everyone is permitted to copy and distribute verbatim or modified
 * copies of this license document, and changing it is allowed as long
 * as the name is changed.
 *
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 */


/**
 * Add HTML to form
 *
 * @author Milan Felix Sulc
 * @author Petr Stuchl4n3k Stuchlik
 */
class MarkupControl extends Nette\Forms\Controls\BaseControl
{

    /** @var string|\Nette\Templating\Template */
    private $content;

    /**
     * @param string $label
     * @param array $options
     */
    public function __construct($label, $content)
    {
        parent::__construct($label);
        $this->setContent($content);
    }

    /**
     * @param  $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Return html content
     */
    public function getContent()
    {
        if ($this->content instanceof \Nette\Templating\ITemplate) {
            // if is it template
            return $this->content->__toString();
        } else if (file_exists($this->content)) {
            // if is it file
            $t = new \Nette\Templating\FileTemplate($this->content);
            return $t->__toString();
        }

        return $this->content;
    }

    /**
     * Generates control's HTML element.
     *
     * @return Nette\Utils\Html
     */
    public function getControl()
    {
        $parentControl = parent::getControl();
        $control = \Nette\Utils\Html::el("div")->setId($parentControl->getId());
        $control->setHtml($this->getContent());
        return $control;
    }

    /**
     * @static
     * Register input to \Nette\Forms\Container
     */
    public static function register($method = 'addMarkup')
    {
        \Nette\Forms\Container::extensionMethod($method, function($form, $name, $label, $content)
        {
            return $form[$name] = new self($label, $content);
        });
    }
}