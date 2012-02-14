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
            ->add('content', 'entity', array('class' => 'PivotXCoreBundle:Content', "required" => false ))
            ->add('taxonomy', 'entity', array('class' => 'PivotXCoreBundle:TaxonomyType', "required" => true ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_taxonomyrelationtype';
    }
}
