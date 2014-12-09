# Thumbator

Component for making

## Usage

### Config

```neon
services:
    thumbnailer:
        class: NettePlugins\Thumbnailer\Thumbnailer
        setup:
          - setRepository(%wwwDir%/data)
```

### Presenter

```php
use NettePlugins\Thumbnailer\Thumbnailer;
use NettePlugins\Thumbnailer\Thumb;

// gets Thumbator via nette service
$thumbnailer = $this->context->thumbnailer;

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

$thumbnailer->addThumb($thumb1);
$thumbnailer->addThumb($thumb2);
$thumbnailer->addThumb($thumb3);
$thumbnailer->addThumb($thumb4);
$thumbnailer->addThumb($thumb5);

// Success handler
$thumbnailer->onSuccess[] = function($t, $images) {
   Debugger::dump($images);
};

// Error handler
$thumbnailer->onError[] = function($t, $errors) {
    Debugger::dump($errors);
};

// Process image
$thumbnailer->process($form->values->picture);

// OR just

if($thumbnailer->isOK()) {
    Debugger::dump($thumbnailer->getImages());
} else {
    Debugger::dump($thumbnailer->getErrors());
}
```

## Handlers

- onProcess ($thumbnailer, $thumb)
- onComplete ($thumbnailer)
- onError ($thumbnailer, $errors)
- onSucess ($thumbnailer, $images)