<?php

namespace App\Controller;

use App\Interfaces\BrandInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class BrandController
 * @package App\Controller
 * @Rest\Route("brand")
 */
class BrandController extends AbstractFOSRestController
{
    private $brandService;
    private $serializer;

    public function __construct(BrandInterface $brandService, SerializerInterface $serializer)
    {
        $this->brandService = $brandService;
        $this->serializer = $serializer;
    }

    /**
     * @Rest\Get("/list")
     * @return JsonResponse
     */
    public function listAction()
    {
        $brands = $this->brandService->listBrands();
        $serializedFormat = $this->serializer->serialize($brands, 'json');
        return JsonResponse::fromJsonString($serializedFormat);
    }

    /**
     * @Rest\Post("/create")
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAction(Request $request)
    {
        $create = $this->brandService->createBrand($request);

        if ($create instanceof \Exception) {
            return new JsonResponse("error", 500);
        }

        return new JsonResponse("success", 200);
    }

    /**
     * @Rest\Put("/update/{id}")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateAction(Request $request, $id)
    {
        $update = $this->brandService->updateBrand($request, $id);

        if ($update instanceof \Exception) {
            return new JsonResponse("error", 500);
        }

        return new JsonResponse("success", 200);
    }

    /**
     * @Rest\Delete("/delete/{id}")
     * @param $id
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        $delete = $this->brandService->deleteBrand($id);

        if ($delete instanceof \Exception) {
            return new JsonResponse("error", 500);
        }

        return new JsonResponse("success", 200);
    }
}