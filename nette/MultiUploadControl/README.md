# Multi file upload component for Nette forms

## Info

* @author netrunner
* @see http://forum.nette.org/cs/12717-upload-vice-souboru-file

* @edited Milan Felix Sulc
* @license MIT

## Register

Anywhere.

	\Nette\Forms\Controls\MultiUploadControl::register();

## Use

    public function createComponentForm() {
        $form = new \Nette\Application\UI\Form();
        $form->addMultiUpload('multi', 'multiupload')
            ->addRule($form::RANGE, "Not in range", array(1,3))
            ->addRule(MultiUploadControl::MAX_FILES, "Max 10 files", 10)
            ->addRule(MultiUploadControl::MIN_FILES, "Min 5 files", 5)
            ->addRule(MultiUploadControl::MAX_TOTAL_SIZE, "Total size", 1024 * 1024 * 10)
            ->addRule($form::IMAGE, "Only pictures");

        $form->addSubmit('Upload');
        $form->onSuccess[] = callback($this, 'process');
        return $form;
    }
