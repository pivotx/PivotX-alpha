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
            ->add('dateValue', 'datetime', array('widget' => 'single_text'))
            ->add('date', 'datetime', array('widget' => 'single_text'))
            ->add('originCreator', 'text', array('required'=>false))
            ->add('content', 'choice', array('required'=>false))
            ->add('contenttype', 'entity', array('class' => 'PivotXCoreBundle:Contenttype', "required" => false ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_extrafieldtype';
    }
}
