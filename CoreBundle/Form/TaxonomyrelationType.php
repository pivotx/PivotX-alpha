<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TaxonomyrelationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('sortingOrder', 'integer', array('required' => false))
            ->add('parent', 'entity', array('class' => 'PivotXCoreBundle:Taxonomyrelation', "required" => false ))
            ->add('content', 'entity', array('class' => 'PivotXCoreBundle:Content', "required" => true ))
            ->add('taxonomy', 'entity', array('class' => 'PivotXCoreBundle:Taxonomy', "required" => true ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_taxonomyrelationtype';
    }
}
