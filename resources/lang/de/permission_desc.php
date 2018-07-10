<?php

return [
    'users' => [
        'store' => 'Mit diesem Recht darf ein Nutzer neue Benutzer und neue Rollen hinzufügen.',
        'update' => 'Damit ein Nutzer die Daten (Benutzername, Passwort, Rechte) eines anderen Nutzers bearbeiten kann, benötigt er dieses Recht.',
        'delete' => 'Nur Nutzer, die dieses Recht besitzen, dürfen andere Nutzer löschen.',
    ],
    'letters' => [
        'store' => 'Um einen neuen Brief anzulegen, wird dieses Recht benötigt.',
        'update' => 'Zur Aktualisierung der Daten eines existierenden Briefs muss ein Nutzer dieses Recht haben.',
        'delete' => 'Nur ein Nutzer mit diesem Recht kann Briefe löschen.',
        'assign' => 'Mit diesem Recht kann ein Nutzer ein Brief einer Person zuordnen.',
    ],
    'people' => [
        'store' => 'Zur Erstellung von neuen Personen wird dieses Recht benötigt.',
        'update' => 'Mit diesem Recht darf ein Nutzer existierende Personen bearbeiten. Das umfasst das Bearbeiten der Personendaten und auch die zugeordneten Drucke oder Nachlässe.',
        'delete' => 'Ein Nutzer kann nur mit diesem Recht Personeneinträge löschen.',
    ],
    'books' => [
        'store' => 'Um ein neues Buch anzulegen, wird dieses Recht benötigt.',
        'update' => 'Zur Aktualisierung der Daten eines existierenden Buchs muss ein Nutzer dieses Recht haben.',
        'delete' => 'Nur ein Nutzer mit diesem Recht kann Bücher löschen.',
        'assign' => 'Mit diesem Recht kann ein Nutzer ein Buch einer Person zuordnen.',
    ],
    'library' => [
        'store' => 'Um ein neues Buch der Grimm-Bibliothek anzulegen, wird dieses Recht benötigt.',
        'update' => 'Zur Aktualisierung der Daten eines existierenden Buchs in der Grimm-Bibliothek muss ein Nutzer dieses Recht haben.',
        'delete' => 'Nur ein Nutzer mit diesem Recht kann Bücher der Grimm-Bibliothek löschen.',
    ],
    'admin' => [
        'deployment' => 'Der Benutzer kann die Aktualisierung des öffentlichen Datenbestands anstoßen.',
        'import' => 'Der Benutzer kann dBase Datenbanken importieren.',
    ],
];
