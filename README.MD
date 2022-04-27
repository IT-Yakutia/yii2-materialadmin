Material Admin module for Yii2
====================
Material Admin module for Yii2

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require --prefer-dist it-yakutia/yii2-materialadmin "*"
```

or add

```json
"it-yakutia/yii2-materialadmin": "*"
```

to the require section of your `composer.json` file.


Usage
-----
Once the extension is installed, simply add in your backend config:

```php
    ...
    'layoutPath' => '@ityakutia/materialadmin/views/layouts',
    'components' => [
        ...
    ],
```