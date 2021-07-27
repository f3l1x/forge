<?php

namespace Minetro\Micro\Modules\Website\Closures;

use Minetro\Micro\Modules\Website\Presenters\PagePresenter;

/**
 * Error page closure.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
final class ErrorPageClosure
{

    /**
     * @param PagePresenter $presenter
     * @param mixed $code
     */
    public function invoke($presenter, $code)
    {
        $error = in_array($code, array(404, 500)) ? $code : '4xx';
        return $presenter->view("errors/$error");
    }

}
