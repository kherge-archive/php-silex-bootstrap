<?php

namespace Herrera\Silex\Test;

use Herrera\Silex\Application;
use Silex\WebTestCase;

/**
 * Test case for the bootstrap application.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class TestCase extends WebTestCase
{
    /**
     * @override
     */
    public function createApplication()
    {
        return Application::create(
            array(
                'debug' => true,
                'mode' => 'test',
            )
        );
    }
}
