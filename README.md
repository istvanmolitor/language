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

### DataTable – fordított mezők kereshetővé/rendezhetővé tétele

Ha egy `TranslatableModel`-alapú entitás DataTable osztályában a fordított mezők (pl. `name`) kereshetőek vagy rendezhetőek kell legyenek, a `query()` metódusban használd a `TranslatableModel` scope-jait:

```php
public function query(Builder $query): Builder
{
    return $query->joinTranslation()->selectBase();
}
```

Ezután az oszlopdefinícióban normálisan megadható a `->setSearchable()` és `->setOrderable()`:

```php
$this->addColumn('name')->setLabel('Név')->setSearchable()->setOrderable();
```

- `joinTranslation()` – leftJoin a fordítások táblájára az aktuális nyelv szerint, és betölti a `translations` kapcsolatot
- `selectBase()` – `{table}.*` select az alaptáblára, hogy ne legyen oszlopütközés a joinolt mezőkkel

### Breadcrumb telepítése

A language modul breadcrumbs.php fileját regisztrálni kell a configs/breadcrumbs.php fileban.
```php
<?php
'files' => [
    base_path('/vendor/molitor/language/src/routes/breadcrumbs.php'),
],
```
