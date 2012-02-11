<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('responseType')
            ->add('title')
            ->add('body')
            ->add('name')
            ->add('email')
            ->add('url')
            ->add('ip')
            ->add('dateCreated')
            ->add('status')
            ->add('originUrl')
            ->add('originCreator')
            ->add('content')
            ->add('user')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_responsetype';
    }
}
