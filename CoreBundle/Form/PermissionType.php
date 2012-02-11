<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('editUsers')
            ->add('value')
            ->add('contenttype')
            ->add('taxonomy')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_permissiontype';
    }
}
