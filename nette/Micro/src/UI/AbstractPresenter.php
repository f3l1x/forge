<?php

namespace Minetro\Micro\UI;

use Minetro\Micro\DI\Parameters;
use Nette\Application\LinkGenerator;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Http\IResponse;
use NetteModule\MicroPresenter;

/**
 * Abstract presenter.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
abstract class AbstractPresenter extends MicroPresenter
{

    /** @var LinkGenerator */
    protected $linkGenerator;

    /** @var Parameters */
    protected $micro;

    /**
     * @param LinkGenerator $linkGenerator
     * @param Parameters $parameters
     */
    public function injectPrimary(
        LinkGenerator $linkGenerator,
        Parameters $parameters
    )
    {
        $this->linkGenerator = $linkGenerator;
        $this->micro = $parameters;
    }

    /**
     * @param mixed $class
     * @param mixed $latteFactory
     * @return Template
     */
    public function createTemplate($class = NULL, $latteFactory = NULL)
    {
        // Create template
        $template = parent::createTemplate($class, $latteFactory);

        // Default parameters
        $template->_control = $template->control = $template->_presenter = $template->presenter;

        return $template;
    }

    /**
     * @param string $name
     * @return Template
     */
    public function view($name)
    {
        $filename = $this->micro->expand('config.templates') . DIRECTORY_SEPARATOR . $name . '.latte';

        if (!file_exists($filename)) {
            $this->error("Requested view '$name' not found.", IResponse::S404_NOT_FOUND);
        }

        $template = $this->createTemplate();
        $template->setFile($filename);

        return $template;
    }

    /**
     * @param string $destination
     * @param array $args
     * @return string
     */
    public function link($destination, array $args = [])
    {
        return $this->linkGenerator->link($destination, $args);
    }

}