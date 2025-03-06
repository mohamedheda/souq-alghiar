<?php

namespace App\Http\Controllers\Dashboard\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\SubCategoryRequest;
use App\Http\Services\Dashboard\Category\SubCategoryService;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __construct(private readonly SubCategoryService $modelService)
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

    public function store(SubCategoryRequest $request)
    {
        return $this->modelService->store($request);
    }

    public function edit(string $id)
    {
        return $this->modelService->edit($id);
    }

    public function update(SubCategoryRequest $request, string $id)
    {
        return $this->modelService->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->modelService->destroy($id);
    }
}
