<?php
/**
 * ConfiguratorPanel
 *
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * Version 2, December 2004
 *
 * Copyright (C) 2012 Milan Felix Sulc <rkfelix[at]gmail.com>
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

namespace Panel;

use Latte\Engine;
use Nette\Bridges\DITracy\ContainerPanel;
use Nette\DI\Container;
use Nette\Templating\FileTemplate;
use Nette\Utils\Arrays;
use Nette\Utils\Strings;
use Tracy\Debugger;
use Tracy\IBarPanel;

class Configurator extends ContainerPanel implements IBarPanel
{
    /** @var Container */
    private $context;

    /** @var array */
    private $factories = [];

    /** @var array */
    private $netteFactories = [];

    /** @var array */
    private $services = [];

    /** @var array */
    private $netteServices = [];

    /**
     * Renders HTML code for custom tab
     * IDebugPanel
     *
     * @return void
     */
    public function getTab()
    {
        return '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJ
bWFnZVJlYWR5ccllPAAAAy9JREFUeNp0U21IU2EUft7rdjdtuhFq9KWZJtMfmbrUHxkZ0a/CKOiH
FFIGkf0QosysrBViGn1oZBhkQkFRUWIg/RFLQq02rfmxac2cpoZibua+7rZ7e99bVgSdy+V8Puec
9z3nJdWXr4ARx3EyD4VC4HkeoihKlEAIYT7C7ItEfb9lGcUCqbGF/s+Y7Pf7EQgEsK+gQOZMZyCa
ZJbyZhbzb4KW5OR1OxMT1+4SBGGGgiSdVov3fX1gnOk+n09MSkpcui45KV+UxBYJ7AMULJvX61W7
XPPIzspCbOyy6Pj4OHg8XkxNTiE3NxeRUZFwOBwkJjoGnW+74fJ858OXRPw8HmvvwvmKI3b7iPOD
xSIbBwes+DzyWW59fPyLrBPC4T31D3/6OFNtvFhcgE3YPacHxwDGi5V2SRJ1G9LWy5VpNGzDwxi0
WmEbGoJf8FG7D8xP248ZqnltDyAoCSQEjt02O2NsbDQW3B7wSiVsNiscoyNPHz96mD9K+ahjDGqV
Cl6fHyo6IbU+Hi6NBoQjkoKNp6ioSG53emYaSl6JYDAI6+Dg9e6uzrdRWu3cqvjE3WFqDR4/fY6j
R4rReL8Rhm/piJ6bhoJNoaGhAQkJCUhbnyaPRqFQYEN6RqEhK3siEEIh4aMQ0bwHZQdrcK3pAXKy
c9Da1oq6W9UGQuMzGeh4aZmpgM6dVXe6XOjv70cgRG9ZrcPWqRpk7IgBxkYwpDyI22+CuFplNAwU
N5lJ+ZkKeUmEgCDmbc4jq1avlOdLOLqNykiE7m3HxvyVwPgk4PyK+z3Lsb++z1B6+ow5RCRwv7Zw
NkWfQvSpenyZnIQqXAPwGgh3NmOjXHkCcE2j0RwHd44RJ06dLedAoJQ4KFh1t9ttofu+pb29HR8s
fc4g2nS128xQHTsMfPMAA3Vo6k2AP6ccKskHn9etiwgP/7PKN2/UHjKZTB29PT0vb9Zd29JQd9nw
ZGAFXnRQMKfF3d41OFBvNtgs75ymN12vbly/enjxLZCTp07LQnVVZRJ7FqXlFfZItxUBMUzihXns
TeWRXNJsKCkzmmsvnWNjWqAY++8E+D9l/iWb/xf0Q4ABALuHnKJqedMoAAAAAElFTkSuQmCC">' .
        'Configurator';
    }


    /**
     * Renders HTML code for custom panel
     * IDebugPanel
     *
     * @return void
     */
    function getPanel()
    {
        ob_start();
        $template = new FileTemplate(dirname(__FILE__) . '/configurator.panel.latte');
        $template->registerFilter(new Engine());
        $template->parameters = $this->context->params;
        unset($template->parameters['nette']); // ??!
        $template->factories = $this->getFactories();
        $template->netteFactories = $this->getNetteFactories();
        $template->services = $this->getServices();
        $template->netteServices = $this->getNetteFactories();
        $template->render();
        return $cache['output'] = ob_get_clean();
    }


    /**
     * Returns panel ID
     * IDebugPanel
     *
     * @return string
     */
    function getId()
    {
        return __CLASS__;
    }


    /**
     * Registers panel to Debug bar
     */
    static function register(Container $context)
    {
        Debugger::getBar()->addPanel(new self($context));
    }

    /**
     * Filter methods
     */
    private function filterMethods()
    {
        foreach ($this->context->getReflection()->getMethods() as $method) {
            if (strpos($method, "SystemContainer") !== FALSE) {
                $match = Strings::match($method, "#.+::([a-zA-Z0-9_]+)#");
                $res = Arrays::get((array)$match, 1, NULL);
                $parameters = $this->getMethodParameters($method->getParameters());
                if (strpos($res, "createServiceNette") !== FALSE) {
                    $this->netteServices[] = $this->buildFunction($res, $parameters);
                } else if (strpos($res, "createService") !== FALSE) {
                    $this->services[] = $this->buildFunction($res, $parameters);
                } else if (strpos($res, "createNette") !== FALSE) {
                    $this->netteServices[] = $this->buildFunction($res, $parameters);
                } else if (strpos($res, "create") !== FALSE) {
                    $this->factories[] = $this->buildFunction($res, $parameters);
                }
            }
        }
    }

    private function getMethodParameters($parameters)
    {
        if (count($parameters) <= 0) return NULL;
        $params = [];
        foreach ($parameters as $parameter) {
            $params[] = "$" . $parameter->getName();
        }
        return implode(', ', $params);
    }

    private function buildFunction($func, $params)
    {
        return $func . '(' . $params . ')';
    }

    /**
     * @return Container
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return array
     */
    public function getFactories()
    {
        return $this->factories;
    }

    /**
     * @return array
     */
    public function getNetteServices()
    {
        return $this->netteServices;
    }

    /**
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @return array
     */
    public function getNetteFactories()
    {
        return $this->netteFactories;
    }

}
