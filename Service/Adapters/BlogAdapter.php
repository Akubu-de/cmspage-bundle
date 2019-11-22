<?php

namespace Nfq\CmsPageBundle\Service\Adapters;

use Nfq\CmsPageBundle\Entity\CmsPage;
use Nfq\CmsPageBundle\Form\CmsBlogType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CmsAdapter
 * @package Nfq\CmsPageBundle\Service\Adapters
 */
class BlogAdapter extends AbstractAdapter
{
    /**
     * @cons string
     */
    const TYPE = 'blog';

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType()
    {
        return new CmsBlogType();
    }

    /**
     * {@inheritdoc}
     */
    public function modifyForm(FormBuilderInterface $builder)
    {
        parent::modifyForm($builder);

        $builder->remove('metaTitle');
        $builder->remove('metaDescription');
        $builder->remove('text_simple');
        $builder->remove('places_config');
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
