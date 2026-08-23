# Language modul

Nyelvek kezelése

## Függőségek

- `istvanmolitor/user` – git@github.com:istvanmolitor/user.git
  A nyelvi jogosultságok/DataTable-ok a felhasználókezelésre épülnek.
- `istvanmolitor/admin` – git@github.com:istvanmolitor/admin.git
  Az admin felületi (`LanguageController`, `LanguageDataTable`) integrációhoz.
- `istvanmolitor/menu` – git@github.com:istvanmolitor/menu.git
  A `LanguageMenuBuilder` az admin menübe illeszti a nyelvek menüpontot.

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
    \Molitor\Language\Services\LanguageMenuBuilder::class
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
