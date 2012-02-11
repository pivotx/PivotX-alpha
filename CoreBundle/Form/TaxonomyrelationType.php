<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TaxonomyrelationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('sortingOrder')
            ->add('parent')
            ->add('content')
            ->add('taxonomy')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_taxonomyrelationtype';
    }
}
