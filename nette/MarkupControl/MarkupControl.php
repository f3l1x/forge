<?php
/**
 * Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace Nette\Forms\Controls;

use \Nette\Utils\Html;
use \Nette\Forms\Container;
use Nette\Templating\IFileTemplate;
use Nette\Templating\ITemplate;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @author Petr Stuchl4n3k Stuchlik <stuchl4n3k@gmail.com>
 * @licence MIT
 * @version 1.2
 */
class MarkupControl extends BaseControl
{

    /** @var string|IFileTemplate|ITemplate */
    private $content;

    /** @var string */
    private $wrapper = "div";

    /**
     * Constructor
     *
     * @param string $label
     * @param string|IFileTemplate|IFileTemplate $content
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
     * @param string|IFileTemplate|IFileTemplate $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Gets html content
     *
     * @return string|IFileTemplate|IFileTemplate
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
     * @return Html
     */
    public function getControl()
    {
        $parentControl = parent::getControl();
        $control = Html::el($this->wrapper)->setId($parentControl->getId());
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
        Container::extensionMethod($method, function(Container $container, $name, $label, $content)
        {
            return $container[$name] = new MarkupControl($label, $content);
        });
    }
}
