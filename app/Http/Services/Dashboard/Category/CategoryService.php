<?php

namespace App\Http\Services\Dashboard\Category;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly FileManagerService $fileManagerService
    )
    {
    }

    public function index()
    {
        $categories = $this->categoryRepository->paginteCategories(50);
        return view('dashboard.site.categories.index', compact('categories'));
    }
    public function getSubCategories($category_id)
    {
        $sub_categories = $this->categoryRepository->getSubCategories($category_id);
        return view('dashboard.site.sub_categories.index', compact('sub_categories','category_id'));
    }
    public function create()
    {
        return view('dashboard.site.categories.create');
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('image');
            $data['show_home']=$request->has('show_home') ? 1 : 0;
            if($request->image)
                $data['image']=$this->fileManagerService->upload('image','categories');
            $category = $this->categoryRepository->create($data);
            DB::commit();
            return redirect()->route('categories.index', $category->id)->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
    public function show($id)
    {
        $category = $this->categoryRepository->getById($id);
        return view('dashboard.site.categories.show', compact('category'));
    }
    public function edit($id)
    {
        $category = $this->categoryRepository->getById($id);
        return view('dashboard.site.categories.edit', compact('category'));
    }

    public function update($request, $id)
    {
        try {
            $data = $request->except('image');
            $data['show_home']=$request->has('show_home') ? 1 : 0;
            if($request->image)
                $data['image']=$this->fileManagerService->upload('image','categories');
            $this->categoryRepository->update($id, $data);
            return redirect()->route('categories.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
