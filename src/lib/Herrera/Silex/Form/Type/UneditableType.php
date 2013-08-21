<?php

namespace Herrera\Silex\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Adds an uneditable field type to the form.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UneditableType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'uneditable';
    }
}
