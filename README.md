<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.8.61

Make and publish extensions.

<p align="center"><img src="publish-screenshot.png?raw=true" alt="Screenshot"></p>

## How to make an extension

Start with a [feature](https://github.com/schulle4u/yellow-helloworld), [language](https://github.com/annaesvensson/yellow-language/tree/main/translations/english) or [theme](https://github.com/annaesvensson/yellow-stockholm). This will show you which files are required. Every extension needs an `extension.ini` file with extension settings. For sophisticated extensions there's an [API for developers](https://datenstrom.se/yellow/help/api-for-developers). Please make sure that your extension follows our coding and documentation standards. It's not important which standard we use, but that we all use a common one. Then you can dive into any extension and find a well-known structure in which you can quickly find your way around. Upload your extension to GitHub, let us know if you need help.

If you want others to discover your extension, add the topic [datenstrom-yellow](https://github.com/topics/datenstrom-yellow) to your repository.

## How to publish an extension

You can publish your extension at the [command line](https://github.com/annaesvensson/yellow-command). The [published extensions](https://github.com/datenstrom/yellow-extensions) are included in the [update process](https://github.com/annaesvensson/yellow-update). Increase the version number in your code. Open a terminal window. Go to your installation folder, where the file `yellow.php` is. Type `php yellow.php publish all`. You can optionally add the name of a folder. Upload your changes to GitHub and create a pull request for `datenstrom/yellow-extensions`.

If you want to mention other developers/designers/translators, add [co-authors](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) to the commit message.

## How to publish the standard installation

You can publish the standard installation at the [command line](https://github.com/annaesvensson/yellow-command). The [standard installation](https://github.com/datenstrom/yellow) is a collection of the most important extensions, [translations](https://github.com/annaesvensson/yellow-language) and the [installer](https://github.com/annaesvensson/yellow-install). Usually a maintainer takes care of it, but the same tools are available to everyone. Open a terminal window. Go to your installation folder, where the file `yellow.php` is. Type `php yellow.php publish yellow`. This will update all necessary files. Upload your changes to GitHub and create a pull request for `datenstrom/yellow`.

If you want to mention other developers/designers/translators, add [co-authors](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) to the commit message.

## Examples

Extension settings for a feature:

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

Extension settings for a language:

~~~
# Datenstrom Yellow extension settings

Extension: English
Version: 0.8.32
Description: English/English with language 'en'.
DocumentationUrl: https://github.com/annaesvensson/yellow-language/tree/main/translations/english
DownloadUrl: https://github.com/datenstrom/yellow-extensions/raw/main/downloads/english.zip
Published: 2022-04-24 15:40:08
Translator: Mark Seuffert
Tag: language
system/extensions/english.php: english.php, create, update
~~~

Extension settings for a theme:

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

Showing available folders at the command line:

`php yellow.php publish`  

Publishing all folders at the command line:

`php yellow.php publish all`  

Publishing extensions at the command line:

`php yellow.php publish yellow-helloworld`  
`php yellow.php publish yellow-language`  
`php yellow.php publish yellow-stockholm`  

## Settings

The following settings can be configured in file `system/extensions/yellow-system.ini`:

`PublishSourceCodeDirectory` = directory with source code  

The following settings can be configured in file `extension.ini`:

`Extension` = extension name  
`Version` = extension version number  
`Description` = extension description, one line maximum  
`DocumentationUrl` = extension documentation  
`DownloadUrl` = extension download address  
`Published` = extension publication date, YYYY-MM-DD format  
`Developer` = responsible developer(s) of a feature, comma separated  
`Designer` = responsible designer(s) of a theme, comma separated  
`Translator` = responsible translator(s) of a language, comma separated  
`Status` = extension status, [supported status values](#settings-status)  
`Tag` = extension tag(s) for categorisation, comma separated  

<a id="settings-status"></a>The following extension status values are supported:

`public` = extension is published in official repository  
`experimental` = extension is not published in official repository  
`unlisted` = extension is not visible in official repository  

<a id="settings-actions"></a>The following file actions are supported:

`create` = create file if not exists  
`update` = overwrite file if exists  
`delete` = delete file if exists  
`optional` = only for first installation  
`additional` = only after first installation  
`careful` = only if not modified  
`multi-language` = use content from corresponding subfolder  

## Installation

[Download extension](https://github.com/annaesvensson/yellow-publish/archive/main.zip) and copy ZIP file into your `system/extensions` folder. [Learn more about extensions](https://github.com/annaesvensson/yellow-update).

## Developer

Anna Svensson. [Get help](https://datenstrom.se/yellow/help/).
