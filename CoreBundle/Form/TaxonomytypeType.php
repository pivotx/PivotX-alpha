<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TaxonomytypeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug', 'text')
            ->add('reference', 'text')
            ->add('name', 'text')
            ->add('description', 'text')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_taxonomytypetype';
    }
}
