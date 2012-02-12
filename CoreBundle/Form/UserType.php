<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug', 'text')
            ->add('reference', 'text')
            ->add('role', 'text')
            ->add('email', 'text')
            ->add('password', 'text')
            ->add('nickname', 'text')
            ->add('fullname', 'text')
            ->add('language', 'text')
            ->add('dateLastseen', 'datetime', array('widget' => 'single_text'))
            ->add('ipLastseen', 'text')
            ->add('media', 'entity', array('class' => 'PivotXCoreBundle:Media', "required" => false ))
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_usertype';
    }
}
