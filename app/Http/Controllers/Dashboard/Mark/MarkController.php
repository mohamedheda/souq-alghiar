<?php

namespace App\Http\Controllers\Dashboard\Mark;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Mark\MarkRequest;
use App\Http\Services\Dashboard\Mark\MarkService;

class MarkController extends Controller
{
    public function __construct(private readonly MarkService $user)
    {
    }

    public function index()
    {
        return $this->user->index();
    }

    public function show($id)
    {
        return $this->user->show($id);
    }
    public function getModels($id)
    {
        return $this->user->getModels($id);
    }

    public function create()
    {
        return $this->user->create();
    }

    public function store(MarkRequest $request)
    {
        return $this->user->store($request);
    }

    public function edit(string $id)
    {
        return $this->user->edit($id);
    }

    public function update(MarkRequest $request, string $id)
    {
        return $this->user->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->user->destroy($id);
    }
}
