# Thumbator


## Usage

        // gets Thumbator via nette factory
        $thumbator = $this->context->thumbator;
        
        // makes some thumbs (width, height, path, flag)..
        
        // defaul uniq name
        $thumb1 = new \Thumbator\Thumb(100, 200, './');
        
        // keep original name
        $thumb2 = new \Thumbator\Thumb(400, 500, './', \Thumbator\Thumb::FILENAME_FORMAT_ORIGINAL);
        
        // rename to dimension(WIDTHxHEIGHT)
        $thumb3 = new \Thumbator\Thumb(200, 100, './', \Thumbator\Thumb::FILENAME_FORMAT_DIMENSION);
        
        // keep original with dimension
        $thumb4 = new \Thumbator\Thumb(40, 50, './', \Thumbator\Thumb::FILENAME_FORMAT_ORIGINAL | \Thumbator\Thumb::FILENAME_FORMAT_DIMENSION);
        
        // user custom name
        $thumb5 = new \Thumbator\Thumb(300, 800, './', \Thumbator\Thumb::FILENAME_FORMAT_VALUE);
        $thumb5->setFilename('felix the caT!!');

        $thumbator->addThumb($thumb1);
        $thumbator->addThumb($thumb2);
        $thumbator->addThumb($thumb3);
        $thumbator->addThumb($thumb4);
        $thumbator->addThumb($thumb5);

        // Success handler
        $thumbator->onSuccess[] = function($t) {
           Debugger::dump($t->getImages());
        };

        // Error handler
        $thumbator->onError[] = function($t) {
            Debugger::dump($t->getErrors());
        };

        // Process image
        $thumbator->process($form->values->picture);
