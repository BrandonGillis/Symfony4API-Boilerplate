<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Home controller.
 *
 * @Route("/")
 */
class HomeController extends FOSRestController
{
    /**
     * Returns information about who is the user.
     *
     * This is allowed to any fully authenticated user
     *
     * @Rest\Get("/me", name="whoami")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the currently connected user"
     * )
     * 
     * @SWG\Tag(name="home")
     * @Nelmio\Security(name="Bearer")
     */
    public function whoAmI(Request $request)
    {
        if (null !== $this->getUser()) {
            $view = View::create($this->getUser(), Response::HTTP_OK);
            $serializationContext = $view->getContext();
            $serializationContext->addGroup("whoami");

            return $view;
        }
        else {
            return View::create([
                "message" => "Forbidden"
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
