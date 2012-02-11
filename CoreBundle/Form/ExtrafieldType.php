<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ExtrafieldType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fieldkey')
            ->add('textValue')
            ->add('floatValue')
            ->add('dateValue')
            ->add('originCreator')
            ->add('content')
            ->add('contenttype')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_extrafieldtype';
    }
}
