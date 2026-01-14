<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { trans } from 'laravel-vue-i18n';
import { route } from '@/lib/route';
import { AdminFilter } from '@admin/components';
import { useAdminSort } from '@admin/composables/useAdminSort';
import Icon from '@/components/Icon.vue';

interface Translation {
    id: number;
    name: string;
}

interface Language {
    id: number;
    code: string;
    enabled: boolean;
    translations: Translation[];
}

interface Props {
    languages: {
        data: Language[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: {
        search?: string;
        sort?: string;
        direction?: 'asc' | 'desc';
    };
}

const props = defineProps<Props>();

const { sortBy, getSortIcon } = useAdminSort('language.admin.languages.index', props);

// Translation helper
const t = (key: string) => trans(key);

const breadcrumbs: BreadcrumbItem[] = [
    { title: t('language::common.group'), href: '#' },
    { title: t('language::language.title'), href: route('language.admin.languages.index') },
];

const deleteLanguage = (id: number) => {
    if (confirm(t('language::language.messages.confirm_delete'))) {
        router.delete(route('language.admin.languages.destroy', id));
    }
};
</script>

<template>
    <Head :title="t('language::language.title')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">{{ t('language::language.title') }}</h1>
                <Link :href="route('language.admin.languages.create')">
                    <Button>{{ t('language::language.actions.create') }}</Button>
                </Link>
            </div>

            <AdminFilter
                route-name="language.admin.languages.index"
                :filters="filters"
                :placeholder="t('language::language.placeholders.search')"
            />

            <div class="rounded-lg border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="cursor-pointer select-none" @click="sortBy('code')">
                                <div class="flex items-center gap-1">
                                    {{ t('language::language.table.code') }}
                                    <Icon :name="getSortIcon('code')" class="h-4 w-4" />
                                </div>
                            </TableHead>
                            <TableHead class="cursor-pointer select-none" @click="sortBy('name')">
                                <div class="flex items-center gap-1">
                                    {{ t('language::language.table.name') }}
                                    <Icon :name="getSortIcon('name')" class="h-4 w-4" />
                                </div>
                            </TableHead>
                            <TableHead>{{ t('language::language.table.enabled') }}</TableHead>
                            <TableHead class="text-right">{{ t('language::language.table.actions') }}</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="lang in languages.data" :key="lang.id">
                            <TableCell class="font-medium">{{ lang.code }}</TableCell>
                            <TableCell>
                                {{ lang.translations?.[0]?.name || '' }}
                            </TableCell>
                            <TableCell>
                                <Badge :variant="lang.enabled ? 'default' : 'outline'">
                                    {{ lang.enabled ? t('language::language.values.yes') : t('language::language.values.no') }}
                                </Badge>
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Link :href="route('language.admin.languages.edit', lang.id)">
                                        <Button variant="outline" size="sm">{{ t('language::language.actions.edit') }}</Button>
                                    </Link>
                                    <Button variant="destructive" size="sm" @click="deleteLanguage(lang.id)">
                                        {{ t('language::language.actions.delete') }}
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <div v-if="languages.last_page > 1" class="flex justify-center gap-2">
                <Button
                    v-for="page in languages.last_page"
                    :key="page"
                    :variant="page === languages.current_page ? 'default' : 'outline'"
                    size="sm"
                    @click="router.get(route('language.admin.languages.index'), { page, ...filters })"
                >
                    {{ page }}
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
