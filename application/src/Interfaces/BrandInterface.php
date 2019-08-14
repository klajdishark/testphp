<?php

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface BrandInterface
{
    public function listBrands();
    public function createBrand(Request $request);
    public function updateBrand(Request $request, $id);
    public function deleteBrand($id);
}