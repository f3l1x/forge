# Latte sExtension [deprecated]

Small extension for Nette Framework to register your macros.

## Install

### 1) Bootstrap

```php
$configurator->onCompile[] = function ($configurator, $compiler) {
    $compiler->addExtension('latte', new LatteExtension());
};
```

### 2) Extension list (Nette 2.x-dev)
```neon
    extension:
        - LatteExtension
```