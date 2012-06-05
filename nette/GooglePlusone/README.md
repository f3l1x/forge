# Google +1 [Nette addon]

Factory in presenter
======================

    public function createComponentGoogleButton() {
        $button = new GooglePlusone();
        $button->setHtml5(true);
        $button->setUrl('www.nette.org');

        return $button;
    }


In latte template
===========================

    {googleButton:javascript}

    Tohle je super {googleButton}