<?php

namespace PennyTestPlugin\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"store-api"})
 */
class StoreFrontTestProductController extends AbstractController
{
    /**
     * @Route(path="/store-api/testproduct/{productId}", name="store-api.testproduct", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function getTestproduct(string $productId, SalesChannelContext $context)
    {
        return new JsonResponse([$productId => true]);
    }
}
