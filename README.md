# Language modul

Nyelvek kezelése

## Előfeltételek

Telepíteni kell a következő modulokat.:
- https://gitlab.com/molitor/user

## Telepítés

### Provider regisztrálása
config/app.php
```php
'providers' => ServiceProvider::defaultProviders()->merge([
    /*
    * Package Service Providers...
    */
    \Molitor\Language\Providers\LanguageServiceProvider::class,
])->toArray(),
```

### Seeder regisztrálása

database/seeders/DatabaseSeeder.php
```php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
        ]);
    }
}
```

### Menüpont megjelenítése az admin menüben

Ma a Menü modul telepítve van akkor meg lehet jeleníteni az admin menüben.

```php
<?php
//Menü builderek listája:
return [
    \Molitor\Language\Services\Menu\LanguageMenuBuilder::class
];
```

### Breadcrumb telepítése

A language modul breadcrumbs.php fileját regisztrálni kell a configs/breadcrumbs.php fileban.
```php
<?php
'files' => [
    base_path('/vendor/molitor/language/src/routes/breadcrumbs.php'),
],
```
