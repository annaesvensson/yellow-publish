<p align="right"><a href="README-de.md">Deutsch</a> &nbsp; <a href="README.md">English</a> &nbsp; <a href="README-sv.md">Svenska</a></p>

# Publish 0.8.73

Make and publish extensions.

<p align="center"><img src="SCREENSHOT.png" alt="Screenshot"></p>

## How to install an extension

[Download ZIP file](https://github.com/annaesvensson/yellow-publish/archive/refs/heads/main.zip) and copy it into your `system/extensions` folder. [Learn more about extensions](https://github.com/annaesvensson/yellow-update).

## How to make an extension

[Start with an experimental extension](https://github.com/schulle4u/yellow-helloworld). It's best to have a look at the source code of some extensions in your `system/extensions` folder. Make yourself familiar with our coding and documentation standards. Then you can dive into any extension and find a well-known structure in which you can quickly find your way around. For sophisticated extensions there's an [API for developers](https://datenstrom.se/yellow/help/api-for-developers). Typically an extension consists of the code and additional files. The [extension settings](#settings) are stored in file `extension.ini`. The extension settings contain information about all files that need to be installed. Did you make an extension? Create a repository and upload your files to GitHub.

## How to announce an extension

Tell others about your extension and [make an announcement](https://github.com/datenstrom/yellow/discussions/categories/see-what-s-new?discussions_q=sort%3Adate_created+category%3A%22See+what%27s+new%22). This is a great way to get feedback, to experiment with features and improve your extension. Most extensions start as experimental. Over time you will get a better understanding of what people need. Good technology is made for people. Review your extension from the perspective of the user. Imagine what the user wants to do and what would make life easier. Focus on people and their everyday lives. Not on technical details and lots of features.

If you want others to discover your extension, add the topic [datenstrom-yellow](https://github.com/topics/datenstrom-yellow) to your repository.

## How to publish an extension

You can publish your extension at the [command line](https://github.com/annaesvensson/yellow-core). Increase the version number in your source code. You can choose between different [status values](#settings-status), to control how to make your extension available. Make sure you have completed the [self-review checklist](self-review-checklist.md) before making your extension available to everyone. Are you ready to publish your extension? Open a terminal window. Go to your installation folder, where the file `yellow.php` is. Type `php yellow.php publish all`. You can optionally add the name of a folder. This will update the necessary files. Upload your changes to GitHub and create a pull request for the repository `datenstrom/yellow`.

If you want to mention developers/designers/translators, add [co-authors](https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/creating-a-commit-with-multiple-authors) to the commit message.

## Examples

Extension settings for a feature:

~~~
# Datenstrom Yellow extension settings

Extension: Helloworld
Version: 0.8.15
Description: Experimental extension for Datenstrom Yellow developers.
Developer: Steffen Schultz
Tag: example, feature
DownloadUrl: https://github.com/schulle4u/yellow-helloworld/archive/refs/heads/main.zip
DocumentationUrl: https://github.com/schulle4u/yellow-helloworld
Published: 2020-08-13 16:12:30
Status: experimental
system/extensions/helloworld.php: helloworld.php, create, update
system/extensions/helloworld.js: helloworld.js, create, update
system/extensions/helloworld.css: helloworld.css, create, update
~~~

Extension settings for a language:

~~~
# Datenstrom Yellow extension settings

Extension: English
Version: 0.8.44
Description: English language.
Translator: Mark Seuffert
Tag: language
DownloadUrl: https://github.com/annaesvensson/yellow-language/raw/main/downloads/english.zip
DocumentationUrl: https://github.com/annaesvensson/yellow-language/tree/main/translations/english
Published: 2024-03-21 00:16:05
Status: available
system/extensions/english.php: english.php, create, update
~~~

Extension settings for a theme:

~~~
# Datenstrom Yellow extension settings

Extension: Stockholm
Version: 0.8.14
Description: Stockholm is a clean theme.
Designer: Anna Svensson
Tag: default, theme
DownloadUrl: https://github.com/annaesvensson/yellow-stockholm/archive/refs/heads/main.zip
DocumentationUrl: https://github.com/annaesvensson/yellow-stockholm
DocumentationLanguage: en, de, sv
Published: 2024-04-20 18:43:38
Status: available
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

`php yellow.php publish yellow-language`  
`php yellow.php publish yellow-stockholm`  

## Settings

The following settings can be configured in file `system/extensions/yellow-system.ini`:

`PublishSourceDirectory` = directory with source code  

The following settings can be configured in file `extension.ini`:

`Extension` = extension name  
`Version` = extension version number  
`Description` = extension description, one line maximum  
`Developer` = responsible developer(s) of a feature, comma separated  
`Designer` = responsible designer(s) of a theme, comma separated  
`Translator` = responsible translator(s) of a language, comma separated  
`Tag` = extension tag(s) for categorisation, comma separated  
`DownloadUrl` = extension download address  
`DocumentationUrl` = extension documentation  
`DocumentationLanguage` = extension documentation language(s), comma separated  
`Published` = extension publication date, YYYY-MM-DD format  
`Status` = extension status, [supported status values](#settings-status)  

<a id="settings-status"></a>The following extension status values are supported:

`experimental` = extension is still experimental, use at your own risk  
`unmaintained` = extension is no longer maintained, use at your own risk  
`unassembled` = extension is assembled by toolchain, use when needed  
`available` = extension is available to everyone and [shown on the official website](https://datenstrom.se/yellow/extensions/)  

<a id="settings-actions"></a>The following file actions are supported:

`create` = create file if not exists  
`update` = overwrite file if exists  
`delete` = delete file if exists  
`optional` = only for first installation  
`additional` = only after first installation  
`careful` = only if not modified  
`compress` = make ZIP file from specified directory  
`multi-language` = use content file from corresponding directory  

The following files will be updated in the repository `datenstrom/yellow`:

`system/extensions/update-available.ini` = [file with available extensions](https://raw.githubusercontent.com/datenstrom/yellow/main/system/extensions/update-available.ini)  
`system/extensions/update-current.ini` = file with installed extensions  

## Developer

Anna Svensson. [Get help](https://datenstrom.se/yellow/help/).
