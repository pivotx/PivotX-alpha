<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContenttypeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug', 'text', array('required' => false))
            ->add('reference', 'text', array('required' => false))
            ->add('name', 'text')
            ->add('description', 'text', array('required' => false))
            ->add('extrafields')
            ->add('options')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_contenttypetype';
    }
}
