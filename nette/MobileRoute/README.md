# Mobile Route

## Info

* @author Milan Felix Sulc
* @license MIT

## Usage

    // Setup router
    $container->router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
    $container->router[] = new MobileRoute('<presenter>/<action>[/<id>]', 'Mobile:default');
    $container->router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

* That's all. MobileRoute matched only if you're on mobile device, otherwise route is skipped...

## 3rd part

* Mobile detection taken over http://detectmobilebrowsers.com/. Thx!