<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Forms\Controls;

use Latte\Engine;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Forms\Container;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @author Petr Stuchl4n3k Stuchlik <stuchl4n3k@gmail.com>
 * @licence MIT
 * @version 1.3
 */
class MarkupControl extends BaseControl
{

    /** @var string|Template */
    private $content;

    /** @var Html */
    private $wrapper;

    /**
     * Constructor
     *
     * @param string $label
     * @param string|Template $content
     */
    public function __construct($label, $content)
    {
        parent::__construct($label);
        $this->setDisabled(TRUE);
        $this->setOmitted(TRUE);
        $this->setContent($content);
    }

    /**
     * Sets html content
     *
     * @param string|Template $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Gets html content
     *
     * @return string|Template
     */
    public function getContent()
    {
        if ($this->content instanceof Template) {
            // if is it template
            return $this->content->render();
        } else if (file_exists($this->content)) {
            // if is it file
            $l = new Engine();
            return $l->renderToString($this->content);
        }

        return (string)$this->content;
    }

    /**
     * Generates control's HTML element.
     *
     * @return Html
     */
    public function getControl()
    {
        $parentControl = parent::getControl();

        $control = $this->getWrapperPrototype();
        $control->setId($parentControl->getId());
        $control->setHtml($this->getContent());

        return $control;
    }

    /**
     * @return Html
     */
    protected function getWrapperPrototype()
    {
        if ($this->wrapper == NULL) {
            $this->wrapper = Html::el("div");
        }

        return $this->wrapper;
    }

    /**
     * Register input to Form Container
     *
     * @static
     * @param string $method
     * @return void
     */
    public static function register($method = 'addMarkup')
    {
        Container::extensionMethod($method, function (Container $container, $name, $label, $content) {
            return $container[$name] = new MarkupControl($label, $content);
        });
    }
}
