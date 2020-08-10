<?php

/**
 * This file is part of the "NFQ Bundles" package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nfq\CmsPageBundle\Controller;

use Nfq\CmsPageBundle\Entity\CmsPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nfq\CmsPageBundle\Service\CmsManager;

/**
 * Class CmsPageController
 * @package Nfq\CmsPageBundle\Controller
 */
class CmsPageController extends AbstractController
{

    private $cms_manager;

    public function __construct(CmsManager $cms_manager)
    {
        $this->cms_manager = $cms_manager;
    }

    /**
     * @var string
     */
    protected $defaultTemplate = '@NfqCmsPage/CmsPage/view.html.twig';

    /**
     * @param Request $request
     * @param string $slug
     * @return Response
     */
    public function viewAction(Request $request, $slug)
    {
        try {
            $entity = $this->getCmsPageManager()->getCmsPage($slug);

            $responseParams = [
                'entity' => clone $entity,
                'isModal' => $this->isSubRequest(),
            ];

            $this->appendResponseParameters($request, $entity, $responseParams);

            return $this->render(
                $this->resolvePageTemplate($entity),
                $responseParams
                );
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        }
    }

    /**
     * Returns true if this is a sub-request
     * @return bool
     */
    protected function isSubRequest()
    {
        return null !== $this->get('request_stack')->getParentRequest();
    }

    /**
     * This method can be used in order to append more parameters to response.
     *
     * @param Request $request
     * @param CmsPage $entity
     * @param array $responseParams
     */
    protected function appendResponseParameters(Request $request, $entity, array &$responseParams)
    {
    }

    /**
     * @return \Nfq\CmsPageBundle\Service\CmsManager
     */
    protected function getCmsPageManager()
    {
        return $this->cms_manager;
    }

    /**
     * @param CmsPage $entity
     * @return string
     */
    protected function resolvePageTemplate(CmsPage $entity)
    {
        $twigTemplateLoader = $this->get('twig')->getLoader();

        $customTemplate = sprintf('NfqCmsPageBundle:CmsPage/_custom:%s.html.twig', $entity->getIdentifier());
        $finalTemplate = $this->defaultTemplate;

        if ($twigTemplateLoader->exists($customTemplate)) {
            $finalTemplate = $customTemplate;
        }

        return $finalTemplate;
    }
}
