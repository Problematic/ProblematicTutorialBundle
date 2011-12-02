<?php

namespace Problematic\TutorialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TutorialType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        if (!$options['userIsRegistered']) {
            $builder
                ->add('author_name')
                ->add('author_email')
            ;
        }
        $builder
            ->add('title')
            ->add('description')
            ->add('content')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        $options['userIsRegistered'] = true;

        return $options;
    }

    public function getName()
    {
        return 'problematic_tutorialbundle_tutorialtype';
    }
}
