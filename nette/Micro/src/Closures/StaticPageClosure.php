<?php

namespace Minetro\Micro\Modules\Website\Closures;

use Minetro\Micro\Modules\Website\Presenters\PagePresenter;

/**
 * Static page closure.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
final class StaticPageClosure
{

    /**
     * @param PagePresenter $presenter
     * @param mixed $url
     */
    public function invoke($presenter, $url)
    {
        $template = $presenter->view($url);

        $template->url = $url;

        return $template;
    }

}
