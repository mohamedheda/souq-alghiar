<?php

namespace App\Http\Services\Api\V1\Structure;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\Mutual\HelperService;
use App\Http\Traits\Responser;
use App\Repository\StructureRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class StructureService
{
    use Responser;

    protected StructureRepositoryInterface $structureRepository;
    protected GetService $get;
    protected HelperService $helper;

    public function __construct(
        StructureRepositoryInterface $structureRepository,
        GetService $getService,
        HelperService $helper,
    )
    {
        $this->structureRepository = $structureRepository;
        $this->get = $getService;
        $this->helper = $helper;
    }

    public function get($key, $resource = null, array $with = [null => [null]], $data_needed = false)
    {
        $structure = Cache::rememberForever($key,fn() => $this->structureRepository->structure($key));
        if ($structure) {
            $structure = $this->helper->safeArray(json_decode($structure->content)->{app()->getLocale()});
            $withSections = [];
            foreach ($with as $key => $sections) {
                if (is_array($sections)) {
                    foreach ($sections as $section) {
                        $withSections[$key][$section] = $this->getSection($key, $section);
                    }
                }
            }
            if ($data_needed)
                return json_decode(json_encode($structure), true);
            return $this->responseSuccess(data: $resource !== null
                ? new $resource($structure, $withSections)
                : json_decode(json_encode($structure), true) + $withSections
            );
        } else {
            return $this->responseFail();
        }
    }


    private function getSection($key, $section) {
        $structure = $this->structureRepository->structure($key);
        if ($structure?->exists() && $section !== null) {
            return $this->helper->safeArray(json_decode($structure->content)->{app()->getLocale()}->$section) ?? null;
        } else {
            return null;
        }
    }
}
