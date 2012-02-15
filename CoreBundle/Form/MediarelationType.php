<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MediarelationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('sortingOrder', 'integer', array('required' => false))
            ->add('content', 'entity', array('class' => 'PivotXCoreBundle:Content', "required" => false ))
            ->add('extrafield', 'entity', array('class' => 'PivotXCoreBundle:Extrafield', "required" => false ))
            ->add('media', 'entity', array('class' => 'PivotXCoreBundle:Media', "required" => false ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_mediarelationtype';
    }
}
