<?php
/**
 * Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Thumbnailer;

use Nette\Http\FileUpload;
use Nette\Utils\ArrayHash;
use Nette\Utils\Image;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class Thumbnailer extends \Nette\Object
{

    /** @var Thumb[] */
    private $thumbs = array();

    /** @var string */
    private $repository;

    /** @var array */
    private $errors = array();

    /** @var array */
    private $images = array();

    /**
     * Process handler
     *
     * @var array
     */
    public $onProcess = array();

    /**
     * Complete handler
     *
     * @var array
     */
    public $onComplete = array();

    /**
     * Error handler
     *
     * @var array
     */
    public $onError = array();

    /**
     * Sucess handler
     *
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
    public function process(FileUpload $file)
    {

        // check
        if ($file->isImage() && $file->isOk()) {

            // lets rock
            foreach ($this->thumbs as $thumb) {
                $thumb->setOriginalName($file->sanitizedName);
                $this->onProcess($file, $thumb);
            }

            // Fire complete handlers..
            $this->onComplete($this);
        }

        if (count($this->errors) > 0) {
            // Fire error handlers..
            $this->onError($this, $this->errors);
        } else {
            // Fire sucess handlers..
            $this->onSuccess($this, $this->images);
        }
    }

    public function thumbate(FileUpload $file, Thumb $thumb)
    {
        /** @var $image Image */
        $image = $file->toImage();

        $dimension = $thumb->getDimension();

        // Resize to thumb dimension
        $image->resize($dimension->getWidth(), $dimension->getHeight(), $dimension->getFlag());

        // Image name
        $imagename = $thumb->getImagename();

        // File name
        $filename = $imagename . '.' . Utils::ext($file->name);

        // Gets properly directory
        $path = Utils::dirs($this->repository, $thumb->getPath(), $filename);

        // Store image data
        $this->images[] = ArrayHash::from(array(
            'path' => Utils::dirs($this->repository, $thumb->getPath()),
            'fullpath' => $path,
            'filename' => $filename,
            'name' => $imagename,
            'ext' => Utils::ext($file->name),
        ));

        // Save to file
        $image->save($path);
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
     * @param Thumb $thumb
     */
    public function addThumb(Thumb $thumb)
    {
        $this->thumbs[] = $thumb;
    }

    /**
     * @param $width
     * @param $height
     * @param $path
     */
    public function createThumb($width, $height, $path)
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

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return bool
     */
    public function isOK()
    {
        return count($this->errors) == 0;
    }

}