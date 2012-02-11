<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('reference')
            ->add('role')
            ->add('email')
            ->add('password')
            ->add('nickname')
            ->add('fullname')
            ->add('language')
            ->add('dateLastseen')
            ->add('ipLastseen')
            ->add('media')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_usertype';
    }
}
