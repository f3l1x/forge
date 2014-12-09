# Google +1

## Info

* @version 1.2
* @author Milan Felix Sulc
* @license MIT

## Factory

    public function createComponentGoogleButton() {
        $button = new GooglePlusone();
        $button->setHtml5(true);
        $button->setUrl('www.nette.org');

        return $button;
    }


## Template

    Script in <head /> or before </body>
    {googleButton:javascript}

    Button: {googleButton}