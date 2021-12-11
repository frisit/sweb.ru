<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProjectController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/get-project")
     * @param Request $request
     * @return View
     */
    public function getProject(Request $request): View
    {
        $data = [
            'id' => 1,
            'text' => 'some information to talk'
        ];

        return View::create($data, Response::HTTP_OK);
    }
}