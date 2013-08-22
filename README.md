Silex Bootstrap
===============

[![Build Status][]](https://travis-ci.org/herrera-io/php-silex-bootstrap)

This is a pre-made web application built on the [Silex][] micro-framework and
the [Bootstrap][] front-end framework. The web application is ready to launch
and requires minor alterations to get a new project up and running. I suggest
acquiring a solid understanding of Silex and Bootstrap before proceeding.

Configuration
-------------

### Locations

First, you need to know that parameters, services, and routes are configured
by using [YAML][] configuration files. These files are loaded through a the
[`WiseServiceProvider`][] service provider in the default environment, `prod`:

| What       | Where                       |
| ----------:|:--------------------------- |
| parameters | `app/config/parameters.yml` |
| services   | `app/config/services.yml`   |
| routes     | `app/config/routes.yml`     |

For all other environments that are not named `prod`, configuration files will
have the name of their environment appended to the end of them, but before the
prefix:

| What       | Where                         |
| ----------:|:----------------------------- |
| parameters | `app/config/parameters_*.yml` |
| services   | `app/config/services_*.yml`   |
| routes     | `app/config/routes_*.yml`     |

### Environments

The active environment is controlled by the `APP_MODE` environment variable.
When the variable is not set, the default value of `prod` is used. Currently,
the web application only recognizes three environments:

- `prod` &mdash; Used for live, production web applications.
- `dev` &mdash; Used for debugging the web application.
- `test` &mdash; Used for running `PHPUnit` test suites.

If you intend to use the `dev`, `test`, or any mode intended for debugging or
testing, you will also want to set the `APP_DEBUG` variable to `1` (one). This
will enable debugging mode in Silex.

### Configuring

The `parameters.yml` file defines the application-wide parameters that are
set directly in the Silex instance. Because of how parameters are set in Silex,
you must be careful not to accidentally replace services that use the same name
as one or more of your parameters.

Once the application-wide parameters have been loaded and set, services are
registered from `services.yml`, followed by the routes in `routes.yml`. To
understand how these are configured, you must read up on the documentation
for the [`WiseServiceProvider`][].

### Defaults

These are the services registered by default:

- `Silex\Provider\FormServiceProvider`
- `Silex\Provider\MonologServiceProvider`
- `Silex\Provider\SessionServiceProvider`
- [`Herrera\Silex\Provider\TranslationServiceProvider`][]
- `Silex\Provider\TwigServiceProvider`
- `Silex\Provider\UrlGeneratorServiceProvider`
- `Silex\Provider\ValidatorServiceProvider`

The following services are registered when the `dev` environment is used:

- `Silex\Provider\ServiceControllerServiceProvider`
- `Silex\Provider\WebProfilerServiceProvider`

### Customizing

The `Herrera\Silex\Application` class uses three methods for loading parameters,
services, and routes. These methods can be replaced or extended if configuring
through files is found to be inadequate.

- `registerDefaultParameters()` &mdash; Loads the parameters.
- `registerDefaultServices()` &mdash; Loads the services.
- `registerDefaultRoutes()` &mdash; Loads the routes.

It is likely that you will find that you cannot properly register one or more
services through a configuration file. For cases such as these, you will want
to do something like the following in your child class of `Application`:

```php
use Herrera\Silex\Application;

/**
 * My custom version of the bootstrap application class.
 *
 * @author Example User <example@user.com>
 */
class MyApplication extends Application
{
    /**
     * {@override}
     */
    protected function registerDefaultServices()
    {
        parent::registerDefaultServices();

        // my custom registrations
    }
}
```

> You may also just modify the application class in
> `src/lib/Herrera/Silex/Application`.

If you use create your own class, there are two places you need to update in
order for your class to be used:

1. In `src/lib/Herrera/Silex/Test/TestCase.php`, you will need to modify the
   `TestCase->createApplication()` method so that it returns an instance of
   your class, instead of the default one.
1. In `web/index.php`, you will need to modify the call to the method
   `Herrera\Silex\Application::create()` so that it calls the same method on
   your class.

Console
-------

The web application provides console support through the [`Go`][] build tool.
You can add, edit, and remove your own console commands by editing the `Gofile`
in the root directory.

These are the default commands:

| Command             | Description                                         |
| -------------------:|:--------------------------------------------------- |
| `app:clear`         | Removes the contents of `app/cache` and `app/logs`. |
| `app:clear:cache`   | Removes the contents of `app/cache`.                |
| `app:clear:logs`    | Removes the contents of `app/logs`.                 |
| `app:generate:docs` | Uses [Sami][] to generate API documentation.        |
| `app:minify`        | Uses [Minify][] to minify JS and CSS assets.        |
| `app:run`           | Runs your web application using the PHP web server. |
| `app:test`          | Uses [PHPUnit][] to execute the test suite.         |

### Sami

By default, the Sami settings are in `app/config/docs.php`. Sami is configured
so that the parsed data is stored in `app/cache/docs`, while the final rendered
result is stored in `docs/` in the root directory.

### Minify

By default, the configuration file that manages the list of assets to minify
is found at `app/config/assets.yml`. The configuration file is organized as
a hash of arrays, where the hash key is the path to the target file, and the
values in the array are the files that need to be minified and combined.

### PHPUnit

By default, the test cases are kept in `src/tests`. PHPUnit is configured to
also automatically load classes from that directory if they are not present
in the `src/lib` directory.

To launch PHPUnit:

```
$ bin/go app:test
```

To generate code coverage, simply pass the option `--coverage` (or `-c`). The
task will take care of configuring PHPUnit so that the generated HTML coverage
report is stored in `app/cache/coverage`.

Translations
------------

By default, translation files are stored in `app/translations`. Also by default
the following translation files are registered with the Herrera.io translation
service provider:

- `example.de.yml`
- `example.en.yml`
- `example.fr.yml`

To use your own translation files, I recommend read the documentation on the
`TranslationServiceProvider` service provider. The service provider will allow
you do other things such as specify which loader class you need to register in
order to load your translation files. This means you can use other formats,
such as XLIFF, instead of YAML.

Front-End
---------

The front-end is built using the following:

- Bootstrap 2.3.2
- [Font Awesome][] 3.2.1
- jQuery 1.10.2
- [jQuery Migrate][] 1.2.1
- [Twig][] 1.9+

A custom form theme has also been supplied to make using the horizontal form
design very simple to use. All form types recognized by Bootstrap are supported
by the theme.

```twig
{% extends "layout.html.twig" %}

{% form_theme myForm "form.html.twig" %}

{% block content %}
    <div class="container">
      <div class="row-fluid">
        <div class="span5 pull-both">
          <h1 class="page-header">Example Form</h1>
          {{ form(form) }}
        </div>
      </div>
    </div>
{% endblock %}
```

[Build Status]: https://travis-ci.org/herrera-io/php-silex-bootstrap.png?branch=master
[Silex]: http://silex.sensiolabs.org/
[Bootstrap]: http://getbootstrap.com/2.3.2/
[YAML]: http://www.yaml.org/
[`WiseServiceProvider`]: https://github.com/herrera-io/php-silex-wise
[`Herrera\Silex\Provider\TranslationServiceProvider`]: https://github.com/herrera-io/php-silex-translation-files
[`Go`]: https://github.com/herrera-io/php-go
[Sami]: http://sami.sensiolabs.org
[Minify]: https://github.com/mrclay/minify
[PHPUnit]: http://phpunit.de/manual/current/en/automating-tests.html
[`TranslationServiceProvider`]: https://github.com/herrera-io/php-silex-translation-files
[Font Awesome]: http://fontawesome.io/
[jQuery Migrate]: https://github.com/jquery/jquery-migrate#readme
[Twig]: http://twig.sensiolabs.org/
