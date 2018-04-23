VuetifyBundle
=============

VuetifyBundle adds support for various [VuetifyJS](https://vuetifyjs.com) components in Symfony

**Note:** This bundle does NOT add the VuetifyJS library to your project. Vuetify should already be included in your project, and a basic Vue instance should be instantiated.
See the [quick start guide](https://vuetifyjs.com/en/getting-started/quick-start) of Vuetify to get started, or follow the [Adding Vuetify](#adding-vuetify) instructions.

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
            new SolidWorx\VuetifyBundle\SolidWorxVuetifyBundle(),
            ...
        ];
        
        ...        
     }
}
```

If you are using Symfony 4 with Flex, then the bundle should automatically be registered.

The bundle can be configured in your app/config.yml file. See the [Configuration Reference](#configuration) for possible configuration values.

### Adding Vuetify

If you do not already have Vuetify installed in your application, then you can follow the these instructions:

```bash
// Using yarn
$ yarn add vuetify

// Using NPM
npm install vuetify --save
```

Register Vuetify inside your main application entrypoint:

```js
import Vuetify from 'vuetify';

Vue.use(Vuetify);
```

### Adding the VuetifyBundle Assets

This bundle comes with assets that provide some additional functionality.

#### Including as a script

To include the compiled JS on your page, you can add the following to your templates:

```twig
<script src="{{ asset('bundles/solidworxvuetify/js/vuetify-bundle.min.js') }}">
```

**Note:** Remember to run the `bin/console assets:install` command

#### Using webpack

If you use webpack (or webpack-encore) you can import the module directly

```js
import VuetifyBundle from 'vendor/solidworx/vuetify-bundle/src/Resources/assets/js';

Vue.use(VuetifyBundle);
```

Usage
-----

### Form Theme

VuetifyBundle comes with a [Symfony form theme](https://symfony.com/doc/current/form/form_customization.html) that you can include which will render all the form inputs as Vuetify form components. 

```yaml
twig:
    form_themes:
        - '@SolidWorxVuetify/Form/fields.html.twig'
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

#### Form Collection

The JS comes with a `form-collection` component that will allow you to add multiple items when using [Symfony's Form Collection](https://symfony.com/doc/current/reference/forms/types/collection.html)

### Alert

You can use the `v_alert` twig function to display alert messages. The function takes three arguments, `message`, `type` and `options`.

This function can be used with Symfony's [flash messages](https://symfony.com/doc/current/controller.html#flash-messages):

```
{% for label, messages in app.flashes %}
    {% for message in messages %}
        {{ v_alert(message, label) }}
    {% endfor %}
{% endfor %}
```

Or standalone:

```twig
    {{ v_alert('Display some important information', 'info', {'outline': true}) }}
```

#### Available Alert Types:

* success
* info
* error
* warning

#### Available Options

| **Option** | **Type** | **Description**
|------------|----------|-----------------
| color | string | Applies specified color to the control
| dismissible | bool | Specifies that the Alert can be closed. The `v-model` option must be set when this is `true` in order for the alert to be disissed
| icon | string | Designates a specific icon
| mode | string | Sets the transition mode
| origin | string | Sets the transition origin
| outline | bool | Alert will have an outline
| transition | string | Sets the component transition. Can be one of the built in transitions or your own
| v-model | string | Applies a Vue model to the alert. When setting `dismissible` to `true`, then this value is required

You can also set default configuration options for the alerts. Configuration can be either global, or you can set options per alert type.
See the [Configuration Reference](#configuration) for more information

## Configuration

Below is the full configuration reference:

```yaml
vuetify:
    alert:

        # Sets global default options for each alert. Options per alert type can be overwritten in the `types` config.
        default:

            # Specifies that the Alert can be closed. The `v-model` option must be set when this is `true` in order for the alert to be dismissed
            dismissible:          false

            # Alert will have an outline
            outline:              false

            # Applies specified color to the control
            color:                null

            # Sets the transition mode
            mode:                 null

            # Sets the component transition. Can be one of the built in transitions or your own
            transition:           null

            # Sets the transition origin
            origin:               null

            # Designates a specific icon
            icon:                 null

        # Sets the default config per alert type. This will overwrite any global config for a specific alert type
        types:
            success:
                dismissible:          false
                outline:              false
                color:                null
                mode:                 null
                transition:           null
                origin:               null
                icon:                 null
            info:
                dismissible:          false
                outline:              false
                color:                null
                mode:                 null
                transition:           null
                origin:               null
                icon:                 null
            error:
                dismissible:          false
                outline:              false
                color:                null
                mode:                 null
                transition:           null
                origin:               null
                icon:                 null
            warning:
                dismissible:          false
                outline:              false
                color:                null
                mode:                 null
                transition:           null
                origin:               null
                icon:                 null
```
