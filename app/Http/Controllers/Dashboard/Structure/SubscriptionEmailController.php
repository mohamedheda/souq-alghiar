<?php

namespace App\Http\Controllers\Dashboard\Structure;

use App\Http\Requests\Dashboard\Structure\SubscriptionEmail\SubscriptionEmailRequest;

class SubscriptionEmailController extends StructureController
{
    protected string $contentKey = 'subscription-email';
    protected array $locales = ['en', 'ar'];

    protected function store(SubscriptionEmailRequest $request)
    {
        return parent::_store($request);
    }
}
