<?php

namespace Example;

use Herrera\Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * A simple example controller.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Controller
{
    /**
     * Renders the example view.
     *
     * @param Application $app     The application.
     * @param Request     $request The request.
     *
     * @return string The rendered view.
     */
    public static function showView(Application $app, Request $request)
    {
        $name = 'world';
        $form = $app
            ->form()
            ->add(
                'name',
                'text',
                array(
                    'attr' => array(
                        'class' => 'input-medium',
                        'placeholder' => 'Your name'
                    ),
                    'required' => false
                )
            )
            ->add(
                'set',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn-primary'
                    )
                )
            )
            ->getForm();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $name = $data['name'];
            }
        }

        return $app->render(
            'example.html.twig',
            array(
                'form' => $form->createView(),
                'name' => $name,
            )
        );
    }
}
