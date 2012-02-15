<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('type', 'text')
            ->add('editUsers', 'checkbox', array('required' => false))
            ->add('value', 'text', array('required' => false))
            ->add('contenttype', 'entity', array('class' => 'PivotXCoreBundle:ContentType', "required" => false ))
            ->add('taxonomy', 'entity', array('class' => 'PivotXCoreBundle:Taxonomy', "required" => false ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_permissiontype';
    }
}
