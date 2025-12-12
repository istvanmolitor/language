@php
    /** @var \Molitor\Language\Repositories\LanguageRepositoryInterface $languageRepository */
    $languageRepository = app(\Molitor\Language\Repositories\LanguageRepositoryInterface::class);
    $enabledLanguages = $languageRepository->getEnabledLanguages();
    $current = app()->getLocale();
    $uid = 'lang-switcher-' . uniqid();
@endphp

@if($enabledLanguages->count() > 1)
    <div class="relative">
        <details class="group [&_summary::-webkit-details-marker]:hidden">
            <summary class="inline-flex items-center gap-1 rounded-md px-2 py-1 text-sm border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 cursor-pointer select-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
                </svg>
                <span class="uppercase">{{ $current }}</span>
                <svg class="h-4 w-4 text-slate-500 transition-transform group-open:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>

            <div class="absolute right-0 mt-2 w-44 rounded-md border border-slate-200 bg-white shadow-lg z-20">
                <ul class="py-1" role="listbox" aria-labelledby="{{ $uid }}">
                    @foreach($enabledLanguages as $language)
                        @php $code = $language->code; @endphp
                        <li>
                            <a href="{{ route('language.switch', ['code' => $code]) }}"
                               class="flex items-center gap-2 px-3 py-1.5 text-sm hover:bg-slate-50 {{ $current === $code ? 'text-slate-900 font-medium' : 'text-slate-700' }}">
                                <span class="uppercase">{{ $code }}</span>
                                <span class="truncate">{{ $language->name ?? strtoupper($code) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </details>
    </div>
@endif
