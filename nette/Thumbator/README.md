# Thumbator

Easy-use util for resizing images on website


## Info

* @author Milan Felix Sulc
* @license MIT
* @version 1.0

## Usage

    // Create thumbator
    $thumbator = new Thumbator($this->httpRequest);

    // Create thumbs
    $thumbator->create('my-image.png', 100, 200);
    $thumbator->create('my-image.png', 300, 300, 'exact');
