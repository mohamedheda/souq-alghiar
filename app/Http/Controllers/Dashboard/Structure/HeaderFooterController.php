<?php

namespace App\Http\Controllers\Dashboard\Structure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Structure\HeaderFooterRequest;
use Illuminate\Http\Request;

class HeaderFooterController extends StructureController
{
    protected string $contentKey = 'header-footer';
    protected array $locales = ['en', 'ar'];

    protected function store(HeaderFooterRequest $request)
    {
        return parent::_store($request);
    }
}
