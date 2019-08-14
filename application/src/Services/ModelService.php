<?php

namespace  App\Services;

use App\Entity\Model;
use App\Interfaces\ModelInterface;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ModelService
 * @package App\Services
 */
class ModelService implements ModelInterface
{
    private $modelRepository;

    private $brandRepository;

    public function __construct(ModelRepository $modelRepository, BrandRepository $brandRepository)
    {
        $this->modelRepository = $modelRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return Model[]|object[]
     */
    public function listModels()
    {
        return $this->modelRepository->findAll();
    }

    /**
     * @param Request $request
     * @return \Exception|void
     */
    public function createModel(Request $request)
    {
        $modelName = $request->get('name');
        $brandId = $request->get('brand');

        if(!$modelName && !$brandId){
            return;
        }

        $brand = $this->brandRepository->find($brandId);

        if(!$brand){
            return;
        }

        try{
            $model = new Model();
            $model->setName($modelName);
            $model->setBrand($brand);

            return $this->modelRepository->save($model);
        }catch (\Exception $exception){
            return $exception;
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Exception|void
     */
    public function updateModel(Request $request, $id)
    {
        $model = $this->modelRepository->find($id);
        if(!$model){
            return;
        }

        $modelName = $request->get('name');
        $brandId = $request->get('brand');

        if(!$modelName && !$brandId){
            return;
        }

        $brand = $this->brandRepository->find($brandId);


        if(!$brand){
            return;
        }

        try{
            $model->setName($modelName);
            $model->setBrand($brand);

            return $this->modelRepository->save($model);
        }catch (\Exception $exception){
            return $exception;
        }
    }

    /**
     * @param $id
     * @return \Exception|void
     */
    public function deleteModel($id)
    {
        $model = $this->modelRepository->find($id);
        if(!$model){
            return;
        }
        try {
            $this->modelRepository->delete($model);
        }catch (\Exception $exception){
            return $exception;
        }
    }
}