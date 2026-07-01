<?php

namespace Molitor\Language\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Molitor\Admin\Http\Controllers\BaseAdminController;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\Language\DataTables\LanguageDataTable;
use Molitor\Language\DataTables\LanguageSelectDataTable;
use Molitor\Language\Http\Requests\StoreLanguageRequest;
use Molitor\Language\Http\Requests\UpdateLanguageRequest;
use Molitor\Language\Http\Resources\LanguageResource;
use Molitor\Language\Http\Resources\SimpleLanguageResource;
use Molitor\Language\Models\Language;
use Molitor\Language\Repositories\LanguageRepositoryInterface;
use OpenApi\Attributes as OA;

class LanguageController extends BaseAdminController
{
    use HasAdminFilters;

    public function __construct(
        private LanguageRepositoryInterface $languageRepository
    ) {}

    public function index(LanguageDataTable $dataTable): AnonymousResourceCollection
    {
        return $dataTable->getResponse();
    }
    
    public function select(Request $request): AnonymousResourceCollection
    {
        $dataTable = app(LanguageSelectDataTable::class);
        $dataTable->includeDisabled = $request->boolean('include_disabled', false);
        return $dataTable->getResponse();
    }

    public function store(StoreLanguageRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $language = $this->languageRepository->create(
            $validated['code'],
            $validated['enabled'] ?? true,
            $validated['native_name'],
            $validated['translations'],
        );

        $language->loadTranslations();

        return response()->json([
            'data' => new LanguageResource($language),
            'message' => __('language::language.messages.created'),
        ], 201);
    }

    public function edit(Language $language, LanguageRepositoryInterface $languageRepository): JsonResponse
    {
        return response()->json([
            'data' => new LanguageResource($language),
        ]);
    }

    public function update(UpdateLanguageRequest $request, Language $language): JsonResponse
    {
        $validated = $request->validated();

        $language->update([
            'code' => $validated['code'],
            'enabled' => $validated['enabled'] ?? false,
        ]);

        foreach ($validated['translations'] as $langId => $translationData) {
            $language->setAttributeTranslation('name', $translationData['name'], (int) $langId);
        }
        $language->save();

        $language->loadTranslations();

        return response()->json([
            'data' => new LanguageResource($language),
            'message' => __('language::language.messages.updated'),
        ]);
    }

    public function options()
    {
        $languages = $this->languageRepository->getAll();

        return SimpleLanguageResource::collection($languages);
    }

    public function default(LanguageRepositoryInterface $languageRepository): JsonResponse
    {
        $language = $languageRepository->getDefaultLanguage();

        if ($language === null) {
            return response()->json(['data' => null]);
        }

        $language->loadTranslations();

        return response()->json(['data' => new LanguageResource($language)]);
    }

    public function show(Language $language): JsonResponse
    {
        $language->loadTranslations();

        return response()->json([
            'data' => new LanguageResource($language),
        ]);
    }

    public function destroy(Language $language): JsonResponse
    {
        $language->delete();

        return response()->json([
            'message' => __('language::language.messages.deleted'),
        ]);
    }
}
