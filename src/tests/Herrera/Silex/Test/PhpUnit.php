<?php

namespace Herrera\Silex\Test;

use Silex\Application;
use Silex\ServiceProviderInterface;

class PhpUnit implements ServiceProviderInterface
{
    public function boot(Application $app)
    {
        $app['phpunit.boot'] = true;
    }

    public function register(Application $app)
    {
        $app['phpunit.register'] = true;
    }
}
