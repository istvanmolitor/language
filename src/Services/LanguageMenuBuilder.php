<?php

declare(strict_types=1);

namespace Molitor\Language\Services;

use Molitor\Menu\Services\Menu;
use Molitor\Menu\Services\MenuBuilder;

class LanguageMenuBuilder extends MenuBuilder
{
    public function init(Menu $menu, string $name, array $params = []): void
    {
        if ($name !== 'admin') {
            return;
        }

        $menu->addItem(__('language::common.languages'), route('language.admin.languages.index'))
            ->setName('languages.list')
            ->setIcon('language');
    }
}
