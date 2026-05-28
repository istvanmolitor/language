<?php

namespace Molitor\Language\Tests\Feature;

use Molitor\Language\Providers\LanguageServiceProvider;
use Tests\TestCase;

class PackageSmokeTest extends TestCase
{
    public function test_service_provider_is_loaded(): void
    {
        $this->assertTrue(class_exists(LanguageServiceProvider::class));
        $this->assertTrue($this->app->providerIsLoaded(LanguageServiceProvider::class));
    }
}

