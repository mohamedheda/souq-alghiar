<?php

namespace App\Http\Controllers\Dashboard\Model;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Model\ModelRequest;
use App\Http\Services\Dashboard\Model\ModelService;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function __construct(private readonly ModelService $modelService)
    {
    }


    public function show($id)
    {
        return $this->modelService->show($id);
    }

    public function create($mark_id)
    {
        return $this->modelService->create($mark_id);
    }

    public function store(ModelRequest $request)
    {
        return $this->modelService->store($request);
    }

    public function edit(string $id)
    {
        return $this->modelService->edit($id);
    }

    public function update(ModelRequest $request, string $id)
    {
        return $this->modelService->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->modelService->destroy($id);
    }
}
