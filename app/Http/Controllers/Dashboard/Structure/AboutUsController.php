<?php

namespace App\Http\Controllers\Dashboard\Structure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Structure\AboutUsRequest;
use App\Http\Requests\Dashboard\Structure\HeaderFooterRequest;
use Illuminate\Http\Request;

class AboutUsController extends StructureController
{
    protected string $contentKey = 'about-us';
    protected array $locales = ['en', 'ar'];

    protected function store(AboutUsRequest $request)
    {
        return parent::_store($request);
    }
}
