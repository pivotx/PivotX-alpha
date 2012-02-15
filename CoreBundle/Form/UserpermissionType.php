<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserpermissionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('user', 'entity', array('class' => 'PivotXCoreBundle:User', "required" => true ))
            ->add('permission')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_userpermissiontype';
    }
}
