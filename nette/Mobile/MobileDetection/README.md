## Mobile Detection

For checking mobile devices.

## Info

* @author Milan Felix Sulc
* @license MIT
* @version 1.1

## Usage

```php
	if(MobileDetection::isMobile()) {
		// mobile routing
		$router[] = new Route('index.php', 'Mobile:Homepage:default', Route::ONE_WAY);
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Mobile:Homepage:default');
	} else {
		// default routing
		$router[] = new Route('index.php', 'Classic:Homepage:default', Route::ONE_WAY);
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Classic:Homepage:default');
	}
```