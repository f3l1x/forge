<?php
/**
 * FbTools 2.0 for PHP 5.3
 *
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * Version 2, December 2004
 *
 * Copyright (C) 2011 Milan Felix Sulc <rkfelix[at]gmail.com>
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

namespace FbTools;

class Comments extends FbTools
{

    /** @var int */
    public $posts = 3;

    public function render($params = array())
    {
        $this->setAll($params);
        // template vars
        $this->template->setFile(dirname(__FILE__) . '/comments.latte');
        $this->template->url = $this->getUrl();
        $this->template->posts = $this->getPosts();
        $this->template->width = $this->getWidth();
        $this->template->scheme = $this->getScheme();
        $this->template->html5 = $this->isHtml5();
        $this->template->render();
    }

    /**
     * @param int $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return int
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
