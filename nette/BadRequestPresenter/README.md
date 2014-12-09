# Bad Request Presenter

Shortcut for throwing default error exceptions (403, 404, 405, 410, 500).

## Info

* @author Milan Felix Sulc
* @license MIT

## Usecase

```php
    // Show error 404 and default message "Page Not Found"
    $container->router[] = new Route('oldUrl', 'BadRequest:e404');

    // Show error 403 and default message "AccessDenied"
    $container->router[] = new Route('forum<path .*>', 'BadRequest:error403');

    // Show error 410 and custom message "My Page Not Found"
    $container->router[] = new Route('xyz/', array(
		'presenter' => 'BadRequest',
    	'action' => 'error403',
    	'message' => 'My Page Not Found',
	));
```

Thanks for testing..