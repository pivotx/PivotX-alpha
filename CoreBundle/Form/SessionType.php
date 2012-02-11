<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('ip')
            ->add('date')
            ->add('user')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_sessiontype';
    }
}
