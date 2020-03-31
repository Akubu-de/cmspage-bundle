<?php

/**
 * This file is part of the "NFQ Bundles" package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nfq\CmsPageBundle\Service\Adapters;

use Nfq\CmsPageBundle\Entity\CmsPage;
use Nfq\CmsPageBundle\Form\CmsPageType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CmsAdapter
 * @package Nfq\CmsPageBundle\Service\Adapters
 */
class LinkAdapter extends AbstractAdapter
{
    /**
     * @cons string
     */
    const TYPE = 'link';

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE;
    }

    /**
     * @param FormBuilderInterface $builder
     */
    public function modifyForm(FormBuilderInterface $builder)
    {
        parent::modifyForm($builder);

        $builder
            ->add('link', UrlType::class, [
                'required' => false,
                'default_protocol' => 'https'
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true
            ]);

        $builder->remove('text_simple');
        $builder->remove('metaDescription');
        $builder->remove('places_config');
        $builder->remove('slug');
        $builder->remove('file');
        $builder->remove('imageAlt');
        $builder->remove('extra');
        $builder->remove('countryCode');
        $builder->remove('places');
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType()
    {
        return new CmsPageType();
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        $entity = new CmsPage();

        $entity->setIsPublic($this->getIsPublic());
        $entity->setContentType(self::TYPE);

        return $entity;
    }
}
