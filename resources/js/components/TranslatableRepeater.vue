<script setup lang="ts">
import { computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Plus, Trash2, ChevronDown } from 'lucide-vue-next';
import { trans } from 'laravel-vue-i18n';

interface Language {
    id: number;
    code: string;
    enabled: boolean;
}

interface TranslatableItem {
    languageId: number;
    languageCode: string;
}

interface Props {
    availableLanguages: Language[];
    modelValue: TranslatableItem[];
    label?: string;
}

const props = defineProps<Props>();

const emit = defineEmits<{
    'update:modelValue': [value: TranslatableItem[]];
}>();

const displayLabel = computed(() => props.label || trans('language::language.form.translations'));

const items = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});

const availableLanguagesForAdd = computed(() => {
    const usedLanguageIds = new Set(items.value.map((item) => item.languageId));
    return props.availableLanguages.filter(
        (lang) => !usedLanguageIds.has(lang.id),
    );
});

const addTranslation = (language: Language) => {
    items.value = [
        ...items.value,
        {
            languageId: language.id,
            languageCode: language.code,
        },
    ];
};

const removeTranslation = (index: number) => {
    items.value = items.value.filter((_, i) => i !== index);
};

const getLanguageCode = (languageId: number) => {
    return (
        props.availableLanguages.find((lang) => lang.id === languageId)?.code ||
        ''
    );
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">{{ displayLabel }}</h2>

            <DropdownMenu v-if="availableLanguagesForAdd.length > 0">
                <DropdownMenuTrigger as-child>
                    <Button type="button" size="sm" variant="outline">
                        <Plus class="size-4" />
                        Add Translation
                        <ChevronDown class="size-4" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuItem
                        v-for="lang in availableLanguagesForAdd"
                        :key="lang.id"
                        @click="addTranslation(lang)"
                    >
                        {{ lang.code }}
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>

        <div
            v-if="items.length === 0"
            class="rounded border border-dashed p-4 text-center text-sm text-muted-foreground"
        >
            No translations added yet. Click "Add Translation" to start.
        </div>

        <div
            v-for="(item, index) in items"
            :key="index"
            class="relative space-y-2 rounded border p-4"
        >
            <div class="mb-2 flex items-center justify-between">
                <Label class="text-sm font-medium">{{
                    getLanguageCode(item.languageId)
                }}</Label>
                <Button
                    type="button"
                    size="icon-sm"
                    variant="ghost"
                    @click="removeTranslation(index)"
                    class="text-destructive hover:text-destructive"
                >
                    <Trash2 class="size-4" />
                </Button>
            </div>

            <slot
                :language-id="item.languageId"
                :index="index"
                :language-code="item.languageCode"
            />
        </div>
    </div>
</template>
