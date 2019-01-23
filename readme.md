# Grimm Database System

Das "Grimm Database System" ist eine Forschungsplattform und Wissensdatenbank rund um die Gebrüder Grimm.

Sie dient dazu Zusammenhänge zwischen historischen Personen, sowie Ereignissen, zu ermitteln und bewerten.

## Module

### Modul: Briefe

Das Modul "Briefe" beinhaltet den fast vollständigen Schriftverkehr beider Gebrüder Jacob (Ludwig Carl) und Wilhelm (Carl) Grimm.

Die Datenbank erhebt den Anspruch historisch äußerts korrekt zu sein. 

### Modul: Personen

### Modul: Bücher

### Modul: Bibliothek

### Modul: Administration

## Stand des Datenbanksystems

### Struktur

Die Anwendung ist eine Browser-Applikation, unterstützt werden alle modernen Webbrowser.
Ältere Versionen von Browsern werden zwecks Einsatz modernster Webtechnologien nicht unterstützt.
Anfragen eines Benutzers an die Applikation werden von Kontrollern entgegen genommen. Jedes Modul besitzt eigene Endpunkte und Kontroller.

Der Kontroller für Briefe heißt `LettersController` und ist ein CRUD-Kontroller.
CRUD steht für Create, Read, Update und Delete. Diese Aktionen werden jeweils in den Methoden durchgeführt. Die funktionsweise eines Kontrollers, bzw. das Routen etc., kann in der Dokumentation zu Laravel nachgelesen werden.

### Zugriffsrechte

Eine vollständige Liste der Rechte befindet sich in der Datei `config/permissions.php`. Ein Recht setzt sich aus zwei Teilen zusammen, dem betroffenem Modul, sowie das Zugriffsrecht bzw. -schutz.

Das Recht `letters.update` bspw. befähig einen Benutzer dazu Briefe zu bearbeiten. Dazu gehört das Ändern der einzelnen Feldwerte, wie "Handschrift".
Das Recht `letters.assign` befähig einen Benutzer dazu Briefe anderen Objekten, wie Personen zuzuordnen.

Ein Administrator kann die Rechte der Benutzer under "Verwaltung &raquo; Benutzer &raquo; Rollen" anpassen.

Benutzer haben Rollen und Rollen besitzen jeweils bestimmte Rechte. Die Rechte sind additiv. Erhält ein Benutzer durch eine Rolle das Recht `letters.update` und durch eine zweite Rolle das Recht `books.update`, so besitzt der Benutzer beide Rechte.
So können Rechte, bzw. Rollen, bspw. modulweise erstellt und vergeben werden. 

### verwendete Programme, Tools und Programmiersprachen

### Speicherorte der Programme und Daten

### Stand der Programmierung und noch offene Aufgaben auf diesem Gebiet
