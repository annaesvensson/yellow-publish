<p align="right"><a href="readme-de.md">Deutsch</a> &nbsp; <a href="readme.md">English</a> &nbsp; <a href="readme-sv.md">Svenska</a></p>

# Publish 0.9.9

Make and publish extensions.

<p align="center"><img src="screenshot.png" alt="Screenshot"></p>

## How to install an extension

[Download ZIP file](https://github.com/annaesvensson/yellow-publish/archive/refs/heads/main.zip) and copy it into your `system/extensions` folder. [Learn more about extensions](https://github.com/annaesvensson/yellow-update).

## How to make an extension

[Start with an example feature](https://github.com/annaesvensson/yellow-example) or [example theme](https://github.com/annaesvensson/yellow-stockholm) for Datenstrom Yellow. It's best to have a look at the code of some extensions in your `system/workers` folder. Make yourself familiar with our coding style as well. Then you can dive into any extension and find a well-known structure in which you can quickly find your way around. For sophisticated extensions there's an [API for developers](https://datenstrom.se/yellow/help/api-for-developers). The [extension settings](#settings-extension) are stored in file `extension.ini`. These extension settings contain information about all the files that should be installed. Do you want to make an extension? Create a new repository on [GitHub](https://github.com/topics/datenstrom-yellow) or [Codeberg](https://codeberg.org/explore/repos?q=datenstrom-yellow&topic=1).

## How to improve an extension

You can improve your extension and show it to other people. This is a great way to get feedback and to experiment with features. First make it work and then make it better. Most extensions start as experimental with `Status: experimental`. Over time you get a better understanding of what people need and can improve experimental extensions. Good technology is made for people. Review your extension from the perspective of the user. Imagine what the user wants to do and what would make their life easier. Remember to focus on people. Not on technical details and lots of features.

## How to publish an extension

This step is only necessary for [extensions on the official website](https://datenstrom.se/yellow/extensions/) with `Status: available`. It's optional for experimental extensions. Publishing primarily update the extension settings and readme files. Publishing also informs the [update mechanism](https://github.com/annaesvensson/yellow-update) that a new version of an extension is available. Keep in mind that only extensions that are on the official website are included in the update mechanism.

You can publish your extension at the [command line](https://github.com/annaesvensson/yellow-core). Make sure to complete the [self-review checklist](self-review-checklist.md) and increase the `VERSION` in the code before publishing an extension. Are you ready to publish your extension? Open a terminal window. Go to your installation folder, where the file `yellow.php` is. Type `php yellow.php publish all`. You can optionally add the name of a folder. This will update the necessary files. Upload your changes and create a pull request for the repository `datenstrom/yellow`.

## Examples

Extension settings for a feature:

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

Extension settings for a language:

~~~
# Datenstrom Yellow extension settings

Extension: English
Version: 0.9.1
Description: English language.
Translator: Mark Seuffert
Tag: language
DownloadUrl: https://github.com/annaesvensson/yellow-language/raw/main/downloads/english.zip
DocumentationUrl: https://github.com/annaesvensson/yellow-language/tree/main/translations/english
Published: 2024-04-04 15:20:39
Status: available
system/workers/english.php: english.php, create, update
~~~

Extension settings for a theme:

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

Showing available folders at the command line:

`php yellow.php publish`  

Publishing all folders at the command line:

`php yellow.php publish all`  

Publishing extensions at the command line:

`php yellow.php publish yellow-edit`  
`php yellow.php publish yellow-language`  
`php yellow.php publish yellow-stockholm`  

## Settings

The following settings can be configured in file `system/extensions/yellow-system.ini`:

`PublishCodeDirectory` = directory with code of published extensions  
`PublishWebsiteDirectory` = directory with files of the official website  

<a id="settings-extension"></a>The following settings can be configured in file `extension.ini`:

`Extension` = extension name  
`Version` = extension version number  
`Description` = extension description, one short sentence  
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

`experimental` = extension is experimental, use at your own risk  
`available` = extension is available and [shown on the official website](https://datenstrom.se/yellow/extensions/)  
`unmaintained` = extension is no longer maintained  
`unassembled` = extension is assembled by toolchain  

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
