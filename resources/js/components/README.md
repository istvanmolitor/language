# TranslatableRepeater Component

## Overview
The `TranslatableRepeater` component is a reusable Vue component designed for managing translatable content across multiple languages. It allows users to dynamically add and remove translations for different languages.

## Features
- **Dynamic Language Selection**: Add translations by selecting available languages from a dropdown
- **Repeatable Items**: Each translation can be individually managed
- **Remove Translations**: Remove unwanted translations with a single click
- **Slot-based Content**: Custom content can be rendered for each translation using Vue slots
- **Reactive Model**: Two-way data binding with v-model

## Usage

### Basic Example

```vue
<template>
  <TranslatableRepeater
    v-model="form.translatableItems"
    :available-languages="availableLanguages"
    :label="t('language::language.form.translations')"
  >
    <template #default="{ languageId, index, languageCode }">
      <div class="space-y-1">
        <Label :for="`name-${languageId}`">{{ t('language::language.form.name') }}</Label>
        <Input
          :id="`name-${languageId}`"
          v-model="form.translations[languageId].name"
          type="text"
          required
        />
        <InputError :message="form.errors[`translations.${languageId}.name`]" />
      </div>
    </template>
  </TranslatableRepeater>
</template>

<script setup lang="ts">
import TranslatableRepeater from '../../../components/TranslatableRepeater.vue';

const form = useForm({
  translations: {},
  translatableItems: []
});
</script>
```

## Props

### `modelValue` (Required)
- **Type**: `TranslatableItem[]`
- **Description**: Array of translatable items with language information
- **Interface**:
  ```typescript
  interface TranslatableItem {
    languageId: number;
    languageCode: string;
  }
  ```

### `availableLanguages` (Required)
- **Type**: `Language[]`
- **Description**: Array of all available languages to choose from
- **Interface**:
  ```typescript
  interface Language {
    id: number;
    code: string;
    enabled: boolean;
  }
  ```

### `label` (Optional)
- **Type**: `string`
- **Default**: `'Translations'`
- **Description**: The heading label for the repeater section

## Slot Props

The default slot receives the following props for each translation item:

- **`languageId`**: The ID of the language for this translation
- **`index`**: The index of the translation in the array
- **`languageCode`**: The language code (e.g., 'en', 'de', 'hu')

## Data Structure

The component expects the form to maintain two separate data structures:

1. **`translatableItems`**: Array of language selections (managed by v-model)
2. **`translations`**: Object containing the actual translation data, keyed by language ID

### Example:

```typescript
const form = useForm({
  // Translation data
  translations: {
    1: { name: 'English' },
    2: { name: 'German' },
    3: { name: 'Hungarian' }
  },
  // Selected languages for the repeater
  translatableItems: [
    { languageId: 1, languageCode: 'en' },
    { languageId: 2, languageCode: 'de' }
  ]
});
```

## Behavior

1. **Adding Translations**: Click "Add Translation" and select a language from the dropdown. Only languages not already added are shown.
2. **Removing Translations**: Click the trash icon next to any translation to remove it.
3. **Empty State**: When no translations are added, a helpful message is displayed.

## Styling

The component uses Tailwind CSS and shadcn/ui components for styling:
- Button, Label, DropdownMenu components
- Lucide icons (Plus, Trash2, ChevronDown)
- Responsive layout with proper spacing

## Requirements

- Vue 3
- Inertia.js (for form handling)
- shadcn/ui components (Button, Label, DropdownMenu)
- lucide-vue-next (for icons)

