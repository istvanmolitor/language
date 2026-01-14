<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { ref } from 'vue';
import { trans } from 'laravel-vue-i18n';
import { route } from '@/lib/route';

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

const search = ref(props.filters.search || '');

// Translation helper
const t = (key: string) => trans(key);

const breadcrumbs: BreadcrumbItem[] = [
    { title: t('language::common.group'), href: '#' },
    { title: t('language::language.title'), href: route('language.admin.languages.index') },
];

const handleSearch = () => {
    router.get(route('language.admin.languages.index'), {
        search: search.value,
        sort: props.filters.sort,
        direction: props.filters.direction,
    }, {
        preserveState: true,
        replace: true,
    });
};

const sortBy = (column: string) => {
    let direction: 'asc' | 'desc' = 'asc';
    if (props.filters.sort === column && props.filters.direction === 'asc') {
        direction = 'desc';
    }
    router.get(route('language.admin.languages.index'), {
        search: search.value,
        sort: column,
        direction: direction,
    }, {
        preserveState: true,
        replace: true,
    });
};

const getSortIcon = (column: string) => {
    if (props.filters.sort !== column) return '↕️';
    return props.filters.direction === 'asc' ? '↑' : '↓';
};

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

            <div class="flex gap-2">
                <Input
                    v-model="search"
                    type="text"
                    :placeholder="t('language::language.placeholders.search')"
                    class="max-w-sm"
                    @keyup.enter="handleSearch"
                />
                <Button @click="handleSearch">{{ t('language::language.actions.search') }}</Button>
            </div>

            <div class="rounded-lg border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="cursor-pointer select-none" @click="sortBy('code')">
                                {{ t('language::language.table.code') }} {{ getSortIcon('code') }}
                            </TableHead>
                            <TableHead class="cursor-pointer select-none" @click="sortBy('name')">
                                {{ t('language::language.table.name') }} {{ getSortIcon('name') }}
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
                    @click="router.get(route('language.admin.languages.index'), { page, search: search })"
                >
                    {{ page }}
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
