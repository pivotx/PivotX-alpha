<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContenttypeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug', 'text')
            ->add('reference', 'text')
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('extrafields')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_contenttypetype';
    }
}
