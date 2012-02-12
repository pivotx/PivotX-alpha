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
            ->add('reference')
            ->add('name')
            ->add('description')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_taxonomytypetype';
    }
}
