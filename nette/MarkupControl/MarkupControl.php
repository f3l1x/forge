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
 *
 * @version 1.1
 */
class MarkupControl extends Nette\Forms\Controls\BaseControl
{

    /** @var string|\Nette\Templating\Template|\Nette\Templating\FileTemplate */
    private $content;

    /** @var string */
    private $wrapper = "div";

    /**
     * Constructor
     *
     * @param string $label
     * @param string|\Nette\Templating\Template|\Nette\Templating\FileTemplate $content
     */
    public function __construct($label, $content)
    {
        parent::__construct($label);
        $this->setDisabled(true);
        $this->setContent($content);
    }

    /**
     * Sets html content
     *
     * @param string|\Nette\Templating\Template|\Nette\Templating\FileTemplate $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Gets html content
     *
     * @return Nette\Templating\FileTemplate|Nette\Templating\Template|string
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
        $control = \Nette\Utils\Html::el($this->wrapper)->setId($parentControl->getId());
        $control->setHtml($this->getContent());
        return $control;
    }

    /**
     * Register input to \Nette\Forms\Container
     *
     * @static
     * @param string $method
     * @return void
     */
    public static function register($method = 'addMarkup')
    {
        \Nette\Forms\Container::extensionMethod($method, function($form, $name, $label, $content)
        {
            return $form[$name] = new self($label, $content);
        });
    }
}
