<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.8.52

Make and publish extensions.

<p align="center"><img src="publish-screenshot.png?raw=true" alt="Screenshot"></p>

## How to make an extension

Start with an [example feature](https://github.com/schulle4u/yellow-extension-helloworld), [example theme](https://github.com/schulle4u/yellow-extension-basic) or [example language](https://github.com/annaesvensson/yellow-language/tree/main/translation/english). This will show you which files and settings are required. Every extension needs an `extension.ini` file with extension settings. Please make sure that your extension follows our coding and documentation standards. It's not important which standard we use, but that we all use a common one. Then you can dive into any extension and find a well-known structure in which you can quickly find your way around. Upload your extension to GitHub, let us know if you need help.

If you want others to discover your extension, add [datenstrom-yellow](https://github.com/topics/datenstrom-yellow) to your repository.

## How to publish an extension

The [published extensions](https://github.com/datenstrom/yellow-extensions) are included in the [update process](https://github.com/annaesvensson/yellow-update). This will make sure that everyone gets the latest version of your extension. First increase the version number in your code, then publish your extension at the [command line](https://github.com/annaesvensson/yellow-command). Open a terminal window. Go to your installation folder, where the file `yellow.php` is. Type `php yellow.php publish` followed by a folder. This will update all necessary files. Upload your changes to GitHub and create a pull request for `datenstrom/yellow-extensions`.

If you want to mention other developers/designers/translators, add [co-authors](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) to the commit message.

## How to publish the standard installation

The [standard installation](https://github.com/datenstrom/yellow) is a collection of the most important extensions. You can update the standard installation at the [command line](https://github.com/annaesvensson/yellow-command). Usually a maintainer takes care of it, but the same tools are available to everyone. Open a terminal window. Go to your installation folder, where the file `yellow.php` is. Type `php yellow.php publish yellow`. This will update all necessary files. Upload your changes to GitHub and create a pull request for `datenstrom/yellow`.

If you want to mention other developers/designers/translators, add [co-authors](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) to the commit message.

## Examples

Extension settings for a feature:

~~~
# Datenstrom Yellow extension settings

Extension: Helloworld
Version: 0.8.15
Description: Example feature for Datenstrom Yellow.
DocumentationUrl: https://github.com/annasvensson/yellow-helloworld
DownloadUrl: https://github.com/annasvensson/yellow-helloworld/archive/main.zip
Published: 2019-01-24 19:42:13
Developer: Anna Svensson
Tag: feature
system/extensions/helloworld.php: helloworld.php, create, update
system/extensions/helloworld.js: helloworld.js, create, update
system/extensions/helloworld.css: helloworld.css, create, update
system/extensions/helloworld.txt: helloworld.txt, create, update
~~~

Extension settings for a theme:

~~~
# Datenstrom Yellow extension settings

Extension: Helsinki
Version: 0.8.15
Description: Example theme for Datenstrom Yellow.
DocumentationUrl: https://github.com/annasvensson/yellow-helsinki
DownloadUrl: https://github.com/annasvensson/yellow-helsinki/archive/main.zip
Published: 2019-01-24 19:42:13
Designer: Anna Svensson
Tag: theme
system/extensions/basic.php: basic.php, create, update
system/extensions/basic.txt: basic.txt, create, update
system/themes/basic.css: basic.css, create, update, careful
system/themes/basic.png: basic.png, create
~~~

Extension settings for a language:

~~~
# Datenstrom Yellow extension settings

Extension: English
Version: 0.8.24
Description: English/English with language 'en'.
DocumentationUrl: https://github.com/annaesvensson/yellow-language/tree/main/translation/english
DownloadUrl: https://github.com/datenstrom/yellow-extensions/raw/main/downloads/english.zip
Published: 2019-01-24 19:42:13
Translator: Mark Seuffert
Tag: language
system/extensions/english.php: english.php, create, update
system/extensions/english.txt: english.txt, create, update
~~~

Showing available folders at the command line:

`php yellow.php publish`  

Publishing extensions at the command line:

`php yellow.php publish yellow-helloworld`  
`php yellow.php publish yellow-helsinki`  
`php yellow.php publish yellow-language/translation/english`  

Publishing the standard installation at the command line:

`php yellow.php publish yellow`  

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
`Status` = extension status, [supported status values](#settings-status)  
`Developer` = feature developer(s), comma separated  
`Designer` = theme designer(s), comma separated  
`Translator` = language translator(s), comma separated  
`Tag` = extension tag(s) for categorisation, comma separated  

<a id="settings-status"></a>The following extension status values are supported:

`public` = extension is visible in official repository  
`unlisted` = extension is not visible in official repository  
`unpublished` = extension is not available in official repository  

<a id="settings-actions"></a>The following file actions are supported:

`create` = create file if not exists  
`update` = overwrite file if exists  
`delete` = delete file if exists  
`optional` = only for first installation  
`additional` = only after first installation  
`careful` = only if not modified  
`multi-language` = use content from corresponding subfolder  

## Installation

[Download extension](https://github.com/annaesvensson/yellow-publish/archive/main.zip) and copy zip file into your `system/extensions` folder. Right click if you use Safari.

## Developer

Datenstrom. [Get help](https://datenstrom.se/yellow/help/).
