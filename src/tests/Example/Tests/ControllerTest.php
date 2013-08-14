<?php

namespace Example\Tests;

use Example\Controller;
use Herrera\PHPUnit\TestCase;
use Herrera\Silex\Application;

class ControllerTest extends TestCase
{
    /**
     * @var Application
     */
    private $app;

    public function testShowView()
    {
        $response = Controller::showView($this->app);

        $this->assertEquals(
            'Example page.',
            trim($response->getContent())
        );
    }

    protected function setUp()
    {
        $this->app = new Application(
            array(
                'debug' => true,
                'mode' => 'test',
            )
        );
    }
}
