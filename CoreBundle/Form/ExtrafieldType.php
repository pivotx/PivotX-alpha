<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ExtrafieldType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fieldkey', 'text')
            ->add('textValue', 'text', array("required" => false))
            ->add('floatValue', 'text', array("required" => false))
            ->add('dateValue', 'datetime', array('widget' => 'single_text', "required" => false))
            ->add('date', 'datetime', array('widget' => 'single_text'))
            ->add('originCreator', 'text', array('required'=>false))
            ->add('content', 'entity', array('class' => 'PivotXCoreBundle:Content', "required" => false ))
            ->add('contenttype', 'entity', array('class' => 'PivotXCoreBundle:Contenttype', "required" => false ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_extrafieldtype';
    }
}
