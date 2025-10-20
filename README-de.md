<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.9.7

Erweiterungen erstellen und veröffentlichen.

<p align="center"><img src="SCREENSHOT.png" alt="Bildschirmfoto"></p>

## Wie man eine Erweiterung installiert

[ZIP-Datei herunterladen](https://github.com/annaesvensson/yellow-publish/archive/refs/heads/main.zip) und in dein `system/extensions`-Verzeichnis kopieren. [Weitere Informationen zu Erweiterungen](https://github.com/annaesvensson/yellow-update/tree/main/README-de.md).

## Wie man eine Erweiterung erstellt

[Beginne mit einer Beispiel-Funktion](https://github.com/datenstrom/yellow-newfeature) oder einem [Beispiel-Theme](https://github.com/datenstrom/yellow-newtheme) für Datenstrom Yellow. Schau dir am besten den Quellcode von einigen Erweiterungen im `system/workers`-Verzeichnis an. Mach dich mit unseren Programmierungs- und Dokumentationsstandards vertraut. Dann kannst du in jede Erweiterung eintauchen und findest eine vertraute Struktur vor, in der du dich schnell zurecht findet. Für anspruchsvolle Erweiterungen gibt es eine [API für Entwickler](https://datenstrom.se/de/yellow/help/api-for-developers). Normalerweise bestehet eine Erweiterung aus dem Quellcode, Dokumentation und zusätzlichen Dateien. Die [Erweiterungseinstellungen](#einstellungen) sind in der Datei `extension.ini` gespeichert. Diese Erweiterungseinstellungen enthalten Informationen über alle Dateien die installiert werden sollen. Möchtest du eine Erweiterung erstellen? Erstelle ein neues Repository auf GitHub oder Codeberg.

## Wie man eine Erweiterung ankündigt

Erzähle anderen von deiner Erweiterung und [schreibe eine Ankündigung](https://github.com/datenstrom/community/discussions/categories/write-an-announcement). Das ist eine großartige Möglichkeit um Feedback zu erhalten, mit Funktionen zu experimentieren und seine Erweiterung zu verbessern. Die meisten Erweiterungen beginnen experimentell. Im Laufe der Zeit bekommt man ein besseres Verständnis was Menschen brauchen und kann experimentelle Erweiterungen verbessern. Gute Technologie wird für Menschen gemacht. Überprüfe deine Erweiterung aus der Perspektive des Benutzers. Stell dir vor was der Benutzer machen möchte und was dessen Leben einfacher machen würde. Denk daran dich auf Menschen zu konzentrieren. Nicht auf technische Details und viele Funktionen.

Falls du möchtest dass andere deine Erweiterung entdecken, kannst du das Thema `datenstrom-yellow` zur deinem Repository hinzufügen.

## Wie man eine Erweiterung verbessert

Verbessere deine Erweiterung und [schreibe eine Ankündigung](https://github.com/datenstrom/community/discussions/categories/write-an-announcement). Du kannst auch andere Erweiterung verbessern, [uns bei offenen Aufgaben](https://github.com/datenstrom/yellow/blob/main/TASKLIST.md) und [gemeldeten Fehlern helfen](https://github.com/datenstrom/community/discussions/categories/report-a-bug). Überprüfe alle Erweiterung aus der Perspektive des Benutzers. Stell dir vor was der Benutzer machen möchte und was dessen Leben einfacher machen würde. Hast du die Erweiterung von jemand anderem verbessert? Die erste Möglichkeit besteht darin einen Pull-Request an den Entwickler zu senden, der kann akzeptiert werden oder nicht. Die zweite Möglichkeit besteht darin deine Änderungen mit der Datenstrom-Netzgemeinschaft zu besprechen. Die dritte Möglichkeit besteht darin eine neue Erweiterung mit dem geänderten Quellcode zu erstellen. 

Falls du Funktionen/Einstellungen/Dateien vorschlagen möchtest, kannst du das mit der Datenstrom-Netzgemeinschaft besprechen.

## Wie man eine Erweiterung veröffentlicht

Der nächste Schritt ist für [Erweiterungen auf der offiziellen Webseite](https://datenstrom.se/de/yellow/extensions/) erforderlich, für experimentelle Erweiterungen ist er optional.

Du kannst deine Erweiterung in der [Befehlszeile](https://github.com/annaesvensson/yellow-core/tree/main/README-de.md) veröffentlichen. Erhöhe die Versionsnummer in deinem Quellcode vor der Veröffentlichung. Stelle sicher, dass du die [Checkliste zur Selbstüberprüfung](self-review-checklist.md) ausgefüllt hast. Bist du bereit deine Erweiterung zu veröffentlichen? Öffne ein Terminalfenster. Gehe ins Installations-Verzeichnis, dort wo sich die Datei `yellow.php` befindet. Gib ein `php yellow.php publish all`. Du kannst wahlweise den Namen eines Verzeichnisses angeben. Das aktualisiert die notwendigen Dateien. Lade deine Änderungen hoch und erzeuge einen Pull-Request für das Repository `datenstrom/yellow`.

Falls du Entwickler/Designer/Übersetzer erwähnen möchtest, kannst du Co-Autoren zur Commit-Nachricht hinzufügen.

## Beispiele

Erweiterungseinstellungen für eine Funktion:

~~~
# Datenstrom Yellow extension settings

Extension: Edit
Version: 0.9.1
Description: Edit your website in a web browser.
Developer: Anna Svensson
Tag: feature
DownloadUrl: https://github.com/annaesvensson/yellow-edit/archive/refs/heads/main.zip
DocumentationUrl: https://github.com/annaesvensson/yellow-edit
DocumentationLanguage: en, de, sv
Published: 2024-04-04 15:20:39
Status: available
system/workers/edit.php: edit.php, create, update
system/workers/edit.css: edit.css, create, update
system/workers/edit.js: edit.js, create, update
system/workers/edit-stack.svg: edit-stack.svg, create, update
content/shared/page-new-default.md: page-new-default.md, create, optional
~~~

Erweiterungseinstellungen für eine Sprache:

~~~
# Datenstrom Yellow extension settings

Extension: German
Version: 0.9.1
Description: German language.
Translator: David Fehrmann
Tag: language
DownloadUrl: https://github.com/annaesvensson/yellow-language/raw/main/downloads/german.zip
DocumentationUrl: https://github.com/annaesvensson/yellow-language/tree/main/translations/german
Published: 2024-04-04 15:20:49
Status: available
system/workers/german.php: german.php, create, update
~~~

Erweiterungseinstellungen für ein Theme:

~~~
# Datenstrom Yellow extension settings

Extension: Stockholm
Version: 0.9.1
Description: Stockholm is a clean theme.
Designer: Anna Svensson
Tag: default, theme
DownloadUrl: https://github.com/annaesvensson/yellow-stockholm/archive/refs/heads/main.zip
DocumentationUrl: https://github.com/annaesvensson/yellow-stockholm
DocumentationLanguage: en, de, sv
Published: 2024-04-04 15:00:52
Status: available
system/workers/stockholm.php: stockholm.php, create, update
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

`php yellow.php publish yellow-edit`  
`php yellow.php publish yellow-language`  
`php yellow.php publish yellow-stockholm`  

## Einstellungen

Die folgenden Einstellungen können in der Datei `system/extensions/yellow-system.ini` vorgenommen werden:

`PublishSourceDirectory` = Verzeichnis mit Quellcode  

Die folgenden Einstellungen können in der Datei `extension.ini` vorgenommen werden:

`Extension` = Name der Erweiterung  
`Version` = Versionsnummer der Erweiterung  
`Description` = Beschreibung der Erweiterung, maximal eine Zeile  
`Developer` = verantwortlicher Entwickler einer Funktion, durch Komma getrennt  
`Designer` = verantwortlicher Designer eines Themes, durch Komma getrennt  
`Translator` = verantwortlicher Übersetzer einer Sprache, durch Komma getrennt  
`Tag` = Tags zur Kategorisierung der Erweiterung, durch Komma getrennt  
`DownloadUrl` = Adresse zum Herunterladen der Erweiterung  
`DocumentationUrl` = Dokumentation der Erweiterung  
`DocumentationLanguage` = Dokumentationssprachen der Erweiterung, durch Komma getrennt  
`Published` = Veröffentlichungsdatum der Erweiterung, JJJJ-MM-TT Format  
`Status` = Status der Erweiterung, [unterstützte Statuswerte](#einstellungen-status)  

<a id="einstellungen-status"></a>Die folgenden Erweiterungs-Statuswerte werden unterstützt:

`experimental` = Erweiterung ist experimentell  
`available` = Erweiterung ist verfügbar und [wird auf der offiziellen Webseite angezeigt](https://datenstrom.se/de/yellow/extensions/)  
`unmaintained ` = Erweiterung wird nicht mehr gepflegt, Nutzung auf eigene Gefahr  
`unassembled` = Erweiterung wird durch Werkzeugkette zusammengebaut, Nutzung auf eigene Gefahr  

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
