<?php

class CaptchaField extends NTextBase
{

    public $captcha_element = 'div';
    public $extension;
    public $hash = NULL;
    public $responce = NULL;
    public $error = NULL;

    public $old_label = TRUE;
    public $show_captcha_error = FALSE;

    public function __construct($label = NULL)
    {
        parent::__construct($label);
        $this->control = NHtml::el($this->captcha_element);
    }

    public function getLabel($label = NULL)
    {
        if ($this->old_label) {
            return parent::getLabel();
        } else {
            return NULL;
        }
    }

    public function getControl($label = NULL)
    {
        return parent::getControl();
    }


    public function loadHttpData()
    {
        $this->hash = NArrayTools::get($this->getForm()->getHttpData(), $this->getExtension()->captcha_hash);
        $this->responce = NArrayTools::get($this->getForm()->getHttpData(), $this->getExtension()->captcha_responce);
        $this->setValue($this->responce);
    }

    public static function validateValid(IFormControl $control)
    {
        $res = $control->getExtension()->validate($control->hash, $control->responce);
        if ($res) {
            return TRUE;
        } else {
            if ($control->show_captcha_error) {
                foreach ($control->getExtension()->getErrors() as $error) {
                    $control->addError($error);
                }
            }

            $control->error = ($control->getExtension()->getErrors());
            return FALSE;
        }
    }

    public function setExtension(ICaptcha $ext)
    {
        $this->extension = $ext;
        $this->control->setHtml($ext->getControl());
        return $this;
    }

    public function hasError()
    {
        if (empty($this->error)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getError()
    {
        return $this->error;
    }

    public function getExtension()
    {
        return $this->extension;
    }
}