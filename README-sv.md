<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.8.64

Göra och publicera tillägg.

<p align="center"><img src="publish-screenshot.png?raw=true" alt="Skärmdump"></p>

## Hur man installerar ett tillägg

[Ladda ner ZIP-filen](https://github.com/annaesvensson/yellow-publish/archive/main.zip) och kopiera den till din `system/extensions` mapp. [Läs mer om tillägg](https://github.com/annaesvensson/yellow-update/tree/main/README-sv.md).

## Hur man gör ett tillägg

[Börja med en funktion](https://github.com/schulle4u/yellow-extension-helloworld), ett [språk](https://github.com/annaesvensson/yellow-language/tree/main/translations/swedish) eller ett [tema](https://github.com/annaesvensson/yellow-stockholm/tree/main/README-sv.md). Detta visar dig vilka filer som krävs. [Tilläggsinställningar](#inställningar) lagras i filen `extension.ini`. För sofistikerade tillägg finns det ett [API för utvecklare](https://datenstrom.se/sv/yellow/help/api-for-developers). Titta på koden för installerade tillägg, gör dig bekant med våra kodnings- och dokumentationsstandarder. Sen kan man dyka in i vilken tillägg som helst och hitta en välbekant struktur som man snabbt kan hitta runt i. Ladda upp ditt tillägg till GitHub, låt oss veta om du behöver hjälp.

Om du vill att andra upptäcka ditt tillägg, lägg till ämnet [datenstrom-yellow](https://github.com/topics/datenstrom-yellow) till ditt repository.

## Hur man publicerar ett tillägg

Du kan publicera ditt tillägg på [kommandoraden](https://github.com/annaesvensson/yellow-core/tree/main/README-sv.md). De [publicerade tilläggen](https://github.com/datenstrom/yellow-extensions/tree/main/README-sv.md) granskas av en annan utvecklare. Se till att du har fyllt i [checklistan för självgranskning](self-review-checklist.md) innan du publicerar ditt tillägg. Gör en fork av repository `datenstrom/yellow-extensions` och öppna den med GitHub Desktop. Öppna ett terminalfönster. Gå till installationsmappen där filen `yellow.php` finns. Skriv `php yellow.php publish all`. Du kan eventuellt lägga till namnet på en mapp. Ladda upp dina ändringar till GitHub och skapa en pull-request för `datenstrom/yellow-extensions`.

Om du inte vill att ditt tillägg ska publiceras, ställ in `Status: experimental` i [tilläggsinställningar](#inställningar).

## Hur man publicerar standardinstallationen

Du kan publicera standardinstallationen på [kommandoraden](https://github.com/annaesvensson/yellow-core/tree/main/README-sv.md). [Standardinstallationen](https://github.com/datenstrom/yellow) är en samling av viktigaste tilläggen och [installationsprogrammet](https://github.com/annaesvensson/yellow-install/tree/main/README-sv.md). Vanligtvis tar en underhållare hand om det, dock samma verktyg är tillgängliga för alla. Gör en fork av repository `datenstrom/yellow` och öppna den med GitHub Desktop. Öppna ett terminalfönster. Gå till installationsmappen där filen `yellow.php` finns. Skriv `php yellow.php publish all`. Detta uppdaterar alla nödvändiga filer. Ladda upp dina ändringar till GitHub och skapa en pull-request för `datenstrom/yellow`.

Om du vill nämna andra utvecklare/designer/översättare, lägg till [medförfattare](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) till commit-meddelandet.

## Exempel

Tilläggsinställningar för en funktion:

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
~~~

Tilläggsinställningar för ett språk:

~~~
# Datenstrom Yellow extension settings

Extension: Swedish
Version: 0.8.32
Description: Swedish/Svenska with language 'sv'.
DocumentationUrl: https://github.com/annaesvensson/yellow-language/tree/main/translations/swedish
DownloadUrl: https://github.com/datenstrom/yellow-extensions/raw/main/downloads/swedish.zip
Published: 2022-04-24 15:40:40
Translator: Anna Svensson
Tag: language
system/extensions/swedish.php: swedish.php, create, update
~~~

Tilläggsinställningar för ett tema:

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

Visar tillgängliga mappar på kommandoraden:

`php yellow.php publish`  

Publicera alla mappar på kommandoraden:

`php yellow.php publish all`  

Publicera tillägg på kommandoraden:

`php yellow.php publish yellow-helloworld`  
`php yellow.php publish yellow-language`  
`php yellow.php publish yellow-stockholm`  

## Inställningar

Följande inställningar kan konfigureras i filen `system/extensions/yellow-system.ini`:

`PublishSourceCodeDirectory` = mapp med källkod  

Följande inställningar kan konfigureras i filen `extension.ini`:

`Extension` = tilläggets namn  
`Version` = tilläggets versionsnummer  
`Description` = tilläggets beskrivning, max en rad  
`DocumentationUrl` = tilläggets dokumentation  
`DownloadUrl` = tilläggets nedladdningsadress  
`Published` = tilläggets publiceringsdatum, ÅÅÅÅ-MM-DD format  
`Developer` = ansvarig utvecklare av en funktion, kommaseparerade  
`Designer` = ansvarig formgivare av ett tema, kommaseparerade  
`Translator` = ansvarig översättare av ett språk, kommaseparerade  
`Status` = tilläggets status, [stödda statusvärden](#inställningar-status)  
`Tag` = taggar för kategorisering av tillägget, kommaseparerade  

<a id="inställningar-status"></a>Följande statusvärden stöds:

`public` = tillägget publiceras  
`unlisted` = tillägget publiceras, men visas inte  
`experimental` = tillägget måste installeras/uppdateras manuellt  

<a id="inställningar-actions"></a> Följande filåtgärder stöds:

`create` = skapa fil om den inte finns  
`update` = skriv över fil om den inte finns  
`delete` = ta bort fil om den inte finns  
`optional` = endast för första installationen  
`additional` = endast efter första installationen  
`careful` = endast om den inte ändras  
`multi-language` = använda innehåll från motsvarande undermapp  

## Utvecklare

Anna Svensson. [Få hjälp](https://datenstrom.se/sv/yellow/help/).
