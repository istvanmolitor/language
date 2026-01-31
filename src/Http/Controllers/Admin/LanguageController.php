<?php

namespace Molitor\Language\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Molitor\Language\Http\Resources\LanguageResource;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\Language\Http\Requests\StoreLanguageRequest;
use Molitor\Language\Http\Requests\UpdateLanguageRequest;
use Molitor\Language\Models\Language;
use Molitor\Language\Repositories\LanguageRepositoryInterface;
use Molitor\Admin\Controllers\BaseAdminController;

class LanguageController extends BaseAdminController
{
    use HasAdminFilters;

    public function index(Request $request): JsonResponse
    {
        $query = Language::query();

        $languages = $this->applyAdminFilters($query, $request, ['code'])
            ->paginate(10)
            ->withQueryString();

        // Betöltjük a fordításokat minden egyes elemhez a TranslatableModel-en keresztül
        $items = collect($languages->items())->map(function ($language) {
            $language->loadTranslations();
            return $language;
        });

        return response()->json([
            'data' => LanguageResource::collection($items),
            'meta' => [
                'current_page' => $languages->currentPage(),
                'last_page' => $languages->lastPage(),
                'per_page' => $languages->perPage(),
                'total' => $languages->total(),
            ],
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    public function create(LanguageRepositoryInterface $languageRepository): JsonResponse
    {
        $availableLanguages = $languageRepository->getEnabledLanguages();
        $availableLanguages->each->loadTranslations();

        return response()->json([
            'availableLanguages' => LanguageResource::collection($availableLanguages),
        ]);
    }

    public function store(StoreLanguageRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $language = Language::create([
            'code' => $validated['code'],
            'enabled' => $validated['enabled'] ?? true,
        ]);

        foreach ($validated['translations'] as $langId => $translationData) {
            $language->setAttributeTranslation('name', $translationData['name'], (int)$langId);
        }
        $language->save();

        $language->loadTranslations();

        return response()->json([
            'data' => new LanguageResource($language),
            'message' => __('language::language.messages.created'),
        ], 201);
    }

    public function edit(Language $language, LanguageRepositoryInterface $languageRepository): JsonResponse
    {
        $language->loadTranslations();
        $availableLanguages = $languageRepository->getEnabledLanguages();
        $availableLanguages->each->loadTranslations();

        return response()->json([
            'data' => new LanguageResource($language),
            'availableLanguages' => LanguageResource::collection($availableLanguages),
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
            $language->setAttributeTranslation('name', $translationData['name'], (int)$langId);
        }
        $language->save();

        $language->loadTranslations();

        return response()->json([
            'data' => new LanguageResource($language),
            'message' => __('language::language.messages.updated'),
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
