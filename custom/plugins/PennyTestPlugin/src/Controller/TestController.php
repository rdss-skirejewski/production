<?php

namespace PennyTestPlugin\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @RouteScope(scopes={"storefront"})
 */
class TestController extends StorefrontController
{
    /**
     * @Route(
     *     "/test/article/{name}",
     *     name="penny.test.article",
     *     defaults={"auth_required"=false, "name"="Penny"},
     *     methods={"GET"}
     * )
     * @param Request $request
     * @return Response
     */
    public function getArticle(Request $request): Response
    {
        $name = $request->get('name') ?? 'Unknown';
        $message = "Hello $name";

        return $this->renderStorefront(
            '@PennyTestPlugin/storefront/page/example.html.twig',
            [
                'message' => $message,
            ]
        );
    }
}
