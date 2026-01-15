<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';
import { trans } from 'laravel-vue-i18n';
import { route } from '@/lib/route';
import TranslatableRepeater from '@language/components/TranslatableRepeater.vue';

interface Translation {
    id: number;
    base_language_id: number;
    language_id: number;
    name: string;
}

interface Language {
    id: number;
    code: string;
    enabled: boolean;
    translations: Translation[];
}

interface Props {
    language: Language;
    availableLanguages: Language[];
}

const props = defineProps<Props>();

const form = useForm({
    code: props.language.code,
    enabled: props.language.enabled,
    translations: props.availableLanguages.reduce(
        (acc, lang) => {
            const translation = props.language.translations.find(
                (t) => t.language_id === lang.id,
            );
            acc[lang.id] = { name: translation ? translation.name : '' };
            return acc;
        },
        {} as Record<number, { name: string }>,
    ),
    translatableItems: props.availableLanguages
        .filter((lang) =>
            props.language.translations.some((t) => t.language_id === lang.id),
        )
        .map((lang) => ({
            languageId: lang.id,
            languageCode: lang.code,
        })),
});

// Translation helper
const t = (key: string) => trans(key);

const breadcrumbs: BreadcrumbItem[] = [
    { title: t('language::common.group'), href: '#' },
    {
        title: t('language::language.title'),
        href: route('language.admin.languages.index'),
    },
    {
        title: t('language::language.edit'),
        href: route('language.admin.languages.edit', props.language.id),
    },
];

const submit = () => {
    form.put(route('language.admin.languages.update', props.language.id));
};
</script>

<template>
    <Head :title="t('language::language.edit')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <h1 class="text-2xl font-bold">
                {{ t('language::language.edit') }}
            </h1>

            <form @submit.prevent="submit" class="max-w-2xl space-y-6">
                <div class="space-y-2">
                    <Label for="code">{{
                        t('language::language.form.code')
                    }}</Label>
                    <Input
                        id="code"
                        v-model="form.code"
                        type="text"
                        required
                        maxlength="10"
                    />
                    <InputError :message="form.errors.code" />
                </div>

                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <Checkbox
                            id="enabled"
                            :checked="form.enabled"
                            @update:checked="form.enabled = $event"
                        />
                        <Label for="enabled">{{
                            t('language::language.form.enabled')
                        }}</Label>
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <TranslatableRepeater
                        v-model="form.translatableItems"
                        :available-languages="availableLanguages"
                    >
                        <template
                            #default="{ languageId, index, languageCode }"
                        >
                            <div class="space-y-1">
                                <Label :for="`name-${languageId}`">{{
                                    t('language::language.form.name')
                                }}</Label>
                                <Input
                                    :id="`name-${languageId}`"
                                    v-model="form.translations[languageId].name"
                                    type="text"
                                    required
                                />
                                <InputError
                                    :message="
                                        form.errors[
                                            `translations.${languageId}.name`
                                        ]
                                    "
                                />
                            </div>
                        </template>
                    </TranslatableRepeater>
                </div>

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">
                        {{ t('language::language.actions.update') }}
                    </Button>
                    <Button
                        type="button"
                        variant="outline"
                        @click="router.visit(route('language.index'))"
                    >
                        {{ t('language::language.actions.cancel') }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
