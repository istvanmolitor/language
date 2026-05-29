<?php

namespace Molitor\Language\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Molitor\Admin\Http\Controllers\BaseAdminController;
use Molitor\Admin\Http\Resources\DataTableResource;
use Molitor\Admin\Http\Resources\OptionsResource;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\Language\Http\Requests\StoreLanguageRequest;
use Molitor\Language\Http\Requests\UpdateLanguageRequest;
use Molitor\Language\Http\Resources\LanguageResource;
use Molitor\Language\Models\Language;
use Molitor\Language\Repositories\LanguageRepositoryInterface;
use OpenApi\Attributes as OA;

class LanguageController extends BaseAdminController
{
    use HasAdminFilters;

    #[OA\Get(
        path: '/api/admin/languages',
        summary: 'List all languages',
        tags: ['Languages'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Language')
                        ),
                        new OA\Property(
                            property: 'meta',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'current_page', type: 'integer'),
                                new OA\Property(property: 'last_page', type: 'integer'),
                                new OA\Property(property: 'per_page', type: 'integer'),
                                new OA\Property(property: 'total', type: 'integer'),
                            ]
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $query = Language::query();
        $languages = $this->applyAdminFilters($query, $request, ['code'])
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        // Betöltjük a fordításokat minden egyes elemhez a TranslatableModel-en keresztül
        $items = collect($languages->items())->map(function ($language) {
            $language->loadTranslations();

            return $language;
        });

        $languages->setCollection($items);

        return response()->json(new DataTableResource($languages, LanguageResource::class, $request->only(['search', 'sort', 'direction'])));
    }

    #[OA\Get(
        path: '/api/admin/languages/select',
        summary: 'Search languages for select inputs',
        tags: ['Languages'],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', default: 20)),
            new OA\Parameter(name: 'include_disabled', in: 'query', required: false, schema: new OA\Schema(type: 'boolean', default: false)),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Language')
                        ),
                        new OA\Property(
                            property: 'meta',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'current_page', type: 'integer'),
                                new OA\Property(property: 'last_page', type: 'integer'),
                                new OA\Property(property: 'per_page', type: 'integer'),
                                new OA\Property(property: 'total', type: 'integer'),
                            ]
                        ),
                    ]
                )
            ),
        ]
    )]
    public function select(Request $request): JsonResponse
    {
        $search = trim((string) $request->input('search', ''));
        $perPage = max(1, min(500, (int) $request->input('per_page', 20)));
        $includeDisabled = $request->boolean('include_disabled', false);

        $query = Language::query();

        if (! $includeDisabled) {
            $query->where('enabled', true);
        }

        if ($search !== '') {
            $query->where(function ($query) use ($search): void {
                $query->where('code', 'like', '%'.$search.'%');
            });
        }

        $languages = $query
            ->orderBy('code')
            ->paginate($perPage)
            ->withQueryString();

        // Load translations for each item
        $items = collect($languages->items())->map(function ($language) {
            $language->loadTranslations();

            return $language;
        });

        $languages->setCollection($items);

        return response()->json([
            'data' => LanguageResource::collection($languages->items()),
            'meta' => [
                'current_page' => $languages->currentPage(),
                'last_page' => $languages->lastPage(),
                'per_page' => $languages->perPage(),
                'total' => $languages->total(),
            ],
            'filters' => [
                'search' => $search,
                'include_disabled' => $includeDisabled,
            ],
        ]);
    }

    public function create(LanguageRepositoryInterface $languageRepository): JsonResponse
    {
        $availableLanguages = [$languageRepository->getDefaultLanguage()];

        return response()->json([
            'availableLanguages' => LanguageResource::collection($availableLanguages),
        ]);
    }

    #[OA\Post(
        path: '/api/admin/languages',
        summary: 'Store a new language',
        tags: ['Languages'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/StoreLanguageRequest')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/Language'),
                        new OA\Property(property: 'message', type: 'string'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(StoreLanguageRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $language = Language::create([
            'code' => $validated['code'],
            'enabled' => $validated['enabled'] ?? true,
        ]);

        // Mentjük a saját nevét a saját nyelvén
        $language->setAttributeTranslation('name', $validated['native_name'], (int) $language->id);

        foreach ($validated['translations'] as $langId => $translationData) {
            $language->setAttributeTranslation('name', $translationData['name'], (int) $langId);
        }
        $language->save();

        $language->loadTranslations();

        return response()->json([
            'data' => new LanguageResource($language),
            'message' => __('language::language.messages.created'),
        ], 201);
    }

    #[OA\Get(
        path: '/api/admin/languages/{language}/edit',
        summary: 'Show form for editing a language',
        tags: ['Languages'],
        parameters: [
            new OA\Parameter(name: 'language', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/Language'),
                        new OA\Property(
                            property: 'availableLanguages',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Language')
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function edit(Language $language, LanguageRepositoryInterface $languageRepository): JsonResponse
    {
        $language->loadTranslations();
        $availableLanguages = $languageRepository->getAll();
        $availableLanguages->each->loadTranslations();

        return response()->json([
            'data' => new LanguageResource($language),
            'availableLanguages' => LanguageResource::collection($availableLanguages),
        ]);
    }

    #[OA\Put(
        path: '/api/admin/languages/{language}',
        summary: 'Update a language',
        tags: ['Languages'],
        parameters: [
            new OA\Parameter(name: 'language', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateLanguageRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/Language'),
                        new OA\Property(property: 'message', type: 'string'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
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

    #[OA\Get(
        path: '/api/admin/languages/options',
        summary: 'Get languages as options for dropdowns',
        tags: ['Languages'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'value', type: 'integer'),
                                    new OA\Property(property: 'label', type: 'string'),
                                ]
                            )
                        ),
                    ]
                )
            ),
        ]
    )]
    public function options(): JsonResponse
    {
        $languages = Language::query()
            ->where('enabled', true)
            ->orderBy('code')
            ->get();

        $languages->each->loadTranslations();

        return response()->json([
            'data' => $languages->map(function ($language) {
                return new OptionsResource(
                    $language,
                    valueField: 'id',
                    labelField: 'name'
                );
            }),
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
