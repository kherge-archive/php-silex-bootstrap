<?php

namespace Herrera\Silex\Tests;

use Herrera\PHPUnit\TestCase;
use Herrera\Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ApplicationTest extends TestCase
{
    /**
     * @var Application
     */
    private $app;

    public function testConstruct()
    {
        $this->app->boot();

        $this->assertTrue($this->app['debug']);
        $this->assertEquals('test', $this->app['mode']);
        $this->assertTrue($this->app['phpunit']);
        $this->assertTrue($this->app['phpunit.boot']);
        $this->assertTrue($this->app['phpunit.register']);

        $response = $this->app->handle(
            Request::create('/test')
        );

        $this->assertEquals('Tested!', $response->getContent());
    }

    public function testCreate()
    {
        $app = Application::create(
            array(
                'rand' => $rand = rand()
            )
        );

        $this->assertInstanceOf(
            'Herrera\\Silex\\Application',
            $app
        );

        $this->assertEquals($rand, $app['rand']);
    }

    protected function setUp()
    {
        putenv('APP_DEBUG=1');
        putenv('APP_MODE=test');

        $this->app = new Application();
    }
}
