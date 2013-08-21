<?php

namespace Example;

use Herrera\Silex\Application;
use Herrera\Silex\Form\Type\UneditableType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * A simple example controller.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Controller
{
    /**
     * Renders the large example form.
     *
     * @param Application $app     The application.
     * @param Request     $request The request.
     *
     * @return string The rendered view.
     */
    public static function demoView(Application $app, Request $request)
    {
        $form = $app->form();

        // text
        $form->add(
            'text',
            'text',
            array(
                'attr' => array(
                    'placeholder' => 'A simple text field.',
                ),
                'constraints' => new NotBlank(),
                'label' => 'Text'
            )
        );

        // uneditable
        $form->add(
            'uneditable',
            new UneditableType(),
            array(
                'data' => 'This field is not editable.',
                'label' => 'Uneditable'
            )
        );

        // textarea
        $form->add(
            'textarea',
            'textarea',
            array(
                'attr' => array(
                    'placeholder' => 'A multi-line text area.',
                ),
                'label' => 'Text Area'
            )
        );

        // email
        $form->add(
            'email',
            'email',
            array(
                'attr' => array(
                    'placeholder' => 'example@domain.com',
                ),
                'label' => 'Email'
            )
        );

        // integer
        $form->add(
            'integer',
            'integer',
            array(
                'attr' => array(
                    'placeholder' => '1234567890',
                ),
                'label' => 'Integer'
            )
        );

        // money
        $form->add(
            'money',
            'money',
            array(
                'attr' => array(
                    'class' => 'input-medium',
                    'placeholder' => '12,345,678.90'
                ),
                'currency' => 'USD',
                'label' => 'Money'
            )
        );

        // number
        $form->add(
            'number',
            'number',
            array(
                'attr' => array(
                    'placeholder' => '12,345,678.90',
                ),
                'label' => 'Number'
            )
        );

        // password
        $form->add(
            'password',
            'password',
            array('label' => 'Password')
        );

        // percent
        $form->add(
            'percent',
            'percent',
            array(
                'attr' => array(
                    'class' => 'input-mini',
                    'placeholder' => '99',
                ),
                'label' => 'Percent'
            )
        );

        // search
        $form->add(
            'search',
            'search',
            array(
                'attr' => array(
                    'class' => 'input-medium',
                    'placeholder' => 'some search terms',
                ),
                'label' => 'Search'
            )
        );

        // url
        $form->add(
            'url',
            'url',
            array(
                'attr' => array(
                    'placeholder' => 'http://example.com/',
                ),
                'label' => 'URL'
            )
        );

        // choice (select, single)
        $form->add(
            'choice-select-single',
            'choice',
            array(
                'attr' => array(
                    'class' => 'input-small',
                ),
                'choices' => array(
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                    'd' => 'D',
                    'e' => 'E',
                    'f' => 'F',
                ),
                'label' => 'Choice (Select, Single)'
            )
        );

        // choice (select, multiple)
        $form->add(
            'choice-select-multiple',
            'choice',
            array(
                'attr' => array(
                    'class' => 'input-small',
                ),
                'choices' => array(
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                    'd' => 'D',
                    'e' => 'E',
                    'f' => 'F',
                ),
                'label' => 'Choice (Select, Multiple)',
                'multiple' => true
            )
        );

        // choice (expanded, single)
        $form->add(
            'choice-expanded-single',
            'choice',
            array(
                'attr' => array(
                    'class' => 'input-small',
                ),
                'choices' => array(
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                    'd' => 'D',
                    'e' => 'E',
                    'f' => 'F',
                ),
                'expanded' => true,
                'label' => 'Choice (Expanded, Single)'
            )
        );

        // choice (expanded, multiple)
        $form->add(
            'choice-expanded-multiple',
            'choice',
            array(
                'attr' => array(
                    'class' => 'input-small',
                ),
                'choices' => array(
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                    'd' => 'D',
                    'e' => 'E',
                    'f' => 'F',
                ),
                'expanded' => true,
                'label' => 'Choice (Expanded, Multiple)',
                'multiple' => true
            )
        );

        // date (single text)
        $form->add(
            'date-single-text',
            'date',
            array(
                'attr' => array(
                    'class' => 'input-small',
                    'placeholder' => date('Y-m-d'),
                ),
                'label' => 'Date (Single Text)',
                'widget' => 'single_text'
            )
        );

        // date (multiple text)
        $form->add(
            'date-multiple-text',
            'date',
            array(
                'attr' => array(
                    'class' => 'input-mini',
                ),
                'label' => 'Date (Multiple Text)',
                'widget' => 'text'
            )
        );

        // date (choice)
        $form->add(
            'date-choice',
            'date',
            array(
                'attr' => array(
                    'class' => 'input-small',
                ),
                'label' => 'Date (Choice)',
                'widget' => 'choice'
            )
        );

        // date time (text)
        $form->add(
            'datetime-text',
            'datetime',
            array(
                'attr' => array(
                    'class' => 'input-medium',
                    'placeholder' => date('Y-m-d H:i'),
                ),
                'label' => 'Date & Time (Text)',
                'widget' => 'single_text'
            )
        );

        // date time (choice)
        $form->add(
            'datetime-choice',
            'datetime',
            array(
                'attr' => array(
                    'class' => 'input-small',
                    'placeholder' => date('Y-m-d H:i'),
                ),
                'label' => 'Date & Time (Choice)',
                'widget' => 'choice',
                'with_seconds' => true
            )
        );

        // time (single text)
        $form->add(
            'time-single-text',
            'time',
            array(
                'attr' => array(
                    'class' => 'input-small',
                    'placeholder' => date('H:i:s'),
                ),
                'label' => 'Time (Single Text)',
                'widget' => 'single_text',
                'with_seconds' => true
            )
        );

        // time (multiple text)
        $form->add(
            'time-multiple-text',
            'time',
            array(
                'attr' => array(
                    'class' => 'input-mini',
                ),
                'label' => 'Time (Multiple Text)',
                'widget' => 'text',
                'with_seconds' => true
            )
        );

        // time (choice)
        $form->add(
            'time-choice',
            'time',
            array(
                'attr' => array(
                    'class' => 'input-small',
                ),
                'label' => 'Time (Choice)',
                'widget' => 'choice',
                'with_seconds' => true
            )
        );

        // birthday (single text)
        $form->add(
            'birthday-single-text',
            'birthday',
            array(
                'attr' => array(
                    'class' => 'input-small',
                    'placeholder' => date('Y-m-d'),
                ),
                'label' => 'Birthday (Single Text)',
                'widget' => 'single_text'
            )
        );

        // birthday (multiple text)
        $form->add(
            'birthday-multiple-text',
            'birthday',
            array(
                'attr' => array(
                    'class' => 'input-mini',
                ),
                'label' => 'Birthday (Multiple Text)',
                'widget' => 'text'
            )
        );

        // birthday (choice)
        $form->add(
            'birthday-choice',
            'birthday',
            array(
                'attr' => array(
                    'class' => 'input-small',
                ),
                'label' => 'Birthday (Choice)',
                'widget' => 'choice'
            )
        );

        // checkbox
        $form->add(
            'checkbox',
            'checkbox',
            array(
                'label' => 'Checkbox'
            )
        );

        // file
        $form->add(
            'file',
            'file',
            array(
                'label' => 'File'
            )
        );

        // radio
        $form->add(
            'radio',
            'radio',
            array(
                'label' => 'Radio'
            )
        );

        // collection
        $form->add(
            'collection',
            'collection',
            array(
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Collection',
                'options' => array(
                    'attr' => array(
                        'class' => 'input-medium'
                    )
                ),
                'type' => 'text'
            )
        );

        // repeated
        $form->add(
            'repeated',
            'repeated',
            array(
                'first_options' => array(
                    'attr' => array(
                        'class' => 'input-medium'
                    ),
                    'label' => 'Repeated 1'
                ),
                'type' => 'text',
                'second_options' => array(
                    'attr' => array(
                        'class' => 'input-medium'
                    ),
                    'label' => 'Repeated 2'
                ),
            )
        );

        // button
        $form->add(
            'button',
            'button',
            array(
                'attr' => array(
                    'class' => 'btn-info'
                ),
                'label' => 'Button'
            )
        );

        // reset
        $form->add(
            'reset',
            'reset',
            array(
                'attr' => array(
                    'class' => 'btn-warning'
                ),
                'label' => 'Reset'
            )
        );

        // submit
        $form->add(
            'submit',
            'submit',
            array(
                'attr' => array(
                    'class' => 'btn-primary'
                ),
                'label' => 'Submit'
            )
        );

        $form = $form->getForm();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);
        }

        return $app->render(
            'example-form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Renders the example view.
     *
     * @param Application $app     The application.
     * @param Request     $request The request.
     *
     * @return string The rendered view.
     */
    public static function nameView(Application $app, Request $request)
    {
        $form = $app->form(
            null,
            array(
                'intention' => 'example'
            )
        );

        $form
            ->add(
                'name',
                'text',
                array(
                    'attr' => array(
                        'class' => 'input-medium',
                        'placeholder' => 'Your name'
                    ),
                    'constraints' => new NotBlank(),
                    'data' => 'world'
                )
            )
            ->add(
                'locale',
                new UneditableType(),
                array(
                    'attr' => array(
                        'class' => 'input-medium',
                    ),
                    'data' => $app['locale']
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
            );

        $form = $form->getForm();
        $name = 'world';

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
                'name' => $name
            )
        );
    }
}
