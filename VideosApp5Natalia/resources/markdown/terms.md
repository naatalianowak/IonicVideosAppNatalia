# Guia del Projecte - VideosApp

## Descripció del Projecte

El projecte **VideosApp** és una aplicació web creada utilitzant **Laravel**, amb l'objectiu de gestionar vídeos en una plataforma. Els vídeos tenen atributs com títol, descripció, URL, data de publicació i la relació entre vídeos (anterior i següent). A més, permet organitzar els vídeos en sèries i realitzar operacions CRUD sobre ells.

El projecte es desenvolupa en dos sprints, on cada sprint té objectius específics i funcionalitats a implementar.

## Sprint 1

Durant el primer sprint, es va dur a terme la creació del projecte i la configuració de la base de dades, juntament amb algunes funcionalitats inicials. Els objectius principals van ser:

- **Creació del Projecte Laravel**:
    - Es va crear un nou projecte de Laravel anomenat **VideosApp**.
    - Es van configurar les opcions de Jetstream amb **Livewire**, **PHPUnit**, i **SQLite** com a base de dades.
- **Creació d'Usuaris i Equips**:
    - Es van configurar dos tipus d'usuaris: un usuari per defecte i un professor per defecte.
    - Els usuaris es van associar a un equip utilitzant el sistema d'equips de Jetstream.
- **Creació de Helpers**:
    - Es van crear *helpers* personalitzats per generar els vídeos i usuaris per defecte.
- **Configuració de Proves**:
    - Es van escriure proves utilitzant **PHPUnit** per verificar la creació d'usuaris i l'assignació a equips.

## Sprint 2

Al segon sprint, es van implementar funcionalitats més avançades relacionades amb la gestió de vídeos, incloent la creació de migracions, controladors, models i proves. Els principals objectius van ser:

- **Migració de Videos**:
    - Es va crear la migració per a la taula `videos`, amb camps com `title`, `description`, `url`, `published_at`, `previous`, `next`, i `series_id`.
- **Controlador de Videos**:
    - Es va implementar el **VideosController** amb funcions per mostrar els detalls d'un vídeo i per obtenir els vídeos en diferents formats.
- **Model de Videos**:
    - El model `Video` es va configurar amb tres mètodes que retornen la data de publicació de diferents maneres utilitzant la llibreria **Carbon**:
        - `getFormattedPublishedAtAttribute()`: Mostra la data en format llegible (ex. "13 de gener de 2025").
        - `getFormattedForHumansPublishedAtAttribute()`: Mostra la data en un format relatiu (ex. "fa 2 hores").
        - `getPublishedAtTimestampAttribute()`: Mostra el timestamp Unix de la data de publicació.
- **Creació de la Vista del Video**:
    - Es va crear la vista per mostrar els detalls d'un vídeo, incloent el seu títol, descripció i la data de publicació.
- **Proves de Videos**:
    - Es van crear proves per verificar la correcta creació i visualització dels vídeos.
    - Es van verificar la correcta funcionalitat dels mètodes de format de data i la visualització de vídeos a través de proves unitàries i d'integració.
- **Implementació d'Eines d'Anàlisi de Codi**:
    - Es va instal·lar i configurar **Larastan** per detectar errors en el codi i millorar la qualitat del mateix.

## Sprint 3

- **Corregir errors del 2n sprint:**
    - Vaig començar corregint els errors del segon sprint que havien aparegut durant les proves inicials.
- **Instal·lació del paquet `spatie/laravel-permission`:**
    - Vaig instal·lar aquest paquet per gestionar els permisos i rols dels usuaris a l'aplicació. Seguint les instruccions de la [documentació d'instal·lació](https://spatie.be/docs/laravel-permission/v6/installation-laravel), vaig afegir-lo correctament al projecte.
- **Migració per afegir el camp `super_admin` a la taula `users`:**
    - Vaig crear una migració per afegir el camp `super_admin` a la taula d'usuaris, per poder identificar quins usuaris tenen el rol de superadministrador.
- **Actualització del Model `User`:**
    - Al model d'usuaris, vaig afegir les funcions `testedBy()` i `isSuperAdmin()` per facilitar la verificació de permisos i rols.
- **Afegir el superadmin al professor a la funció `create_default_professor`:**
    - Vaig actualitzar aquesta funció a `helpers` per afegir el superadmin al professor per defecte i separar la creació de l'equip del codi de creació dels usuaris mitjançant la nova funció `add_personal_team()`.
- **Creació de funcions per a usuaris regulars i de gestió de vídeos:**
    - Vaig crear diverses funcions per crear usuaris regulars, gestors de vídeos i superadministradors. Això inclou funcions com `create_regular_user()`, `create_video_manager_user()`, i `create_superadmin_user()` amb valors predeterminats per cada tipus d'usuari.
- **Definir polítiques i portes d'accés a `AppServiceProvider`:**
    - A la funció `book` de `AppServiceProvider`, vaig registrar les polítiques d'autorització i definir les portes d'accés per controlar qui pot veure o modificar què a l'aplicació.
- **Posar permisos i usuaris per defecte al `DatabaseSeeder`:**
    - Vaig afegir els permisos i usuaris (superadmin, regular user i video manager) al `DatabaseSeeder`, per garantir que aquests usuaris estiguin disponibles a la base de dades inicialment.
- **Publicar els stubs per personalitzar-los:**
    - Vaig seguir la guia per [personalitzar els stubs](https://laravel-news.com/customizing-stubs-in-laravel) per adaptar el codi generat per Laravel a les necessitats del projecte.
- **Crear el test 'VideoManagerTest' per provar les funcions del gestor de vídeos:**
    - Vaig crear un nou test per provar les funcions del gestor de vídeos, com ara la creació, edició i eliminació de vídeos. Aquest test va ser útil per verificar que les funcions del gestor de vídeos funcionaven correctament.
- **Crear el test `UserTest`:**
    - A la carpeta `tests/Unit`, vaig crear el test `UserTest` i vaig afegir la funció `isSuperAdmin()` per verificar que es detectés correctament si un usuari és superadministrador.
- **Afegir un registre a `resources/markdown/terms`:**
    - Vaig actualitzar el fitxer de termes per incloure tot el que s'ha fet fins al moment en aquest sprint, per mantenir la documentació al dia.
- **Comprovar els fitxers amb Larastan:**
    - Vaig utilitzar **Larastan** per analitzar tot el codi creat i detectar possibles errors de tipus i altres problemes en el codi.

## Sprint 4

- **Creació de rutes per al CRUD de vídeos:**
    - Vaig crear les rutes de `videos/manage` per gestionar el CRUD de vídeos, protegides amb el middleware `auth` i `can:manage videos`, accessibles només per usuaris autenticats amb permisos.
    - Vaig afegir la ruta `videos.index` accessible tant per usuaris logejats com no logejats.
- **Creació de vistes per al CRUD de vídeos:**
    - Vaig crear la vista `videos/index.blade.php` per mostrar una galeria de vídeos en format semblant a YouTube, amb enllaços als detalls de cada vídeo.
    - Vaig crear les vistes a `videos/manage/`:
        - `index.blade.php`: Taula per llistar vídeos amb accions per editar i eliminar.
        - `create.blade.php`: Formulari per afegir nous vídeos, amb atributs `data-qa` per a tests.
        - `edit.blade.php`: Formulari per editar vídeos existents, amb atributs `data-qa`.
        - `delete.blade.php`: Pàgina de confirmació per eliminar vídeos, amb atributs `data-qa`.
- **Modificació de tests existents:**
    - Vaig modificar el test `test_can_manage_videos_with_permissions` a `VideosManageControllerTest` per assegurar-me que hi hagués 3 vídeos i verificar que es mostressin correctament.
- **Creació de helpers per a permisos:**
    - Vaig crear el fitxer `PermissionHelper.php` a `app/Helpers/` per inicialitzar permisos (`view videos`, `create videos`, `edit videos`, `delete videos`, `manage videos`) i assignar-los a rols (`Super Admin`, `Video Manager`, `Regular User`).
    - Vaig registrar el helper a `composer.json` per a l’autoloading.
- **Actualització de la plantilla base:**
    - Vaig afegir una barra de navegació (navbar) i un peu de pàgina (footer) a `layouts/videosapp.blade.php` per permetre la navegació entre pàgines com `/videos`, `/videos/manage`, `/dashboard`, `/terms`, i `/policy`.
- **Actualització del fitxer de termes:**
    - Vaig actualitzar el fitxer `resources/views/terms.blade.php` per incloure la documentació dels Sprints 1, 2, 3 i 4, mantenint el format Markdown.
- **Verificació amb Larastan:**
    - Vaig instal·lar Larastan i vaig executar l’anàlisi estàtica sobre els fitxers creats (`app/Http/Controllers/`, `resources/views/`, `tests/Feature/Videos/`) per detectar possibles errors de codi.

## Sprint 5

Durant aquest sprint, es van realitzar diverses tasques relacionades amb la gestió d'usuaris i la millora de la funcionalitat de vídeos. Els objectius principals van ser:

- **Corregir els errors del 4t sprint:**
    - Es van solucionar els errors detectats durant el 4t sprint, especialment els relacionats amb les proves i la navegació.

- **Afegir el camp `user_id` a la taula de vídeos:**
    - Es va modificar la migració dels vídeos per incloure el camp `user_id`, que emmagatzema l'identificador de l'usuari que ha afegit el vídeo.
    - Es van actualitzar el model `Video`, el controlador `VideoController` i els helpers corresponents.
    - Es van crear proves addicionals per assegurar que el `user_id` es guarda correctament.

- **Correcció de tests:**
    - Qualsevol test que va fallar a causa dels canvis implementats es va corregir.

- **Creació de `UsersManageController`:**
    - Es va crear el controlador amb les següents funcions:
        - `testedBy()`
        - `index()`
        - `store()`
        - `edit()`
        - `update()`
        - `delete()`
        - `destroy()`

- **Creació de funcions a `UsersController`:**
    - `index()` per veure la llista d'usuaris.
    - `show()` per veure els detalls d'un usuari i els seus vídeos.

- **Vistes per al CRUD d'usuaris:**
    - Es van crear les vistes següents a `resources/views/users/manage/`:
        - `index.blade.php`: Taula amb la llista d'usuaris.
        - `create.blade.php`: Formulari per afegir usuaris amb atributs `data-qa` per a tests.
        - `edit.blade.php`: Formulari per editar usuaris.
        - `delete.blade.php`: Confirmació per eliminar usuaris.
    - Es va crear `resources/views/users/index.blade.php` per mostrar i buscar usuaris, amb enllaços als seus detalls.

- **Helpers per a permisos:**
    - Es va actualitzar `PermissionHelper.php` per afegir permisos específics per gestionar usuaris (`view users`, `create users`, `edit users`, `delete users`, `manage users`).
    - Es van assignar aquests permisos als superadministradors.

- **Tests a `UserTest`:**
    - Es van crear les següents funcions de test a `tests/Unit/UserTest.php`:
        - `user_without_permissions_can_see_default_users_page()`
        - `user_with_permissions_can_see_default_users_page()`
        - `not_logged_users_cannot_see_default_users_page()`
        - `user_without_permissions_can_see_user_show_page()`
        - `user_with_permissions_can_see_user_show_page()`
        - `not_logged_users_cannot_see_user_show_page()`

- **Tests a `UsersManageControllerTest`:**
    - Es van crear les següents funcions de test a `tests/Feature/UsersManageControllerTest.php`:
        - `loginAsVideoManager()`
        - `loginAsSuperAdmin()`
        - `loginAsRegularUser()`
        - `user_with_permissions_can_see_add_users()`
        - `user_without_users_manage_create_cannot_see_add_users()`
        - `user_with_permissions_can_store_users()`
        - `user_without_permissions_cannot_store_users()`
        - `user_with_permissions_can_destroy_users()`
        - `user_without_permissions_cannot_destroy_users()`
        - `user_with_permissions_can_see_edit_users()`
        - `user_without_permissions_cannot_see_edit_users()`
        - `user_with_permissions_can_update_users()`
        - `user_without_permissions_cannot_update_users()`
        - `user_with_permissions_can_manage_users()`
        - `regular_users_cannot_manage_users()`
        - `guest_users_cannot_manage_users()`
        - `superadmins_can_manage_users()`

- **Creació de rutes:**
    - Es van afegir les rutes a `users/manage` per al CRUD d'usuaris, protegides amb middleware `auth` i `can:manage users`.
    - També es van afegir les rutes `users.index` i `users.show`, visibles només per a usuaris logejats.

- **Navegació:**
    - Es va assegurar que les pàgines de gestió d'usuaris siguin accessibles des de la barra de navegació.

- **Actualització del fitxer de termes:**
    - Es van afegir els canvis d'aquest sprint al fitxer `resources/markdown/terms.md`.

- **Verificació amb Larastan:**
    - Es va executar Larastan per comprovar la qualitat del codi i assegurar-se que no hi haguessin errors.


## Conclusió

Durant aquests sprints, vaig aconseguir configurar l'estructura bàsica del projecte, implementar una gestió robusta de permisos, i escriure proves per garantir el bon funcionament del sistema. Això ha permès millorar la seguretat i funcionalitat del projecte, amb un enfocament en la gestió d'usuaris i la gestió de vídeos dins de l'aplicació.
