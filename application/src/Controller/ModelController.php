<?php

namespace App\Controller;

use App\Interfaces\ModelInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ModelController
 * @package App\Controller
 * @Rest\Route("model")
 */
class ModelController extends AbstractFOSRestController
{
    private $modelService;
    private $serializer;

    public function __construct(ModelInterface $modelService, SerializerInterface $serializer)
    {
        $this->modelService = $modelService;
        $this->serializer = $serializer;
    }

    /**
     * @Rest\Get("/list")
     * @return JsonResponse
     */
    public function listAction(){
        $models = $this->modelService->listModels();
        $serializedFormat = $this->serializer->serialize($models, 'json', [
            'circular_reference_handler' => function ($object) {
            return $object;
        }]);
        return JsonResponse::fromJsonString($serializedFormat);
    }

    /**
     * @Rest\Post("/create")
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAction(Request $request){
        $create = $this->modelService->createModel($request);

        if($create instanceof \Exception){
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
    public function updateAction(Request $request, $id){
        $update = $this->modelService->updateModel($request, $id);

        if($update instanceof \Exception){
            return new JsonResponse("error", 500);
        }

        return new JsonResponse("success", 200);
    }

    /**
     * @Rest\Delete("/delete/{id}")
     * @param $id
     * @return JsonResponse
     */
    public function deleteAction($id){
        $delete = $this->modelService->deleteModel($id);

        if($delete instanceof \Exception){
            return new JsonResponse("error", 500);
        }

        return new JsonResponse("success", 200);
    }
}