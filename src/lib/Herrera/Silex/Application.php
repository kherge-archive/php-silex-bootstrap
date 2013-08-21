<?php

namespace Herrera\Silex;

use Herrera\Wise\Silex\WiseTrait;
use Herrera\Wise\WiseServiceProvider;
use Silex\Application as Silex;
use Symfony\Component\HttpFoundation\Request;

/**
 * The bootstrap application class.
 *
 * The bootstrap application class registers the default parameters and
 * services before loading the remaining services, parameters, and routes
 * from the various configuration files. The application is also aware of
 * two environment variables: `APP_DEBUG` and `APP_MODE`.
 *
 * - `APP_DEBUG` &mdash; If set to `1`, the debugging mode will be enabled.
 *   using any other value will default to disabling debugging mode. If the
 *   disabled state must be specified, I recommend using `0` to disable
 *   debugging mode.
 * - `APP_MODE` &mdash; The application mode to run in. By default, `prod`
 *   is used. The value may be anything, but only `dev` and `test` are
 *   recognized by default bootstrap project.
 *
 * The default parameters registered are:
 *
 * - `mode` &mdash; The application mode. (default: `APP_MODE` or `prod`)
 * - `path` &mdash; A list of application paths.
 *     - `base` &mdash; The base application path.
 *     - `cache` &mdash; The cache directory path.
 *       (default: `$base . '/app/cache')
 *     - `config` &mdash; The configuration directory path.
 *       (default: `$base . '/app/config')
 *     - `logs` &mdash; The logs directory path.
 *       (default: `$base . '/app/logs')
 *     - `translations` &mdash; The translations directory path.
 *       (default: `$base . '/app/logs')
 *     - `views` &mdash; The views (or templates) directory path.
 *       (default: `$base . '/app/views')
 *
 * The only default service registered is the `WiseServiceProvider`. This
 * is used for first load the configured parameters, then the services, and
 * finally the routes.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Application extends Silex
{
    use Silex\FormTrait;
    use Silex\MonologTrait;
    use Silex\TranslationTrait;
    use Silex\TwigTrait;
    use Silex\UrlGeneratorTrait;
    use WiseTrait;

    /**
     * @override
     */
    public function __construct(array $values = array())
    {
        if (!isset($values['debug'])) {
            $values['debug'] = ('1' == getenv('APP_DEBUG'));
        }

        if (!isset($values['mode'])) {
            $values['mode'] = getenv('APP_MODE') ? : 'prod';
        }

        parent::__construct($values);

        $this->registerDefaultParameters();
        $this->registerDefaultServices();
        $this->registerDefaultRoutes();

        $this->before(
            function (Request $request) {
                $language = $request->getLanguages();
                $language = array_shift($language);
                $language = preg_split('/[\-_]/', $language);
                $language = array_shift($language);

                $request->setLocale(
                    $this['locale'] = $language
                );

                $this['translator']->setLocale($language);
            }
        );
    }

    /**
     * Creates a new instance of the application.
     *
     * @param array $values The default parameters and services.
     *
     * @return Application The new instance.
     */
    public static function create(array $values = array())
    {
        return new static($values);
    }

    /**
     * Registers the default application parameters.
     */
    protected function registerDefaultParameters()
    {
        $path = isset($this['path']) ? $this['path'] : array();

        if (!isset($path['base'])) {
            $path['base'] = realpath(__DIR__ . '/../../../..');
        }

        $defaults = array(
            'cache' => $path['base'] . '/app/cache',
            'config' => $path['base'] . '/app/config',
            'logs' => $path['base'] . '/app/logs',
            'translations' => $path['base'] . '/app/translations',
            'views' => $path['base'] . '/app/views',
        );

        foreach ($defaults as $key => $value) {
            if (!isset($path[$key])) {
                $path[$key] = $value;
            }
        }

        $this['path'] = $path;
    }

    /**
     * Registers the default application routes.
     */
    protected function registerDefaultRoutes()
    {
        WiseServiceProvider::registerRoutes($this);
    }

    /**
     * Registers the default application services.
     */
    protected function registerDefaultServices()
    {
        $this->register(
            new WiseServiceProvider(),
            array(
                'wise.cache_dir' => $this['path']['cache'] . '/config',
                'wise.path' => $this['path']['config'],
                'wise.options' => array(
                    'config' => array(
                        'routes' => 'routes',
                        'services' => 'services',
                    ),
                    'mode' => $this['mode'],
                    'parameters' => $this,
                    'type' => 'yml',
                )
            )
        );

        $file = 'parameters';

        if ('prod' !== $this['mode']) {
            $file .= '_' . $this['mode'];
        }

        $file .= '.' . $this['wise.options']['type'];

        $parameters = $this->load($file);

        unset($parameters['imports']);

        foreach ($parameters as $key => $value) {
            $this[$key] = $value;
        }

        WiseServiceProvider::registerServices($this);
    }
}
