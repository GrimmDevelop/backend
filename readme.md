# Grimm Database System

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Inhaltsangabe</summary>
  <ol>
    <li>
      <a href="#das-projekt">Das Projekt</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#hier-anfangen">Hier anfangen</a>
      <ul>
        <li><a href="#vorraussetzungen">Vorraussetzungen</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#modul:-briefe">Modul: Briefe</a></li>
    <li><a href="#modul:-personen">Modul: Personen</a></li>
    <li><a href="#modul:-bücher">Modul: Bücher</a></li>
    <li><a href="#modul:-bibliothek">Modul: Bibliothek</a></li>
  </ol>
</details>

<!-- DAS PROJEKT -->
## Das Projekt
Das "Grimm Database System" ist eine Forschungsplattform und Wissensdatenbank rund um die Gebrüder Grimm.

Sie dient dazu Zusammenhänge zwischen historischen Personen, sowie Ereignissen, zu ermitteln und bewerten.

### Built With

Wir nutzen das Framework [Laravel](https://laravel.com).



<!-- Installation -->
## Installation

Um das Projekt bei sich lokal zum Laufen zum bringen, folgen Sie einfach diesen Schritten:

### Vorraussetzungen

Betriebssystem:
* Windows 10  
  * für Windows 10 HOME muss WSL2 aktiviert werden. [Hier](https://docs.microsoft.com/de-de/windows/wsl/install-win10#manual-installation-steps) ist eine Anleitung dazu.

* MacOS version 10.14 oder neuer

Programme:
* [Docker Desktop](https://www.docker.com/get-started)
* [npm](https://www.npmjs.com/get-npm)
* [composer](https://getcomposer.org/download/)
* [php](https://www.php.net/downloads.php) version 7.4 oder höher
* [redis](https://pecl.php.net/package/redis)

### Schritt für Schritt Anleitung

1. Repository clonen
2. .env.example anpassen und als .env speichern
3. Hosts hinzufügen
  ```sh
  127.0.0.1 grimm.test
  127.0.0.1 datenbank.grimm.test
  ```
  In Windows findet man das unter `C:\Windows\System32\drivers\etc`
4. Mit einem Terminal im Repository folgende Befehle ausführen:
  ```sh
  composer install
  npm ci

  npm run watch
  ```
5. Docker starten
6. Ein Terminal im Docker Ordner des Repositorys öffnen und folgenden Befehl ausführen:
    ```sh
    docker-compose up --build
    ```
7. Mit einem neuen Terminal im gleichen Ordner ausführen:
  ```sh
  docker-compose exec php php artisan migrate
  ```
8. Neuen Nutzer erstellen
```sh
docker-compose exec php php artisan tinker
```
Und dann in Tinker:
```
Grimm\User::create(['name' => 'test user', 'email' => 'user@example.com', 'password' => bcrypt('secret')]);
Grimm\Role::create(['name' => 'admin', 'has_all_permissions' => True]);
```
Dann im MySQL Browser mit der Datenbank verbinden und einen Eintrag in role_user erstellen mit der role id und user id, die man gerade bekommen hat (idR. 1).
9. Ersten Brief erstellen

    Weiterhin im MySQL Browser:
```
INSERT INTO `grimm`.`letters` (`id`, `unique_code`, `id_till_2018`, `id_till_1992`, `id_till_1997`, `code`, `valid`, `date`, `copy_owned`, `language`, `inc`, `handwriting_location`, `addition`, `created_at`, `updated_at`) VALUES ('1', '001', '1', '1', '1', '1880101.0000', '0', '1 Januar 1788', '0', 'de', 'Ihm dankt für seine Liebe', 'Maburg', 'Karte', '2018-06-05 16:07:25', '2018-06-05 16:07:25')
```
```sh
docker-compose exec php php artisan grimm:permissions-update
```
10. Auf grimm.test gehen und freuen, dass alles klappt!


## Modul: Briefe

Das Modul "Briefe" beinhaltet den fast vollständigen Schriftverkehr beider Gebrüder Jacob (Ludwig Carl) und Wilhelm (Carl) Grimm.

Die Datenbank erhebt den Anspruch historisch äußerst korrekt zu sein.

## Modul: Personen


## Modul: Bücher


## Modul: Bibliothek
