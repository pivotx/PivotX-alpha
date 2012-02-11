<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('date')
            ->add('reference')
            ->add('filename')
            ->add('filepath')
            ->add('width')
            ->add('height')
            ->add('filesize')
            ->add('originUrl')
            ->add('originCreator')
            ->add('user')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_mediatype';
    }
}
