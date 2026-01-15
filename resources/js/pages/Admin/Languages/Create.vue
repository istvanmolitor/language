<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';
import TranslatableRepeater from '../../../components/TranslatableRepeater.vue';
import { trans } from 'laravel-vue-i18n';
import { route } from '@/lib/route';

interface Language {
    id: number;
    code: string;
    enabled: boolean;
    translations?: Array<{ id: number; name: string }>;
}

interface Props {
    availableLanguages: Language[];
}

const props = defineProps<Props>();

const form = useForm({
    code: '',
    name: '',
    enabled: true,
    translations: [] as Array<{
        languageId: number;
        languageCode: string;
        name: string;
    }>,
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
        title: t('language::language.create'),
        href: route('language.admin.languages.create'),
    },
];

const submit = () => {
    form.post(route('language.admin.languages.store'));
};
</script>

<template>
    <Head :title="t('language::language.create')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <h1 class="text-2xl font-bold">
                {{ t('language::language.create') }}
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
                    <Label for="name">{{
                        t('language::language.form.native_name')
                    }}</Label>
                    <Input id="name" v-model="form.name" type="text" required />
                    <InputError :message="form.errors.name" />
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

                <TranslatableRepeater
                    v-model="form.translations"
                    :available-languages="availableLanguages"
                >
                    <template #default="{ languageId, index }">
                        <div class="space-y-1">
                            <Label :for="`name-${index}`">{{
                                t('language::language.form.name')
                            }}</Label>
                            <Input
                                :id="`name-${index}`"
                                v-model="form.translations[index].name"
                                type="text"
                                required
                            />
                            <InputError
                                :message="
                                    form.errors[`translations.${index}.name`]
                                "
                            />
                        </div>
                    </template>
                </TranslatableRepeater>

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">
                        {{ t('language::language.actions.create') }}
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
