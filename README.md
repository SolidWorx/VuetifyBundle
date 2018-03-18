VuetifyBundle
=============

VuetifyBundle adds support for various [VuetifyJS](https://vuetifyjs.com) components in Symfony

**Note:** This bundle does NOT add the VuetifyJS library to your project. Vuetify should already be included in your project, and a basic Vue instance should be instantiated.
See the [quick start guide](https://vuetifyjs.com/en/getting-started/quick-start) of Vuetify to get started.

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

### Form Theme

VuetifyBundle comes with a [Symfony form theme](https://symfony.com/doc/current/form/form_customization.html) that you can include which will render all the form inputs as Vuetify form components. 

```yaml
twig:
    form_themes:
        - '@SolidWorxVuetifyBundle/templates/form/fields.html.twig'
```

#### Radio Switches

In order to use a switch input for radio buttons, you can use the `switch` option that is part of the `RadioType` form type:

```php

<?php

$builder->add(
    'agree',
    RadioType::class,
    [
        'switch' => true
    ]
);
```

This will render the radio button with the `v-switch` component.

#### Date Picker

When using the `'widget' => 'single_text'` option in the `DateType` form type, the input will be transformed to a date picker component.

#### Month Picker

VuetifyBundle comes with a month picker form input, which will render a date picker with only a month selection:

```php
<?php

use SolidWorx\VuetifyBundle\Form\MonthType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'month',
            MonthType::class,
            [
                'widget' => 'single_text'
            ]
        );
    }
}
```