# Thumbator

Component for making

## Usage

### Config

    services:

        # Thumbator
        thumbator:
            class: Thumbator\Thumbator
            setup:
              - setRepository(%wwwDir%/data)

### Presenter

    use Thumbnailer\Thumbnailer;
    use Thumbnailer\Thumb;

    // gets Thumbator via nette service
    $thumbator = $this->context->thumbator;

    // makes some thumbs (width, height, path, flag)..

    // defaul uniq name
    $thumb1 = new Thumb(100, 200, './');

    // keep original name
    $thumb2 = new Thumb(400, 500, './', Thumb::FILENAME_FORMAT_ORIGINAL);

    // rename to dimension(WIDTHxHEIGHT)
    $thumb3 = new Thumb(200, 100, './', Thumb::FILENAME_FORMAT_DIMENSION);

    // keep original with dimension
    $thumb4 = new Thumb(40, 50, './', Thumb::FILENAME_FORMAT_ORIGINAL | Thumb::FILENAME_FORMAT_DIMENSION);

    // user custom name
    $thumb5 = new Thumb(300, 800, './', Thumb::FILENAME_FORMAT_VALUE);
    $thumb5->setFilename('felix the caT!!');

    $thumbator->addThumb($thumb1);
    $thumbator->addThumb($thumb2);
    $thumbator->addThumb($thumb3);
    $thumbator->addThumb($thumb4);
    $thumbator->addThumb($thumb5);

    // Success handler
    $thumbator->onSuccess[] = function($t, $images) {
       Debugger::dump($images);
    };

    // Error handler
    $thumbator->onError[] = function($t, $errors) {
        Debugger::dump($errors);
    };

    // Process image
    $thumbator->process($form->values->picture);

    // OR just

    if($thumbator->isOK()) {
        \Nette\Diagnostics\Debugger::dump($thumbator->getImages());
    } else {
        \Nette\Diagnostics\Debugger::dump($thumbator->getErrors());
    }

## Handlers

- onProcess ($thumbator, $thumb)
- onComplete ($thumbator)
- onError ($thumbator, $errors)
- onSucess ($thumbator, $images)