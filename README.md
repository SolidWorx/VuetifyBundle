VuetifyBundle
=============

VuetifyBundle adds support for various [VuetifyJS](https://vuetifyjs.com) components in Symfony

Installation
------------

You can install the bundle using [Composer](https://getcomposer.org/):

```bash
$ composer require solidworx/vuetify-bundle
```

After the process has completed, you need to enable the bundle:

```php
<?php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            ...
            new SolidWorx\VuetifyBundle\VuetifyBundle(),
            ...
        ];
        
        ...        
     }
}
```

If you are using Symfony 4 with Flex, then the bundle should automatically be registered.

Usage
-----

Supported Components
--------------------

 - [ ] Alerts
 - [ ] Form Elements
 - [ ] Steppper
 - [ ] Data Table / Data Iterator
