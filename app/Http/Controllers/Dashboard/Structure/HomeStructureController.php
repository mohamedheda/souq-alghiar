<?php

namespace App\Http\Controllers\Dashboard\Structure;


use App\Http\Requests\Dashboard\Structure\HeaderFooterRequest;
use Illuminate\Http\Request;

class HomeStructureController extends StructureController
{
    protected string $contentKey = 'home';
    protected array $locales = ['en', 'ar'];

    protected function store(HeaderFooterRequest $request)
    {
//        return $request;
        return parent::_store($request);
    }
}
