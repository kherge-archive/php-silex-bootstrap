<?php

namespace Example\Tests;

use Example\Controller;
use Herrera\PHPUnit\TestCase;
use Herrera\Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ControllerTest extends TestCase
{
    /**
     * @var Application
     */
    private $app;

    public function getLocale()
    {
        $locales = array();
        $request = function ($locale) {
            $request = Request::create('/');
            $request->setLocale($locale);

            return $request;
        };

        $locales[] = array(
            'Hallo Welt!',
            $request('de')
        );

        $locales[] = array(
            'Hello, world!',
            $request('en')
        );

        $locales[] = array(
            'Bonjour tout le monde!',
            $request('fr')
        );

        return $locales;
    }

    /**
     * @dataProvider getLocale
     */
    public function testShowView($expected, $request)
    {
        $this->assertEquals(
            $expected,
            trim($this->app->handle($request)->getContent())
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
