# LatteExtension

Small extension for Nette Framework, to register your marcros.

## Install

### 1) Bootstrap

    $configurator->onCompile[] = function ($configurator, $compiler) {
        $compiler->addExtension('latte', new LatteExtension());

    };

### 2) Extension list (Nette 2.x-dev)

    extension:
        - LatteExtension