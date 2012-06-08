<?php

class Thumbator extends \Nette\Object
{

    /** @var Thumb[] */
    private $thumbs;

    /** @var string */
    private $repository;

    /** @var bool */
    private $uniqname = true;

    /** @var array */
    private $errors = array();

    /**
     * Process handler
     * @var array
     */
    public $onProcess = array();

    /**
     * Complete handler
     * @var array
     */
    public $onComplete = array();

    /**
     * Error handler
     * @var array
     */
    public $onError = array();

    /**
     * Sucess handler
     * @var array
     */
    public $onSuccess = array();

    /**
     * Constructor and registator
     */
    public function __construct()
    {
        $this->onProcess[] = callback($this, 'thumbate');
    }

    /**
     * @param FileUpload $file
     */
    public function process(\Nette\Http\FileUpload $file)
    {

        // check
        if ($file->isImage() && $file->isOk()) {

            // lets rock
            foreach ($this->thumbs as $thumb) {
                $this->onProcess($file, $thumb);
            }

            // Fire complete handlers..
            $this->onComplete($this);
        }

        if (count($this->errors) > 0) {
            // Fire error handlers..
            $this->onError($this);
        } else {
            // Fire sucess handlers..
            $this->onSuccess($this);
        }
    }

    public function thumbate(\Nette\Http\FileUpload $file, Thumb $thumb)
    {

    }

    /**
     * @param string $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param $width
     * @param $height
     * @param $path
     */
    public function addThumb($width, $height, $path)
    {
        if ($width > 0 && $height > 0) {
            $this->thumbs[] = new Thumb($width, $height, $path);
        }
    }

    /**
     * @return Thumb[]
     */
    public function getThumbs()
    {
        return $this->thumbs;
    }


}