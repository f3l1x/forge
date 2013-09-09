# Thumbator

Easy-use util for resizing images on website.


## Info

* @author Milan Felix Sulc
* @license MIT
* @version 1.1

## Classes

* Thumbator
* ThumbatorFactory
* ThumbatorHelper

## Usage

    // Setup factory
    $factory = new ThumbatorFactory($httpRequest, $wwwDir, $wwwDir . '/uploads', 'temp');

    // Create thumbator
    $thumbator = $factory->create();

    // Create thumbs
    $thumbator->create('my-image.png', 100, 200);
    $thumbator->create('my-image.png', '50%', '50%');
    $thumbator->create('my-image.png', NULL, '50%');

More you can find in phpDoc.
