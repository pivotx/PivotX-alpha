<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('ip', 'text')
            ->add('sessionkey', 'text')
            ->add('date', 'datetime', array('widget' => 'single_text'))
            ->add('user', 'entity', array('class' => 'PivotXCoreBundle:User', "required" => true ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_sessiontype';
    }
}
