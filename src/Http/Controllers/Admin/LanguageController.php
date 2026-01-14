<?php

namespace Molitor\Language\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Molitor\Admin\Controllers\BaseAdminController;
use Molitor\Language\Http\Requests\StoreLanguageRequest;
use Molitor\Language\Http\Requests\UpdateLanguageRequest;
use Molitor\Language\Models\Language;

class LanguageController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $languages = Language::with('translations')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhereHas('translations', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($request->input('sort'), function ($query, $sort) use ($request) {
                $direction = $request->input('direction', 'asc');
                if ($sort === 'name') {
                    $query->joinTranslation()
                        ->orderBy('name', $direction);
                } else {
                    $query->orderBy($sort, $direction);
                }
            }, function ($query) {
                $query->orderBy('code', 'asc');
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Languages/Index', [
            'languages' => $languages,
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    public function create(): Response
    {
        $allLanguages = Language::all();
        return Inertia::render('Admin/Languages/Create', [
            'availableLanguages' => $allLanguages,
        ]);
    }

    public function store(StoreLanguageRequest $request)
    {
        $validated = $request->validated();

        $language = Language::create([
            'code' => $validated['code'],
            'enabled' => $validated['enabled'] ?? true,
        ]);

        foreach ($validated['translations'] as $langId => $translationData) {
            $language->setAttributeTranslation('name', $translationData['name'], $langId);
        }
        $language->save();

        return redirect()->route('language.admin.languages.index')
            ->with('success', __('language::language.messages.created'));
    }

    public function edit(Language $language): Response
    {
        $language->load('translations');
        $allLanguages = Language::all();

        return Inertia::render('Admin/Languages/Edit', [
            'language' => $language,
            'availableLanguages' => $allLanguages,
        ]);
    }

    public function update(UpdateLanguageRequest $request, Language $language)
    {
        $validated = $request->validated();

        $language->update([
            'code' => $validated['code'],
            'enabled' => $validated['enabled'] ?? false,
        ]);

        foreach ($validated['translations'] as $langId => $translationData) {
            $language->setAttributeTranslation('name', $translationData['name'], $langId);
        }
        $language->save();

        return back()->with('success', __('language::language.messages.updated'));
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->route('language.admin.languages.index')
            ->with('success', __('language::language.messages.deleted'));
    }
}
