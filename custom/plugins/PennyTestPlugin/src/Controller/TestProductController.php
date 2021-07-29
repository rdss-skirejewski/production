<?php

namespace PennyTestPlugin\Controller;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"api"})
 */
class TestProductController extends AbstractController
{
    /**
     * @Route("/api/_action/testproduct", name="api.action.testproduct", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function createTestProduct(Context $context)
    {
        return new JsonResponse(['success' => true]);
    }
}
