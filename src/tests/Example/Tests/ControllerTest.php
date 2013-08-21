<?php

namespace Example\Tests;

use Herrera\Silex\Test\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ControllerTest extends TestCase
{
    public function getLocale()
    {
        $locales = array();

        $locales[] = array(
            'Hallo world!',
            'de-DE,de;q=0.5'
        );

        $locales[] = array(
            'Hallo Welt!',
            'de-DE,de;q=0.5',
            'Welt'
        );

        $locales[] = array(
            'Hello, world!',
            'en-US,en;q=0.5'
        );

        $locales[] = array(
            'Bonjour world!',
            'fr-FR,fr;q=0.5'
        );

        $locales[] = array(
            'Bonjour tout le monde!',
            'fr-FR,fr;q=0.5',
            'tout le monde'
        );

        return $locales;
    }

    /**
     * @dataProvider getLocale
     */
    public function testShowView($expected, $locale, $name = null)
    {
        $client = $this->createClient();
        $request = $client->request(
            'GET',
            '/',
            array(),
            array(),
            array('HTTP_ACCEPT_LANGUAGE' => $locale)
        );

        if ($name) {
            $response = $client->submit(
                $request
                    ->selectButton('Set')
                    ->form(array('form[name]' => $name), 'POST')
            )->html();
        } else {
            $response = $request->html();
        }

        $this->assertContains($expected, $response);
    }
}
