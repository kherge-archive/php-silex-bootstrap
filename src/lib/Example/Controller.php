<?php

namespace Example;

use Herrera\Silex\Application;

/**
 * A simple example controller.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Controller
{
    /**
     * Renders the example view.
     */
    public static function showView(Application $app)
    {
        return $app->render('example.html.twig');
    }
}
