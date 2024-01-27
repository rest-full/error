# Rest-full Error

## About Rest-full Error

Rest-full Event is a small part of the Rest-Full framework.

You can find the application at: [rest-full/app](https://github.com/rest-full/app) and you can also see the framework skeleton at: [rest-full/rest-full](https://github.com/rest-full/rest-full).

## Installation

* Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
* Run `php composer.phar require rest-full/error` or composer installed globally `compser require rest-full/error` or composer.json `"rest-full/error": "1.0.0"` and install or update.

## Usage

This Error
```
<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/pathServer.php';

use Restfull\Error\ErrorHandler;
use Restfull\Error\Exceptions;

$exemplo = new Exceptions('exemplo valido',404);
$error = new ErrorHandler();
$error->logError($exemplo);
echo $error->MVCHandling($exemplo);
```
## License

The rest-full framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

