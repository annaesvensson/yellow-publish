<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.8.69

Erweiterungen erstellen und veröffentlichen.

<p align="center"><img src="publish-screenshot.png?raw=true" alt="Bildschirmfoto"></p>

## Wie man eine Erweiterung installiert

[ZIP-Datei herunterladen](https://github.com/annaesvensson/yellow-publish/archive/refs/heads/main.zip) und in dein `system/extensions`-Verzeichnis kopieren. [Weitere Informationen zu Erweiterungen](https://github.com/annaesvensson/yellow-update/tree/main/README-de.md).

## Wie man eine Erweiterung erstellt

[Beginne mit einer Funktion](https://github.com/schulle4u/yellow-helloworld) oder einem [Theme](https://github.com/annaesvensson/yellow-stockholm/tree/main/README-de.md). Schau dir am besten den Code von einigen Erweiterungen im `system/extensions`-Verzeichnis an. Mach dich mit unseren Programmierungs- und Dokumentationsstandards vertraut. Dann kannst du in jede Erweiterung eintauchen und findest eine vertraute Struktur vor, in der du dich schnell zurecht findet. Für anspruchsvolle Erweiterungen gibt es eine [API für Entwickler](https://datenstrom.se/de/yellow/help/api-for-developers). Normalerweise bestehet eine Erweiterung aus dem Code und zusätzlichen Dateien. Die [Erweiterungseinstellungen](#einstellungen) sind in der Datei `extension.ini` gespeichert. Die Erweiterungseinstellungen enthalten Informationen über alle Dateien die installiert werden müssen. Hast du eine Erweiterung erstellt? Erstelle ein Repository und lade deinen Dateien zu GitHub hoch.

Falls du möchtest dass andere deine Erweiterung entdecken, kannst du das Thema [datenstrom-yellow](https://github.com/topics/datenstrom-yellow) zur deinem Repository hinzufügen.

## Wie man eine Erweiterung veröffentlicht

Du kannst deine Erweiterung in der [Befehlszeile](https://github.com/annaesvensson/yellow-core/tree/main/README-de.md) veröffentlichen. Die veröffentlichten Erweiterungen bieten das beste Benutzererlebnis und werden von anderen Entwicklern überprüft. Bitte stelle sicher, dass du die [Checkliste zur Selbstüberprüfung](self-review-checklist.md) ausgefüllt hast bevor du deine Erweiterung veröffentlichst. Du brauchst ausserdem die Dateien vom Repository `datenstrom/yellow`, mache ein Fork vom Repository und klone es. Bist du bereit deine Erweiterung zu veröffentlichen? Öffne ein Terminalfenster. Gehe ins Installations-Verzeichnis, dort wo sich die Datei `yellow.php` befindet. Gib ein `php yellow.php publish all`. Du kannst wahlweise den Namen eines Verzeichnisses angeben. Das aktualisiert alle notwendigen Dateien. Lade deine Änderungen zu GitHub hoch und erzeuge einen Pull-Request für `datenstrom/yellow`.

Falls du andere Entwickler/Designer/Übersetzer erwähnen möchtest, kannst du [Co-Autoren](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) zur Commit-Nachricht hinzufügen.

## Beispiele

Erweiterungseinstellungen für eine Funktion:

~~~
# Datenstrom Yellow extension settings

Extension: Helloworld
Version: 0.8.15
Description: Make animated text.
DocumentationUrl: https://github.com/schulle4u/yellow-helloworld
DownloadUrl: https://github.com/schulle4u/yellow-helloworld/archive/refs/heads/main.zip
Published: 2020-08-13 16:12:30
Developer: Steffen Schultz
Tag: example, feature
system/extensions/helloworld.php: helloworld.php, create, update
system/extensions/helloworld.js: helloworld.js, create, update
system/extensions/helloworld.css: helloworld.css, create, update
~~~

Erweiterungseinstellungen für ein Theme:

~~~
# Datenstrom Yellow extension settings

Extension: Stockholm
Version: 0.8.13
Description: Stockholm is a clean theme.
DocumentationUrl: https://github.com/annaesvensson/yellow-stockholm
DownloadUrl: https://github.com/annaesvensson/yellow-stockholm/archive/refs/heads/main.zip
Published: 2022-06-15 16:03:38
Designer: Anna Svensson
Tag: theme
system/extensions/stockholm.php: stockholm.php, create, update
system/themes/stockholm.css: stockholm.css, create, update, careful
system/themes/stockholm.png: stockholm.png, create
system/themes/stockholm-opensans-bold.woff: stockholm-opensans-bold.woff, create, update, careful
system/themes/stockholm-opensans-light.woff: stockholm-opensans-light.woff, create, update, careful
system/themes/stockholm-opensans-regular.woff: stockholm-opensans-regular.woff, create, update, careful
~~~

Vorhandene Verzeichnisse in der Befehlszeile anzeigen:

`php yellow.php publish`  

Alle Verzeichnisse in der Befehlszeile veröffentlichen:

`php yellow.php publish all`  

Erweiterungen in der Befehlszeile veröffentlichen:

`php yellow.php publish yellow-helloworld`  
`php yellow.php publish yellow-stockholm`  

## Einstellungen

Die folgenden Einstellungen können in der Datei `system/extensions/yellow-system.ini` vorgenommen werden:

`PublishSourceDirectory` = Verzeichnis mit Quellcode  

Die folgenden Einstellungen können in der Datei `extension.ini` vorgenommen werden:

`Extension` = Name der Erweiterung  
`Version` = Versionsnummer der Erweiterung  
`Description` = Beschreibung der Erweiterung, maximal eine Zeile  
`DocumentationUrl` = Dokumentation der Erweiterung  
`DownloadUrl` = Adresse zum Herunterladen der Erweiterung  
`Published` = Veröffentlichungsdatum der Erweiterung, JJJJ-MM-TT Format  
`Developer` = verantwortlicher Entwickler einer Funktion, durch Komma getrennt  
`Designer` = verantwortlicher Designer eines Themes, durch Komma getrennt  
`Translator` = verantwortlicher Übersetzer einer Sprache, durch Komma getrennt  
`Status` = Status der Erweiterung, [unterstützte Statuswerte](#einstellungen-status)  
`Tag` = Tags zur Kategorisierung der Erweiterung, durch Komma getrennt  

<a id="einstellungen-status"></a>Die folgenden Erweiterungs-Statuswerte werden unterstützt:

`public` = Erweiterung ist veröffentlicht  
`unlisted` = Erweiterung ist veröffentlicht, aber wird nicht angezeigt  
`experimental` = Erweiterung ist nicht veröffentlicht  

<a id="einstellungen-actions"></a>Die folgenden Dateiaktionen werden unterstützt:

`create` = Datei erstellen falls nicht vorhanden  
`update` = Datei überschreiben falls vorhanden  
`delete` = Datei löschen falls vorhanden  
`optional` = nur bei Neuinstallation  
`additional` = nur nach Neuinstallation  
`careful` = nur falls nicht verändert  
`compress` = ZIP-Datei aus dem angegebenen Verzeichnis erstellen  
`multi-language` = Inhaltsdatei aus dem entsprechenden Verzeichnis verwenden  

## Entwickler

Anna Svensson. [Hilfe finden](https://datenstrom.se/de/yellow/help/).
