<?php

namespace Iga\OAuthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EventType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('location')
            ->add('start')
            ->add('end')
            ->add('info')
        ;
    }

    public function getName()
    {
        return 'iga_oauthbundle_eventtype';
    }
}