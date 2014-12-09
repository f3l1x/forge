## Mobile Detection

For checking mobile devices.

## Info

* @version 1.1
* @author Milan Felix Sulc <rkfelix@gmail.com>
* @license MIT

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