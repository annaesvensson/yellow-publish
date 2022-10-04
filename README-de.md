<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.8.53

Erweiterungen erstellen und veröffentlichen.

<p align="center"><img src="publish-screenshot.png?raw=true" alt="Bildschirmfoto"></p>

## Wie man eine Erweiterung erstellt

Beginne mit einer [Funktion](https://github.com/schulle4u/yellow-helloworld), einer [Sprache](https://github.com/annaesvensson/yellow-language/tree/main/translation/german) oder einem [Thema](https://github.com/annaesvensson/yellow-stockholm/tree/main/README-de.md). Das zeigt dir welche Dateien und Einstellungen erforderlich sind. Jede Erweiterung benötigt eine `extension.ini`-Datei mit Erweiterungseinstellungen. Für anspruchsvolle Erweiterungen gibt es eine [API für Entwickler](https://datenstrom.se/de/yellow/help/api-for-developers). Bitte stelle sicher, dass deine Erweiterung unseren Programmierungs- und Dokumentationsstandards entspricht. Es ist nicht wichtig welchen Standard wir verwenden, aber dass wir alle einen gemeinsamen verwenden. Dann kann man in jede Erweiterung eintauchen und findet eine vertraute Struktur vor, in der man sich schnell zurecht findet. Lade deine Erweiterung zu GitHub hoch, lass uns wissen falls du Hilfe brauchst.

Falls du möchtest dass andere deine Erweiterung entdecken, kannst du das Thema [datenstrom-yellow](https://github.com/topics/datenstrom-yellow) zur deinem Repository hinzufügen.

## Wie man eine Erweiterung veröffentlicht

Du kannst deine Erweiterung in der [Befehlszeile](https://github.com/annaesvensson/yellow-command/tree/main/README-de.md) veröffentlichen. Nur die veröffentlichten [Erweiterungen](https://github.com/datenstrom/yellow-extensions/tree/main/README-de.md) sind beim [Aktualisierungsprozess](https://github.com/annaesvensson/yellow-update/tree/main/README-de.md) mit dabei. Erhöhe die Versionsnummer in deinem Code. Öffne ein Terminalfenster. Gehe ins Installations-Verzeichnis, dort wo sich die Datei `yellow.php` befindet. Gib ein `php yellow.php publish all`. Du kannst wahlweise den Namen eines Verzeichnisses angeben. Lade deine Änderungen zu GitHub hoch und erzeuge einen Pull-Request für `datenstrom/yellow-extensions`.

Falls du andere Entwickler/Designer/Übersetzer erwähnen möchtest, kannst du [Co-Autoren](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) zur Commit-Nachricht hinzufügen.

## Wie man die Standardinstallation veröffentlicht

Du kannst die Standardinstallation in der [Befehlszeile](https://github.com/annaesvensson/yellow-command/tree/main/README-de.md) veröffentlichen. Die [Standardinstallation](https://github.com/datenstrom/yellow) ist eine Sammlung der wichtigsten [Erweiterungen](https://github.com/datenstrom/yellow-extensions/tree/main/README-de.md). In der Regel kümmert sich ein Betreuer darum, doch die gleichen Werkzeuge stehen allen zur Verfügung. Öffne ein Terminalfenster. Gehe ins Installations-Verzeichnis, dort wo sich die Datei `yellow.php` befindet. Gib ein `php yellow.php publish yellow`. Das aktualisiert alle notwendigen Dateien. Lade deine Änderungen zu GitHub hoch und erzeuge einen Pull-Request für `datenstrom/yellow`.

Falls du andere Entwickler/Designer/Übersetzer erwähnen möchtest, kannst du [Co-Autoren](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) zur Commit-Nachricht hinzufügen.

## Beispiele

Erweiterungseinstellungen für eine Funktion:

~~~
# Datenstrom Yellow extension settings

Extension: Helloworld
Version: 0.8.15
Description: Example feature for Datenstrom Yellow.
DocumentationUrl: https://github.com/schulle4u/yellow-helloworld
DownloadUrl: https://github.com/schulle4u/yellow-helloworld/archive/main.zip
Published: 2020-08-13 16:12:30
Developer: Steffen Schultz
Tag: feature
system/extensions/helloworld.php: helloworld.php, create, update
system/extensions/helloworld.js: helloworld.js, create, update
system/extensions/helloworld.css: helloworld.css, create, update
system/extensions/helloworld.txt: helloworld.txt, create, update
~~~

Erweiterungseinstellungen für eine Sprache:

~~~
# Datenstrom Yellow extension settings

Extension: German
Version: 0.8.32
Description: German/Deutsch with language 'de'.
DocumentationUrl: https://github.com/annaesvensson/yellow-language/tree/main/translation/german
DownloadUrl: https://github.com/datenstrom/yellow-extensions/raw/main/downloads/german.zip
Published: 2022-04-24 15:40:14
Translator: David Fehrmann
Tag: language
system/extensions/german.php: german.php, create, update
system/extensions/german.txt: german.txt, create, update
~~~

Erweiterungseinstellungen für ein Thema:

~~~
# Datenstrom Yellow extension settings

Extension: Stockholm
Version: 0.8.13
Description: Stockholm is a clean theme.
DocumentationUrl: https://github.com/annaesvensson/yellow-stockholm
DownloadUrl: https://github.com/datenstrom/yellow-extensions/raw/main/downloads/stockholm.zip
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
`php yellow.php publish yellow-language`  
`php yellow.php publish yellow-stockholm`  

## Einstellungen

Die folgenden Einstellungen können in der Datei `system/extensions/yellow-system.ini` vorgenommen werden:

`PublishSourceCodeDirectory` = Verzeichnis mit Quellcode  

Die folgenden Einstellungen können in der Datei `extension.ini` vorgenommen werden:

`Extension` = Name der Erweiterung  
`Version` = Versionsnummer der Erweiterung  
`Description` = Beschreibung der Erweiterung, maximal eine Zeile  
`DocumentationUrl` = Dokumentation der Erweiterung  
`DownloadUrl` = Adresse zum Herunterladen der Erweiterung  
`Published` = Veröffentlichungsdatum der Erweiterung, JJJJ-MM-TT Format  
`Developer` = Entwickler einer Funktion, durch Komma getrennt  
`Designer` = Designer eines Themas, durch Komma getrennt  
`Translator` = Übersetzer einer Sprache, durch Komma getrennt  
`Status` = Status der Erweiterung, [unterstützte Statuswerte](#einstellungen-status)  
`Tag` = Tags zur Kategorisierung der Erweiterung, durch Komma getrennt  

<a id="einstellungen-status"></a>Die folgenden Erweiterungs-Statuswerte werden unterstützt:

`public` = Erweiterung ist im offiziellen Repository veröffentlicht  
`private` = Erweiterung ist im offiziellen Repository nicht veröffentlicht  
`unlisted` = Erweiterung ist im offiziellen Repository nicht sichtbar  

<a id="einstellungen-actions"></a>Die folgenden Dateiaktionen werden unterstützt:

`create` = Datei erstellen falls nicht vorhanden  
`update` = Datei überschreiben falls vorhanden  
`delete` = Datei löschen falls vorhanden  
`optional` = nur bei Neuinstallation  
`additional` = nur nach Neuinstallation  
`careful` = nur falls nicht verändert  
`multi-language` = Inhalt aus dem entsprechenden Unterverzeichnis verwenden  

## Installation

[Erweiterung herunterladen](https://github.com/annaesvensson/yellow-publish/archive/main.zip) und die Zip-Datei in dein `system/extensions`-Verzeichnis kopieren. Rechtsklick bei Safari.

## Entwickler

Anna Svensson. [Hilfe finden](https://datenstrom.se/de/yellow/help/).
