<?php
/**
 * Multi file upload component for Nette Forms
 *
 * @see http://forum.nette.org/cs/12717-upload-vice-souboru-file
 * @copyright Copyright (c) 2012 netrunner
 * @copyright Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */
namespace Nette\Forms\Controls;

use Nette;
use Nette\Http;

/**
 * @author Milan Felix Sulc
 * @license MIT
 * @version 1.0
 */
class MultiUploadControl extends UploadControl
{
    /** Validation rules */
    const MAX_TOTAL_SIZE = ":totalSize";
    const MAX_FILES = ":maxFiles";
    const MIN_FILES = ":minFiles";
    const ONLY_IMAGES = ":image";

    /**
     * @return string
     */
    public function getHtmlName()
    {
        return parent::getHtmlName() . '[]';
    }

    /**
     * @return mixed
     */
    public function getControl()
    {
        return parent::getControl()->multiple(TRUE);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $values = parent::getValue();
        if (!$this->checkFiles()) {
            $this->addError("One or more files are invalid.");
        }

        return $values;
    }

    /**
     * @param $value
     * @return MultiUploadControl
     */
    public function setValue($value)
    {
        foreach ($value as $single) {
            if (is_array($single)) {
                $this->value[] = new Http\FileUpload($single);
            } elseif ($single instanceof Http\FileUpload) {
                $this->value[] = $single;
            } else {
                $this->value[] = new Http\FileUpload(NULL);
            }
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isFilled()
    {
        if (!isset($this->value[0]) || !($this->value[0] instanceof Http\FileUpload) || !$this->checkFiles()) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @return bool
     */
    public function checkFiles()
    {
        foreach ($this->value as $key => $file) {
            if ($file instanceof Http\FileUpload) {
                if (!$file->isOK()) {
                    return FALSE;
                }
            } else {
                // remove invalid file..
                unset($this->value[$key]);
            }
        }

        return TRUE;
    }

    /**
     * @param UploadControl $control
     * @param $limit
     * @return bool
     */
    public static function validateMaxTotalSize(UploadControl $control, $limit)
    {
        $files = $control->getValue();
        $size = 0;
        foreach ($files as $file) {
            if ($file instanceof Http\FileUpload) {
                $size += $file->getSize();
            }
        }

        return $size <= $limit;
    }

    /**
     * @param UploadControl $control
     * @param $range
     * @return bool
     */
    public static function validateRange(UploadControl $control, $range)
    {
        $files = count($control->getValue());
        return \Nette\Utils\Validators::isInRange($files, $range);
    }

    /**
     * @param UploadControl $control
     * @param $count
     * @return bool
     */
    public static function validateMaxFiles(UploadControl $control, $count)
    {
        return count($control->getValue()) <= $count;
    }

    /**
     * @param UploadControl $control
     * @param $count
     * @return bool
     */
    public static function validateMinFiles(UploadControl $control, $count)
    {
        return count($control->getValue()) >= $count;
    }

    /**
     * @param UploadControl $control
     * @param $limit
     * @return bool
     */
    public static function validateFileSize(UploadControl $control, $limit)
    {
        $files = $control->getValue();
        foreach ($files as $file) {
            if (!($file instanceof Http\FileUpload) && $file->getSize() > $limit) {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * @param UploadControl $control
     * @param $mimeType
     * @return bool
     */
    public static function validateMimeType(UploadControl $control, $mimeType)
    {
        $files = $control->getValue();
        foreach ($files as $file) {
            if ($file instanceof Http\FileUpload) {
                $type = strtolower($file->getContentType());
                $mimeTypes = is_array($mimeType) ? $mimeType : explode(',', $mimeType);
                if (!in_array($type, $mimeTypes, TRUE)) {
                    return FALSE;
                }
                if (!in_array(preg_replace('#/.*#', '/*', $type), $mimeTypes, TRUE)) {
                    return FALSE;
                }
            }

            return FALSE;
        }

        return TRUE;
    }

    /**
     * @param UploadControl $control
     * @return bool
     */
    public static function validateImage(UploadControl $control)
    {
        $files = $control->getValue();
        foreach ($files as $file) {
            if (!($file instanceof Http\FileUpload && $file->isImage())) {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * @param string $methodName
     * @return void
     */
    public static function register($methodName = "addMultiUpload")
    {
        \Nette\Application\UI\Form::extensionMethod($methodName, function (\Nette\Application\UI\Form $form, $name, $label = NULL) {
            $form[$name] = new \Nette\Forms\Controls\MultiUploadControl($label);
            return $form[$name];
        });
    }
}

?>