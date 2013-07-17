<?php

use \Nette\Diagnostics\Debugger;
use \Thumbnailer\Thumb;
use \Thumbnailer\Thumbnailer;

class HomepagePresenter extends BasePresenter
{

    public function actionDefault() {
    }

    public function createComponentForm() {
        $form = new \Nette\Application\UI\Form();
        $form->addUpload('picture', 'obrazek');
        $form->addSubmit('ok', 'upload');
        $form->onSuccess[] = callback($this, 'process');

        return $form;
    }

    public function process(\Nette\Forms\Form $form) {
        if ($form->isSuccess()) {

            /** @var Thumbnailer */
            $thumbator = $this->context->thumbator;
            $thumb1 = new Thumb(100, 200, './');
            $thumb2 = new Thumb(400, 500, './', Thumb::FILENAME_FORMAT_ORIGINAL);
            $thumb3 = new Thumb(200, 100, './', Thumb::FILENAME_FORMAT_DIMENSION);
            $thumb4 = new Thumb(40, 50, './', Thumb::FILENAME_FORMAT_ORIGINAL | Thumb::FILENAME_FORMAT_DIMENSION);
            $thumb5 = new Thumb(300, 800, './', Thumb::FILENAME_FORMAT_VALUE);
            $thumb5->setFilename('felix the caT!!');

            $thumbator->addThumb($thumb1);
            $thumbator->addThumb($thumb2);
            $thumbator->addThumb($thumb3);
            $thumbator->addThumb($thumb4);
            $thumbator->addThumb($thumb5);

            // Success handler
            $thumbator->onSuccess[] = function($t) {
               Debugger::barDump('Sucess handler');
            };

            $thumbator->process($form->values->picture);

            Debugger::barDump($form->values);
        }
    }

}
