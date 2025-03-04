<?php

namespace App\Http\Services\Dashboard\Model;

use App\Repository\ModelRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ModelService
{
    public function __construct(
        private readonly ModelRepositoryInterface $modelRepository,
    )
    {
    }
    public function create($mark_id)
    {
        return view('dashboard.site.models.create',compact('mark_id'));
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $model = $this->modelRepository->create($data);
            DB::commit();
            return redirect()->route('marks.models', $model->mark_id)->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
    public function show($id)
    {
        $model = $this->modelRepository->getById($id);
        return view('dashboard.site.models.show', compact('model'));
    }
    public function edit($id)
    {
        $model = $this->modelRepository->getById($id);
        return view('dashboard.site.models.edit', compact('model'));
    }

    public function update($request, $id)
    {
        try {
            $model=$this->modelRepository->getById($id);
            $data = $request->validated();
            $this->modelRepository->update($id, $data);
            return redirect()->route('marks.models',$model->mark_id)->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->modelRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
