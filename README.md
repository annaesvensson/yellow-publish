<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.8.69

Make and publish extensions.

<p align="center"><img src="SCREENSHOT.png?raw=true" alt="Screenshot"></p>

## How to install an extension

[Download ZIP file](https://github.com/annaesvensson/yellow-publish/archive/refs/heads/main.zip) and copy it into your `system/extensions` folder. [Learn more about extensions](https://github.com/annaesvensson/yellow-update).

## How to make an extension

[Start with a feature](https://github.com/schulle4u/yellow-helloworld) or [theme](https://github.com/annaesvensson/yellow-stockholm). It's best to have a look at the code of some extensions in your `system/extensions` folder. Make yourself familiar with our coding and documentation standards. Then you can dive into any extension and find a well-known structure in which you can quickly find your way around. For sophisticated extensions there's an [API for developers](https://datenstrom.se/yellow/help/api-for-developers). Typically an extension consists of the code and additional files. The [extension settings](#settings) are stored in file `extension.ini`. The extension settings contain information about all files that need to be installed. Did you make an extension? Create a repository and upload your files to GitHub

If you want others to discover your extension, add the topic [datenstrom-yellow](https://github.com/topics/datenstrom-yellow) to your repository.

## How to publish an extension

You can publish your extension at the [command line](https://github.com/annaesvensson/yellow-core). The published extensions provide the best user experience and are reviewed by other developers. Please make sure that you have completed the [self-review checklist](self-review-checklist.md) before publishing your extension. You also need the files from the repository `datenstrom/yellow`, fork the repository and clone it. Are you ready to publish your extension? Open a terminal window. Go to your installation folder, where the file `yellow.php` is. Type `php yellow.php publish all`. You can optionally add the name of a folder. This will update the necessary files in `datenstrom/yellow`. Upload your changes to GitHub and create a pull request for `datenstrom/yellow`.

If you want to mention other developers/designers/translators, add [co-authors](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) to the commit message.

## Examples

Extension settings for a feature:

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

Extension settings for a theme:

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

Showing available folders at the command line:

`php yellow.php publish`  

Publishing all folders at the command line:

`php yellow.php publish all`  

Publishing extensions at the command line:

`php yellow.php publish yellow-helloworld`  
`php yellow.php publish yellow-stockholm`  

## Settings

The following settings can be configured in file `system/extensions/yellow-system.ini`:

`PublishSourceDirectory` = directory with source code  

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

`public` = extension is published  
`unlisted` = extension is published, but not shown  
`experimental` = extension is not published  

<a id="settings-actions"></a>The following file actions are supported:

`create` = create file if not exists  
`update` = overwrite file if exists  
`delete` = delete file if exists  
`optional` = only for first installation  
`additional` = only after first installation  
`careful` = only if not modified  
`compress` = make ZIP file from specified directory  
`multi-language` = use content file from corresponding directory  

## Developer

Anna Svensson. [Get help](https://datenstrom.se/yellow/help/).
