<?php

namespace App\Http\Services\Dashboard\Mark;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\Eloquent\ModelRepository;
use App\Repository\MarkRepositoryInterface;
use App\Repository\ModelRepositoryInterface;
use Illuminate\Support\Facades\DB;

class MarkService
{
    public function __construct(
        private readonly MarkRepositoryInterface $markRepository,
        private readonly ModelRepositoryInterface $modelRepository,
    private readonly FileManagerService $fileManagerService
    )
    {
    }

    public function index()
    {
        $marks = $this->markRepository->paginate(50);
        return view('dashboard.site.marks.index', compact('marks'));
    }
    public function getModels($mark_id)
    {
        $models = $this->modelRepository->getModelsByMark($mark_id);
        return view('dashboard.site.models.index', compact('models','mark_id'));
    }
    public function create()
    {
        return view('dashboard.site.marks.create');
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('logo');
            $data['show_home']=$request->has('show_home') ? 1 : 0;
            $data['important']=$request->has('important') ? 1 : 0;
            if($request->logo)
                $data['logo']=$this->fileManagerService->upload('logo','cars');
            $mark = $this->markRepository->create($data);
            DB::commit();
            return redirect()->route('marks.index', $mark->id)->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
    public function show($id)
    {
        $mark = $this->markRepository->getById($id);
        return view('dashboard.site.marks.show', compact('mark'));
    }
    public function edit($id)
    {
        $mark = $this->markRepository->getById($id);
        return view('dashboard.site.marks.edit', compact('mark'));
    }

    public function update($request, $id)
    {
        try {
            $data = $request->except('logo');
            $data['show_home']=$request->has('show_home') ? 1 : 0;
            $data['important']=$request->has('important') ? 1 : 0;
            if($request->logo)
                $data['logo']=$this->fileManagerService->upload('logo','cars');
            $this->markRepository->update($id, $data);
            return redirect()->route('marks.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->markRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
