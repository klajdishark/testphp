<?php

namespace  App\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface ModelInterface
{
    public function listModels();
    public function createModel(Request $request);
    public function updateModel(Request $request, $id);
    public function deleteModel($id);
}