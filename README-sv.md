<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.9.6

Göra och publicera tillägg.

<p align="center"><img src="SCREENSHOT.png" alt="Skärmdump"></p>

## Hur man installerar ett tillägg

[Ladda ner ZIP-filen](https://github.com/annaesvensson/yellow-publish/archive/refs/heads/main.zip) och kopiera den till din `system/extensions` mapp. [Läs mer om tillägg](https://github.com/annaesvensson/yellow-update/tree/main/README-sv.md).

## Hur man gör ett tillägg

Börja med ett [exempel-funktion](https://github.com/datenstrom/yellow-newfeature) eller [exempel-tema](https://github.com/datenstrom/yellow-newtheme) för Datenstrom Yellow. Det är bäst att titta på källkoden för några tillägg in din `system/workers` mapp. Gör dig bekant med våra kodnings- och dokumentationsstandarder. Sen kan du dyka in i vilket tillägg som helst och hitta en välbekant struktur som du snabbt kan hitta runt i. För sofistikerade tillägg finns det ett [API för utvecklare](https://datenstrom.se/sv/yellow/help/api-for-developers). Vanligtvis består ett tillägg av källkoden och ytterligare filer. [Tilläggsinställningar](#inställningar) lagras i filen `extension.ini`. Dessa tilläggsinställningar innehåller information om alla filer som ska installeras. Gjorde du ett nytt tillägg? Skapa ett nytt repository på GitHub eller Codeberg.

## Hur man annonserar ett tillägg

Berätta för andra om ditt tillägg och [skriv ett medelande](https://github.com/datenstrom/community/discussions/categories/see-what-s-new?discussions_q=sort%3Adate_created+category%3A%22See+what%27s+new%22). Det här är ett bra sätt att få feedback, att experimentera med funktioner och förbättra ditt tillägg. De flesta tillägg börjar som experimentella. Med tiden får man en bättre förståelse för vad människor behöver och kan förbättra experimentella tillägg. Bra teknologi är gjord för människor. Granska ditt tillägg ur användarens perspektiv. Föreställ dig vad användaren vill göra och vad som skulle göra livet enklare. Kom ihåg att fokusera på människor. Inte på tekniska detaljer och massor av funktioner.

Om du vill att andra upptäcka ditt tillägg, lägg till ämnet `datenstrom-yellow` till ditt repository.

## Hur man publicerar ett tillägg

Du kan publicera ditt tillägg på [kommandoraden](https://github.com/annaesvensson/yellow-core/tree/main/README-sv.md). Öka versionsnumret i din källkod innan du publicerar. Se till att du har fyllt i [checklistan för självgranskning](self-review-checklist.md). Kontrollera att du har angett i filen `extension.ini` alla filer som ska installeras. Är du redo att publicera ditt tillägg? Öppna ett terminalfönster. Gå till installationsmappen där filen `yellow.php` finns. Skriv `php yellow.php publish all`. Du kan eventuellt lägga till namnet på en mapp. Detta uppdaterar nödvändiga filerna. Ladda upp dina ändringar och skapa en pull-request för repository `datenstrom/yellow`.

Om du vill nämna utvecklare/designer/översättare, lägg till medförfattare till commit-meddelandet.

## Exempel

Tilläggsinställningar för en funktion:

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

`php yellow.php publish yellow-edit`  
`php yellow.php publish yellow-language`  
`php yellow.php publish yellow-stockholm`  

## Inställningar

Följande inställningar kan konfigureras i filen `system/extensions/yellow-system.ini`:

`PublishSourceDirectory` = mapp med källkod  

Följande inställningar kan konfigureras i filen `extension.ini`:

`Extension` = tilläggets namn  
`Version` = tilläggets versionsnummer  
`Description` = tilläggets beskrivning, max en rad  
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

`experimental` = tillägget är experimentellt  
`available` = tillägget är tillgängligt och [visas på officiella webbplatsen](https://datenstrom.se/sv/yellow/extensions/)  
`unmaintained ` = tillägget underhålls inte längre, använd på egen risk  
`unassembled` = tillägget sätts ihop av verktygskedjan, använd på egen risk  

<a id="inställningar-actions"></a> Följande filåtgärder stöds:

`create` = skapa fil om den inte finns  
`update` = skriv över fil om den inte finns  
`delete` = ta bort fil om den inte finns  
`optional` = endast för första installationen  
`additional` = endast efter första installationen  
`careful` = endast om den inte ändras  
`compress` = skapa ZIP-fil från angivna mappen  
`multi-language` = använda innehållsfil från motsvarande mappen  

## Utvecklare

Anna Svensson. [Få hjälp](https://datenstrom.se/sv/yellow/help/).
