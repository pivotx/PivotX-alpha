<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContenttypeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('reference')
            ->add('name')
            ->add('description')
            ->add('extrafields')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_contenttypetype';
    }
}
