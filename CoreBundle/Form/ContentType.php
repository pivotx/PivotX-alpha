<?php

namespace PivotX\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('reference')
            ->add('grouping')
            ->add('title')
            ->add('teaser')
            ->add('body')
            ->add('template')
            ->add('dateCreated')
            ->add('dateModified')
            ->add('datePublished')
            ->add('dateDepublished')
            ->add('datePublishOn')
            ->add('dateDepublishOn')
            ->add('language')
            ->add('version')
            ->add('status')
            ->add('searchable')
            ->add('locked')
            ->add('originUrl')
            ->add('originCreator')
            ->add('textFormatting')
            ->add('allowResponses')
            ->add('contenttype')
            ->add('user')
        ;
    }

    public function getName()
    {
        return 'pivotx_corebundle_contenttype';
    }
}
