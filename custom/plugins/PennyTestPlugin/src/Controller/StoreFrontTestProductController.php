<?php

namespace PennyTestPlugin\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\NoContentResponse;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SalesChannel\StoreApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"store-api"})
 */
class StoreFrontTestProductController extends AbstractController
{
    /**
     * @Route(path="/store-api/penny/{productId}", name="store-api.penny", methods={"GET"})
     *
     * @param string $productId
     * @param SalesChannelContext $context
     *
     * @return StoreApiResponse
     */
    public function getTestproduct(string $productId, SalesChannelContext $context): StoreApiResponse
    {
        return new NoContentResponse();
    }
}
