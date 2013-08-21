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

    public function testFormView()
    {
        $client = $this->createClient();
        $request = $client->request('POST', '/form');
        $response = $client->submit(
            $request
                ->selectButton('Submit')
                ->form()
        );

        $html = $response->html();

        $this->assertContains('Submit', $html);
        $this->assertContains('text-error', $html);
    }

    /**
     * @dataProvider getLocale
     */
    public function testShowView($expected, $locale, $name = null)
    {
        $client = $this->createClient(
            array(
                'HTTP_ACCEPT_LANGUAGE' => $locale
            )
        );

        $request = $client->request('GET', '/');

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
