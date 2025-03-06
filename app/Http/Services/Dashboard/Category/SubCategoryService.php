<?php

namespace App\Http\Services\Dashboard\Category;

use App\Repository\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SubCategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {
    }
    public function create($category_id)
    {
        return view('dashboard.site.sub_categories.create',compact('category_id'));
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('category_id');
            $data['parent_id']=$request->category_id;
            $sub_category = $this->categoryRepository->create($data);
            DB::commit();
            return redirect()->route('categories.sub_categories', $sub_category->parent_id)->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
    public function show($id)
    {
        $sub_category = $this->categoryRepository->getById($id);
        return view('dashboard.site.sub_categories.show', compact('sub_category'));
    }
    public function edit($id)
    {
        $sub_category = $this->categoryRepository->getById($id);
        return view('dashboard.site.sub_categories.edit', compact('sub_category'));
    }

    public function update($request, $id)
    {
        try {
            $sub_category=$this->categoryRepository->getById($id);
            $data = $request->except('category_id');
            $data['parent_id']=$request->category_id;
            $this->categoryRepository->update($id, $data);
            return redirect()->route('categories.sub_categories',$sub_category->parent_id)->with(['success' => __('messages.updated_successfully')]);
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
