<?php

namespace App\Services;

use App\Entity\Brand;
use App\Entity\Model;
use App\Interfaces\BrandInterface;
use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Request;

class BrandService implements BrandInterface
{

    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        return $this->brandRepository = $brandRepository;
    }
    public function listBrands()
    {
        return $this->brandRepository->findAll();
    }

    public function createBrand(Request $request)
    {
        $name = $request->get('name');

        if(!$name){
            return;
        }

        try{
            $brand = new Brand();
            $brand->setName($name);
            return $this->brandRepository->save($brand);
        }catch (\Exception $exception){
            return $exception;
        }

    }

    public function updateBrand(Request $request, $id)
    {
        $brand = $this->brandRepository->find($id);
        if(!$brand){
            return;
        }

        $name = $request->get('name');

        if(!$name){
            return;
        }

        try{
            $brand->setName($name);

            return $this->brandRepository->save($brand);
        }catch (\Exception $exception){
            return $exception;
        }
    }

    public function deleteBrand($id)
    {
        $brand = $this->brandRepository->find($id);
        if(!$brand){
            return;
        }
        try {
            $this->brandRepository->delete($brand);
        }catch (\Exception $exception){
            return $exception;
        }
    }
}