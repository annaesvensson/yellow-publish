# Publish 0.9.9

Göra och publicera tillägg. Utvecklad av Anna Svensson.

<p align="center"><img src="screenshot.png" alt="Skärmdump"></p>

## Hur man installerar ett tillägg

[Ladda ner ZIP-filen](https://github.com/annaesvensson/yellow-publish/archive/refs/heads/main.zip) och kopiera den till din `system/extensions` mapp. [Läs mer om tillägg](https://github.com/annaesvensson/yellow-update/tree/main/readme-sv.md).

## Hur man gör ett tillägg

[Börja med en exempel-funktion](https://github.com/annaesvensson/yellow-example) eller [ett exempel-tema](https://github.com/annaesvensson/yellow-stockholm) för Datenstrom Yellow. Det är bäst att titta på koden för några tillägg in din `system/workers` mapp. Gör dig också bekant med vår kodningsstil. Sen kan du dyka in i vilket tillägg som helst och hitta en välbekant struktur som du snabbt kan hitta runt i. För sofistikerade tillägg finns det ett [API för utvecklare](https://datenstrom.se/sv/yellow/help/api-for-developers). [Tilläggsinställningar](#inställningar-extension) lagras i filen `extension.ini`. Dessa tilläggsinställningar innehåller information om alla filer som ska installeras. Vill du göra ett tillägg? Skapa ett nytt repository på [GitHub](https://github.com/topics/datenstrom-yellow), [Codeberg](https://codeberg.org/explore/repos?q=datenstrom-yellow&topic=1) eller en annan hostingplattform.

## Hur man förbättrar ett tillägg

Du kan förbättra ditt tillägg och visa den för andra människor. Det här är ett bra sätt att få feedback och att experimentera med funktioner. De flesta tillägg börjar som experimentella med `Status: experimental`. Med tiden får man en bättre förståelse för vad människor behöver och kan förbättra experimentella tillägg. Bra teknologi är gjord för människor. Granska ditt tillägg ur användarens perspektiv. Föreställ dig vad användaren vill göra och vad som skulle göra deras liv enklare. Kom ihåg att fokusera på människor. Inte på tekniska detaljer och massor av funktioner.

## Hur man publicerar ett tillägg

Detta steg är endast nödvändigt för [tillägg på officiella webbplatsen](https://datenstrom.se/sv/yellow/extensions/) med `Status: available`. Det är valfritt för experimentella tillägg. Publicering uppdaterar främst tilläggsinställningarna och readme-filerna. Publicering informerar också [uppdateringsmekanismen](https://github.com/annaesvensson/yellow-update/tree/main/readme-sv.md) om att en ny version av ett tillägg är tillgänglig. Kom ihåg att endast tillägg som finns på den officiella webbplatsen ingår i uppdateringsmekanismen.

Du kan publicera ditt tillägg på [kommandoraden](https://github.com/annaesvensson/yellow-core/tree/main/readme-sv.md). Se till att du fyller i [checklistan för självgranskning](self-review-checklist.md) och ökar `VERSION` i koden innan du publicerar ett tillägg. Är du redo att publicera ditt tillägg? Öppna ett terminalfönster. Gå till installationsmappen där filen `yellow.php` finns. Skriv `php yellow.php publish all`. Du kan valfritt lägga till namnet på en mapp. Detta uppdaterar nödvändiga filerna. Ladda upp dina ändringar och skapa en pull-request för repository `datenstrom/yellow`.

## Exempel

Tilläggsinställningar för en funktion:

~~~
# Datenstrom Yellow extension settings

Extension: Example
Version: 0.9.1
Description: Example feature for Datenstrom Yellow.
Developer: Anna Svensson
Tag: example, feature
DownloadUrl: https://github.com/datenstrom/yellow-example/archive/refs/heads/main.zip
DocumentationUrl: https://github.com/datenstrom/yellow-example
Published: 2025-02-19 10:35:30
Status: experimental
system/workers/example.php: example.php, create, update
~~~

Tilläggsinställningar för ett språk:

~~~
# Datenstrom Yellow extension settings

Extension: Swedish
Version: 0.9.1
Description: Swedish language.
Translator: Anna Svensson
Tag: language
DownloadUrl: https://github.com/annaesvensson/yellow-language/raw/main/downloads/swedish.zip
DocumentationUrl: https://github.com/annaesvensson/yellow-language/tree/main/translations/swedish
Published: 2024-04-04 15:24:20
Status: available
system/workers/swedish.php: swedish.php, create, update
~~~

Tilläggsinställningar för ett tema:

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

Visar tillgängliga mappar på kommandoraden:

`php yellow.php publish`  

Publicera alla mappar på kommandoraden:

`php yellow.php publish all`  

Publicera tillägg på kommandoraden:

`php yellow.php publish yellow-example`  
`php yellow.php publish yellow-language`  
`php yellow.php publish yellow-stockholm`  

## Inställningar

Följande inställningar kan konfigureras i filen `system/extensions/yellow-system.ini`:

`PublishCodeDirectory` = mapp med kod för publicerade tillägg  
`PublishWebsiteDirectory` = mapp med filer för den officiella webbplatsen  

<a id="inställningar-extension"></a>Följande inställningar kan konfigureras i filen `extension.ini`:

`Extension` = tilläggets namn  
`Version` = tilläggets versionsnummer  
`Description` = tilläggets beskrivning, en kort mening  
`Developer` = ansvarig utvecklare av en funktion, kommaseparerade  
`Designer` = ansvarig formgivare av ett tema, kommaseparerade  
`Translator` = ansvarig översättare av ett språk, kommaseparerade  
`Tag` = taggar för kategorisering av tillägget, kommaseparerade  
`DownloadUrl` = tilläggets nedladdningsadress  
`DocumentationUrl` = tilläggets dokumentation  
`DocumentationLanguage` = tilläggets dokumentationsspråk, kommaseparerade  
`Published` = tilläggets publiceringsdatum, ÅÅÅÅ-MM-DD format  
`Status` = tilläggets status, [stödda statusvärden](#inställningar-status)  

<a id="inställningar-status"></a>Följande statusvärden stöds:

`experimental` = tillägget är experimentellt, använd på egen risk  
`available` = tillägget är tillgängligt och [visas på officiella webbplatsen](https://datenstrom.se/sv/yellow/extensions/)  
`unmaintained ` = tillägget underhålls inte längre  
`unassembled` = tillägget sätts ihop av verktygskedjan  

<a id="inställningar-actions"></a> Följande filåtgärder stöds:

`create` = skapa fil om den inte finns  
`update` = skriv över fil om den inte finns  
`delete` = ta bort fil om den inte finns  
`optional` = endast för första installationen  
`additional` = endast efter första installationen  
`careful` = endast om den inte ändras  
`compress` = skapa ZIP-fil från angivna mappen  
`multi-language` = använda innehållsfil från motsvarande mappen  

Har du några frågor? [Få hjälp](https://datenstrom.se/sv/yellow/help/).
