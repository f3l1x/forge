<?php

class CaptchaPresenter extends BasePresenter
{

    protected function startup()
    {
        parent::startup();

        $captcha = new CaptchaBase();
        $captcha->setExtension(new SeznamCaptcha());
        //$captcha->setExtension(new reCaptcha());
        NFormContainer::extensionMethod('addCaptcha', [$captcha, 'captcha']);
    }

    public function createComponentReCaptcha()
    {

        $form = new NAppForm();
        $form->addCaptcha('captcha', 'aa');
        $form->addText('text', 'Nejaky textik');
        $form->addSubmit('ok', 'odeslat');

        $form->onSubmit[] = [$this, 'captchaProcess'];
        return $form;
    }

    public function captchaProcess(NAppForm $form)
    {
        // vypise chyby z komponenty..
        if ($form['captcha']->hasError()) {
            var_dump($form['captcha']->getErrors());
        }

        if ($form->isSubmitted()) {
            echo "Formular se povedlo odeslat:<br>";
            var_dump($form->values);
        }
    }

}
