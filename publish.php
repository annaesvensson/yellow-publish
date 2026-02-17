<?php
// Publish extension, https://github.com/annaesvensson/yellow-publish

class YellowPublish {
    const VERSION = "0.9.10";
    public $yellow;                 // access to API
    public $extensions;             // number of total extensions
    public $experimental;           // number of experimental extensions
    public $errors;                 // number of errors
    public $firstStepPaths;         // paths in first step
    public $secondStepPaths;        // paths in second step

    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("publishCodeDirectory", "/My/Documents/GitHub/");
        $this->yellow->system->setDefault("publishWebsiteDirectory", "/My/Documents/Website/");
    }

    // Handle command
    public function onCommand($command, $text) {
        switch ($command) {
            case "publish": $statusCode = $this->processCommandPublish($command, $text); break;
            default:        $statusCode = 0;
        }
        return $statusCode;
    }

    // Handle command help
    public function onCommandHelp() {
        return "publish [directory]";
    }
    
    // Process command to publish extensions
    public function processCommandPublish($command, $text) {
        if (is_string_empty($text)) {
            $statusCode = $this->showExtension($command);
        } else {
            $statusCode = $this->publishExtension($command, $text);
        }
        return $statusCode;
    }
    
    // Show available extension folders
    public function showExtension($command) {
        $statusCode = 200;
        if ($this->checkExtensionSettings()) {
            $pathBase = rtrim($this->yellow->system->get("publishCodeDirectory"), "/")."/";
            $entries = $this->yellow->toolbox->getDirectoryEntries($pathBase, "/.*/", true, true, false);
            foreach ($entries as $entry) {
                $path = $pathBase.$entry."/";
                if (is_file($path.$this->yellow->system->get("updateExtensionFile"))) {
                    $responsible = $this->getExtensionResponsibleFromSettings($path);
                } elseif (is_file("$path/yellow.php")) {
                    $responsible = "Developed by Datenstrom community.";
                } else {
                    $responsible = "No description available.";
                }
                echo "$entry - $responsible\n";
            }
            if (is_array_empty($entries)) echo "Yellow $command: No folders\n";
        } else {
            $statusCode = 500;
            $fileName = $this->yellow->system->get("coreExtensionDirectory").$this->yellow->system->get("coreSystemFile");
            echo "ERROR publishing files: Please configure PublishCodeDirectory in file '$fileName'!\n";
        }
        return $statusCode;
    }
    
    // Publish extensions folders
    public function publishExtension($command, $text) {
        $statusCode = 0;
        if ($this->checkExtensionSettings()) {
            $pathBase = rtrim($this->yellow->system->get("publishCodeDirectory"), "/")."/";
            $pathRepositoryYellow = $pathBase."yellow/";
            $pathRepositoryRequested = $pathBase.($text=="all" ? "" : rtrim($text, "/")."/");
            if (is_dir($pathRepositoryYellow) && is_dir($pathRepositoryRequested)) {
                $this->extensions = $this->experimental = $this->errors = 0;
                $this->firstStepPaths = $this->getExtensionPaths($pathRepositoryRequested);
                $this->secondStepPaths = array();
                $pathsEstimated = count($this->firstStepPaths);
                foreach ($this->firstStepPaths as $path) {
                    echo "\rPublishing extension files ".$this->getProgressPercent($this->extensions, $pathsEstimated, 5, 95)."%... ";
                    $statusCode = max($statusCode, $this->updateExtensionDirectory($path, $pathBase, true, $text=="all"));
                }
                foreach ($this->secondStepPaths as $path) {
                    echo "\rPublishing extension files ".$this->getProgressPercent($this->extensions, $pathsEstimated, 5, 95)."%... ";
                    $statusCode = max($statusCode, $this->updateExtensionDirectory($path, $pathBase));
                }
                echo "\rPublishing extension files 100%... done\n";
            } else {
                $statusCode = 500;
                $this->extensions = $this->experimental = 0;
                $this->errors = 1;
                $pathRequired = !is_dir($pathRepositoryYellow) ? $pathRepositoryYellow : $pathRepositoryRequested;
                echo "ERROR publishing files: Can't find directory '$pathRequired'!\n";
            }
        } else {
            $statusCode = 500;
            $this->extensions = $this->experimental = 0;
            $this->errors = 1;
            $fileName = $this->yellow->system->get("coreExtensionDirectory").$this->yellow->system->get("coreSystemFile");
            echo "ERROR publishing files: Please configure PublishCodeDirectory in file '$fileName'!\n";
        }
        echo "Yellow $command: $this->extensions extension".($this->extensions!=1 ? "s" : "");
        echo ", $this->experimental experimental";
        echo ", $this->errors error".($this->errors!=1 ? "s" : "")."\n";
        return $statusCode;
    }
    
    // Update extension directory
    public function updateExtensionDirectory($path, $pathBase, $analyse = false, $all = false) {
        $statusCode = 200;
        if (is_file($path.$this->yellow->system->get("updateExtensionFile"))) {
            $statusCode = max($statusCode, $this->updateExtensionSettings($path));
            $statusCode = max($statusCode, $this->updateExtensionDocumentation($path));
            $statusCode = max($statusCode, $this->updateExtensionFiles($path, $pathBase));
            $statusCode = max($statusCode, $this->updateExtensionAvailable($path, $pathBase));
            if ($statusCode==200 && $analyse && $all) $this->analyseExtensionSettings($path);
            if ($statusCode!=200) ++$this->errors;
        } elseif (is_file("$path/yellow.php")) {
            $statusCode = max($statusCode, $this->updateStandardSettings($path, $pathBase));
            $statusCode = max($statusCode, $this->updateStandardFiles($path, $pathBase));
            $statusCode = max($statusCode, $this->updateStandardTranslations($path, $pathBase));
            $statusCode = max($statusCode, $this->updateStandardDocumentation($path));
            $statusCode = max($statusCode, $this->updateOfficialDocumentation($path));
            if ($analyse && !$all) $this->extensions += $this->getStandardExtensionsCount($path);
            if ($statusCode==200 && $analyse && $all) $this->analyseExtensionSettings($path);
            if ($statusCode!=200) ++$this->errors;
        }
        return $statusCode;
    }
    
    // Update extension settings
    public function updateExtensionSettings($path) {
        $statusCode = 200;
        list($extension, $version, $published, $fileNameCode) = $this->getExtensionInformationFromCode($path);
        list($dummy, $versionAvailable, $publishedAvailable, $status) = $this->getExtensionInformationFromSettings($path);
        if ($version==$versionAvailable) $published = $publishedAvailable;
        if (!is_string_empty($extension) && !is_string_empty($version) &&
            ($status=="available" || $status=="experimental" || $status=="unassembled")) {
            $settings = new YellowArray();
            $fileNameExtension = $path.$this->yellow->system->get("updateExtensionFile");
            $fileData = $this->yellow->toolbox->readFile($fileNameExtension);
            $fileDataNew = "";
            foreach ($this->yellow->toolbox->getTextLines($fileData) as $line) {
                if (preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches)) {
                    if (lcfirst($matches[1])=="extension") $line = "Extension: ".ucfirst($extension)."\n";
                    if (lcfirst($matches[1])=="version") $line = "Version: $version\n";
                    if (lcfirst($matches[1])=="published") $line = "Published: ".date("Y-m-d H:i:s", $published)."\n";
                    if (!is_string_empty($matches[1]) && !is_string_empty($matches[2]) && strposu($matches[1], "/")) {
                        $matches[2] = preg_replace("/,(\S)/", ", $1", $matches[2]);
                        $line = "$matches[1]: $matches[2]\n";
                        $fileNameDestination = $matches[1];
                        $fileNameNormalised = $this->yellow->lookup->normalisePath($matches[1]);
                        if (!$this->yellow->lookup->isValidFile($fileNameNormalised)) {
                            $statusCode = 500;
                            echo "ERROR publishing files: File '$fileNameDestination' is not possible!\n";
                        }
                    }
                    if (!is_string_empty($matches[1]) && !is_string_empty($matches[2])) $settings[$matches[1]] = $matches[2];
                }
                $fileDataNew .= $line;
            }
            $fileNamesRequired = $this->getExtensionFileNamesRequired($path, $extension);
            foreach ($fileNamesRequired as $fileNameRequired=>$fileNameShort) {
                if (!is_file($fileNameRequired)) {
                    $statusCode = 500;
                    echo "ERROR publishing files: Can't find file '$fileNameRequired'!\n";
                }
            }
            if (!is_string_empty($fileNameCode)) {
                $fileNameClass = basename($fileNameCode);
                if ($extension!=$this->yellow->lookup->normaliseName($fileNameClass, true, true)) {
                    $statusCode = 500;
                    $class = "Yellow".ucfirst($extension);
                    echo "ERROR publishing files: Class '$class' and file '$fileNameClass' is not possible!\n";
                }
            }
            if (!$settings->isExisting("downloadUrl") || !$settings->isExisting("documentationUrl")) {
                $statusCode = 500;
                echo "ERROR publishing files: Please configure DownloadUrl and DocumentationUrl in file '$fileNameExtension'!\n";
            }
            if (!$settings->isExisting("published")) {
                $statusCode = 500;
                echo "ERROR publishing files: Please configure Published in file '$fileNameExtension'!\n";
            }
            if ($fileData!=$fileDataNew && !$this->yellow->toolbox->writeFile($fileNameExtension, $fileDataNew)) {
                $statusCode = 500;
                echo "ERROR publishing files: Can't write file '$fileNameExtension'!\n";
            }
            if ($statusCode==200) {
                ++$this->extensions;
                if ($status=="experimental") ++$this->experimental;
            }
        }
        if ($this->yellow->system->get("coreDebugMode")>=1) {
            $extension = !is_string_empty($extension) ? $extension : "unknown";
            $status = !is_string_empty($status) ? $status : "none";
            echo "YellowPublish::updateExtensionSettings extension:$extension status:$status<br />\n";
        }
        return $statusCode;
    }

    // Update extension documentation
    public function updateExtensionDocumentation($path) {
        $statusCode = 200;
        list($extension, $version, $dummy, $status) = $this->getExtensionInformationFromSettings($path);
        if (!is_string_empty($extension) && !is_string_empty($version) &&
            ($status=="available" || $status=="experimental" || $status=="unassembled")) {
            $regex = "/^readme.*\\".$this->yellow->system->get("coreContentExtension")."$/";
            foreach ($this->yellow->toolbox->getDirectoryEntries($path, $regex, true, false) as $entry) {
                $fileData = $this->yellow->toolbox->readFile($entry);
                $fileDataNew = $this->setDocumentationHeading($fileData, ucfirst($extension)." ".$version);
                if ($fileData!=$fileDataNew && !$this->yellow->toolbox->writeFile($entry, $fileDataNew)) {
                    $statusCode = 500;
                    echo "ERROR publishing files: Can't write file '$entry'!\n";
                }
                if ($this->yellow->system->get("coreDebugMode")>=2) {
                    echo "YellowPublish::updateExtensionDocumentation file:$entry<br />\n";
                }
            }
        }
        return $statusCode;
    }
    
    // Update extension files
    public function updateExtensionFiles($path, $pathBase) {
        $statusCode = 200;
        list($extension, $dummy, $dummy, $status) = $this->getExtensionInformationFromSettings($path);
        if (!is_string_empty($extension) &&
            ($status=="available" || $status=="experimental" || $status=="unassembled")) {
            $fileNamesCompress = $this->getExtensionFileNamesCompress($path, $pathBase);
            foreach ($fileNamesCompress as $fileNameZipArchive=>$pathZipArchive) {
                list($extension, $dummy, $published) = $this->getExtensionInformationFromSettings($pathZipArchive);
                $zip = new ZipArchive();
                if (is_file($fileNameZipArchive)) $this->yellow->toolbox->deleteFile($fileNameZipArchive);
                if ($zip->open($fileNameZipArchive, ZIPARCHIVE::CREATE)===true) {
                    $fileNamesRequired = $this->getExtensionFileNamesRequired($pathZipArchive, $extension);
                    foreach ($fileNamesRequired as $fileNameRequired=>$fileNameShort) {
                        if (is_file($fileNameRequired)) {
                            $zip->addFile($fileNameRequired, $fileNameShort);
                        } else {
                            $statusCode = 500;
                            echo "ERROR publishing files: Can't find file '$fileNameRequired'!\n";
                        }
                    }
                    if (!$zip->close() || !$this->normaliseZipArchive($fileNameZipArchive, $published, 0100666)) {
                        $statusCode = 500;
                        echo "ERROR publishing files: Can't write file '$fileNameZipArchive'!\n";
                    }
                } else {
                    $statusCode = 500;
                    echo "ERROR publishing files: Can't write file '$fileNameZipArchive'!\n";
                }
                if ($this->yellow->system->get("coreDebugMode")>=2) {
                    echo "YellowPublish::updateExtensionFiles file:$fileNameZipArchive<br />\n";
                }
            }
        }
        return $statusCode;
    }
    
    // Update extension in update settings
    public function updateExtensionAvailable($path, $pathBase) {
        $statusCode = 200;
        list($extension, $dummy, $dummy, $status) = $this->getExtensionInformationFromSettings($path);
        $fileNameExtension = $path.$this->yellow->system->get("updateExtensionFile");
        $fileNameAvailable = $pathBase."yellow/".$this->yellow->system->get("coreExtensionDirectory").
            $this->yellow->system->get("updateAvailableFile");
        if (is_file($fileNameExtension) && is_file($fileNameAvailable) && $status=="available") {
            $fileDataExtension = $this->yellow->toolbox->readFile($fileNameExtension);
            $settingsExtension = $this->yellow->toolbox->getTextSettings($fileDataExtension, "");
            $fileData = $this->yellow->toolbox->readFile($fileNameAvailable);
            $settingsAvailable = $this->yellow->toolbox->getTextSettings($fileData, "extension");
            $settingsAvailable[$extension] = new YellowArray();
            foreach ($settingsExtension as $key=>$value) $settingsAvailable[$extension][$key] = $value;
            $settingsAvailable->uksort("strnatcasecmp");
            $fileDataNew = "# Datenstrom Yellow update settings for available extensions\n";
            foreach ($settingsAvailable as $extension=>$block) {
                $fileDataNew .= "\n";
                foreach ($block as $key=>$value) {
                    $fileDataNew .= (strposu($key, "/") ? $key : ucfirst($key)).": $value\n";
                }
            }
            if ($fileData!=$fileDataNew && !$this->yellow->toolbox->writeFile($fileNameAvailable, $fileDataNew)) {
                $statusCode = 500;
                echo "ERROR publishing files: Can't write file '$fileNameAvailable'!\n";
            }
            if ($this->yellow->system->get("coreDebugMode")>=2) {
                echo "YellowPublish::updateExtensionAvailable file:$fileNameAvailable<br />\n";
            }
        }
        return $statusCode;
    }
    
    // Update standard installation, make sure settings are up-to-date
    public function updateStandardSettings($path, $pathBase) {
        $statusCode = 200;
        $fileNameCurrent = $path.$this->yellow->system->get("coreExtensionDirectory").
            $this->yellow->system->get("updateInstalledFile");
        $fileNameAvailable = $path.$this->yellow->system->get("coreExtensionDirectory").
            $this->yellow->system->get("updateAvailableFile");
        if (is_file($fileNameCurrent) && is_file($fileNameAvailable)) {
            $fileNameInstall = $pathBase."yellow-install/".$this->yellow->system->get("updateExtensionFile");
            $fileDataExtensions = $this->yellow->toolbox->readFile($fileNameInstall);
            $fileDataExtensions .= $this->yellow->toolbox->readFile($fileNameAvailable);
            $settingsExtensions = $this->yellow->toolbox->getTextSettings($fileDataExtensions, "extension");
            $fileDataCurrent = $this->yellow->toolbox->readFile($fileNameCurrent);
            $settingsCurrent = $this->yellow->toolbox->getTextSettings($fileDataCurrent, "extension");
            foreach ($settingsExtensions as $extension=>$block) {
                if ($settingsCurrent->isExisting($extension)) {
                    $settingsCurrent[$extension] = new YellowArray();
                    foreach ($block as $key=>$value) $settingsCurrent[$extension][$key] = $value;
                }
            }
            $fileDataNew = "# Datenstrom Yellow update settings for installed extensions\n";
            foreach ($settingsCurrent as $extension=>$block) {
                $fileDataNew .= "\n";
                foreach ($block as $key=>$value) {
                    $fileDataNew .= (strposu($key, "/") ? $key : ucfirst($key)).": $value\n";
                }
            }
            if ($fileDataCurrent!=$fileDataNew && !$this->yellow->toolbox->writeFile($fileNameCurrent, $fileDataNew)) {
                $statusCode = 500;
                echo "ERROR publishing files: Can't write file '$fileNameCurrent'!\n";
            }
            if ($this->yellow->system->get("coreDebugMode")>=2) {
                echo "YellowPublish::updateStandardSettings file:$fileNameCurrent<br />\n";
            }
        }
        return $statusCode;
    }
    
    // Update standard installation, make sure files are up-to-date
    public function updateStandardFiles($path, $pathBase) {
        $statusCode = 200;
        $fileNamesRequired = $this->getStandardFileNamesRequired($path, $pathBase);
        foreach ($fileNamesRequired as $fileNameSource=>$fileNameDestination) {
            $fileNameNormalised = substru($fileNameDestination, strlenu($path));
            $fileNameNormalised = $this->yellow->lookup->normalisePath($fileNameNormalised);
            if (is_file($fileNameSource) && $this->yellow->lookup->isValidFile($fileNameNormalised)) {
                if (!$this->yellow->toolbox->copyFile($fileNameSource, $fileNameDestination, true)) {
                    $statusCode = 500;
                    echo "ERROR publishing files: Can't write file '$fileNameDestination'!\n";
                }
                if ($this->yellow->system->get("coreDebugMode")>=2) {
                    echo "YellowPublish::updateStandardFiles file:$fileNameDestination<br />\n";
                }
            }
        }
        return $statusCode;
    }
    
    // Update standard installation, make sure translations are up-to-date
    public function updateStandardTranslations($path, $pathBase) {
        $statusCode = 200;
        if (is_dir($pathBase."yellow-language/")) {
            $fileNameAvailable = $path.$this->yellow->system->get("coreExtensionDirectory").
                $this->yellow->system->get("updateAvailableFile");
            $fileDataExtensions = $this->yellow->toolbox->readFile($fileNameAvailable);
            $settingsExtensions = $this->yellow->toolbox->getTextSettings($fileDataExtensions, "extension");
            $fileNameEnglish = $pathBase."yellow-language/translations/english/english.php";
            $fileDataEnglish = $this->yellow->toolbox->readFile($fileNameEnglish);
            $settingsEnglish = $this->getLanguageDefaultSettings($fileDataEnglish);
            foreach ($settingsExtensions as $key=>$value) {
                if (!$settingsEnglish->isExisting($key."Description")) {
                    $settingsEnglish[$key."Description"] = $value["description"];
                }
            }
            $sortIndex = 0;
            $sortKeys = array();
            foreach ($settingsEnglish as $key=>$value) {
                $keyShort = preg_match("/^([a-z]+)/", $key, $matches) ? $matches[1] : $key;
                if ($keyShort=="language") $keyShort = "";
                $sortKeys[$key] = $keyShort." ".++$sortIndex;
            }
            $callback = function ($a, $b) use ($sortKeys) {
                return strnatcmp($sortKeys[$a], $sortKeys[$b]);
            };
            $settingsEnglish->uksort($callback);
            $path = $pathBase."yellow-language/translations/";
            foreach ($this->yellow->toolbox->getDirectoryEntries($path, "/.*/", true, true, false) as $entry) {
                $fileName = $path.$entry."/$entry.php";
                $fileData = $this->yellow->toolbox->readFile($fileName);
                $settings = $this->getLanguageDefaultSettings($fileData);
                $settingsNew = new YellowArray();
                foreach ($settingsEnglish as $key=>$value) {
                    if (!$settings->isExisting($key)) {
                        $settingsNew[$key] = $value;
                    } else {
                        $settingsNew[$key] = $settings[$key];
                    }
                }
                $fileDataNew = $this->setLanguageDefaultSettings($fileData, $settingsNew);
                if ($fileData!=$fileDataNew && !$this->yellow->toolbox->writeFile($fileName, $fileDataNew)) {
                    $statusCode = 500;
                    echo "ERROR publishing files: Can't write file '$fileName'!\n";
                }
                if ($this->yellow->system->get("coreDebugMode")>=2) {
                    echo "YellowPublish::updateStandardTranslations file:$fileName<br />\n";
                }
            }
        }
        return $statusCode;
    }
    
    // Update standard installation, make sure documentation is up-to-date
    public function updateStandardDocumentation($path) {
        $statusCode = 200;
        list($product, $release) = $this->getProductInformationFromCode($path);
        $regex = "/^readme.*\\".$this->yellow->system->get("coreContentExtension")."$/";
        foreach ($this->yellow->toolbox->getDirectoryEntries($path, $regex, true, false) as $entry) {
            $fileData = $this->yellow->toolbox->readFile($entry);
            $fileDataNew = $this->setDocumentationHeading($fileData, $product." ".$release);
            if ($fileData!=$fileDataNew && !$this->yellow->toolbox->writeFile($entry, $fileDataNew)) {
                $statusCode = 500;
                echo "ERROR publishing files: Can't write file '$entry'!\n";
            }
            if ($this->yellow->system->get("coreDebugMode")>=2) {
                echo "YellowPublish::updateStandardDocumentation file:$entry<br />\n";
            }
        }
        return $statusCode;
    }
    
    // Update official website, make sure documentation is up-to-date
    public function updateOfficialDocumentation($path) {
        $statusCode = 200;
        $pathWebsiteContent = $this->yellow->system->get("publishWebsiteDirectory").
            $this->yellow->system->get("coreContentDirectory");
        if (is_dir($pathWebsiteContent) && $this->yellow->system->isExisting("publishWebsiteDirectory")) {
            $fileNameAvailable = $path.$this->yellow->system->get("coreExtensionDirectory").
                $this->yellow->system->get("updateAvailableFile");
            $fileDataAvailable = $this->yellow->toolbox->readFile($fileNameAvailable);
            $settingsAvailable = $this->yellow->toolbox->getTextSettings($fileDataAvailable, "extension");
            foreach ($this->yellow->toolbox->getDirectoryEntries($pathWebsiteContent, "/.*/", true, true, false) as $entry) {
                $fileName = $pathWebsiteContent.$entry."/2-yellow/2-extensions/page.md";
                $fileData = $fileDataNew = $this->yellow->toolbox->readFile($fileName);
                $language = $this->yellow->lookup->normaliseToken($entry);
                if (!is_file($fileName)) continue;
                if ($this->yellow->language->isExisting($language)) {
                    foreach ($settingsAvailable as $key=>$value) {
                        $description = $this->getExtensionDescription($key, $value, $language);
                        $url = $this->getExtensionDocumentationUrl($key, $value, $language);
                        $status = $value->get("status");
                        $tag = $value->get("tag");
                        if ($status=="available")  {
                            $fileDataNew = $this->setDocumentationListEntry($fileDataNew, $key, $description, $url, $tag);
                        }
                    }
                    if ($fileData!=$fileDataNew && !$this->yellow->toolbox->writeFile($fileName, $fileDataNew)) {
                        $statusCode = 500;
                        echo "ERROR publishing files: Can't write file '$fileName'!\n";
                    }
                } else {
                    $statusCode = 500;
                    echo "ERROR publishing files: Can't find language '$language'!\n";
                }
                if ($this->yellow->system->get("coreDebugMode")>=2) {
                    echo "YellowPublish::updateOfficialDocumentation file:$fileName<br />\n";
                }
            }
        }
        return $statusCode;
    }
    
    // Set documentation heading in Markdown data
    public function setDocumentationHeading($rawData, $text) {
        if (preg_match("/^(\xEF\xBB\xBF)?(<.*>[\r\n]+)?(\#[\w ]+[0-9\.]{3,}[\r\n]+)(.*)$/s", $rawData, $parts)) {
            $parts[3] = "# ".$text."\n\n";
            $rawDataNew = $parts[1].$parts[2].$parts[3].$parts[4];
        } elseif (preg_match("/^(\xEF\xBB\xBF)?(<.*>[\r\n]+)?([\w ]+[0-9\.]{3,}[\r\n]+)(\=+[\r\n]+)(.*)$/s", $rawData, $parts)) {
            $parts[3] = "# ".$text."\n\n";
            $parts[4] = "";
            $rawDataNew = $parts[1].$parts[2].$parts[3].$parts[4].$parts[5];
        } else {
            $rawDataNew = $rawData;
        }
        return $rawDataNew;
    }
    
    // Set documenation list entry in Markdown data
    public function setDocumentationListEntry($rawData, $extension, $description, $url, $tag) {
        if (!is_string_empty($extension) && !is_string_empty($description) && !is_string_empty($url) && !is_string_empty($tag)) {
            if (preg_match("/feature/i", $tag)) {
                $section = 1;
            } elseif (preg_match("/language/i", $tag)) {
                $section = 2;
            } elseif (preg_match("/theme/i", $tag)) {
                $section = 3;
            } else {
                $section = 4;
            }
            $scan = false;
            $rawDataStart = $rawDataMiddle = $rawDataEnd = "";
            foreach ($this->yellow->toolbox->getTextLines($rawData) as $line) {
                if (preg_match("/^\#\#/", $line)) --$section;
                if ($section==0) $scan = preg_match("/^\*\s*\[(\S+)\]/", $line);
                if (!$scan && is_string_empty($rawDataMiddle)) {
                    $rawDataStart .= $line;
                } elseif ($scan) {
                    $rawDataMiddle .= $line;
                } else {
                    $rawDataEnd .= $line;
                }
            }
            if (!is_string_empty($rawDataMiddle)) {
                $data = array();
                foreach ($this->yellow->toolbox->getTextLines($rawDataMiddle) as $line) {
                    if (preg_match("/^\*\s*\[(\S+)\]/", $line, $matches)) $data[strtoloweru($matches[1])] = $line;
                }
                $data[strtoloweru($extension)] = "* [".ucfirst($extension)."]($url) - $description\n";
                uksort($data, "strnatcasecmp");
                $rawDataMiddle = "";
                foreach ($data as $line) $rawDataMiddle .= $line;
            }
            $rawDataNew = $rawDataStart.$rawDataMiddle.$rawDataEnd;
        } else {
            $rawDataNew = $rawData;
        }
        return $rawDataNew;
    }
    
    // Analyse extension settings with dependencies
    public function analyseExtensionSettings($path) {
        $fileNameExtension = $path.$this->yellow->system->get("updateExtensionFile");
        $fileData = $this->yellow->toolbox->readFile($fileNameExtension);
        if (preg_match("/compress\s+@source\//i", $fileData)) {
            array_unshift($this->secondStepPaths, $path);
            if ($this->yellow->system->get("coreDebugMode")>=2) {
                echo "YellowPublish::analyseExtensionSettings detected path:$path<br />\n";
            }
        } elseif (is_file("$path/yellow.php")) {
            array_push($this->secondStepPaths, $path);
            if ($this->yellow->system->get("coreDebugMode")>=2) {
                echo "YellowPublish::analyseExtensionSettings detected path:$path<br />\n";
            }
        }
    }
    
    // Return default language settings from raw data
    public function getLanguageDefaultSettings($rawData) {
        $settings = new YellowArray();
        if (preg_match("/^(.*?\\\$this->yellow->language->setDefaults\(array\([\r\n]+)(.*?)(\)\);[\r\n]+.*)$/s", $rawData, $parts)) {
            foreach ($this->yellow->toolbox->getTextLines($parts[2]) as $line) {
                if (preg_match("/^\s*\"(.*?)\s*:\s*(.*?)\s*\"(,)?$/", $line, $matches)) {
                    if (!is_string_empty($matches[1]) && !is_string_empty($matches[2])) {
                        $settings[$matches[1]] = $matches[2];
                    }
                }
            }
        }
        return $settings;
    }
    
    // Set default language settings in raw data
    public function setLanguageDefaultSettings($rawData, $settings) {
        if (preg_match("/^(.*?\\\$this->yellow->language->setDefaults\(array\([\r\n]+)(.*?)(\)\);[\r\n]+.*)$/s", $rawData, $parts)) {
            $rawDataMiddle = "";
            foreach ($settings as $key=>$value) {
                $rawDataMiddle .= "            \"".ucfirst($key).": $value\",\n";
            }
            $rawDataMiddle = rtrim($rawDataMiddle, ",\n");
            $rawDataNew = $parts[1].$rawDataMiddle.$parts[3];
        } else {
            $rawDataNew = $rawData;
        }
        return $rawDataNew;
    }
    
    // Check extension settings
    public function checkExtensionSettings() {
        return $this->yellow->system->get("publishCodeDirectory")!="/My/Documents/GitHub/";
    }
    
    // Normalise ZIP archive created with libzip, make platform independent
    public function normaliseZipArchive($fileName, $published, $attributes) {
        $ok = false;
        $date = getdate($published);
        $publishedFat = (($date["year"]-1980)<<25) + ($date["mon"]<<21) + ($date["mday"]<<16) +
            ($date["hours"]<<11) + ($date["minutes"]<<5) + ($date["seconds"]>>1);
        $dataBuffer = $this->yellow->toolbox->readFile($fileName);
        $dataBufferSize = strlenb($dataBuffer);
        $dataSignature = substrb($dataBuffer, 0, 2);
        if ($dataSignature=="\x50\x4b") {
            for ($pos=0; $pos<$dataBufferSize; $pos+=$length) {
                $dataSignature = substrb($dataBuffer, $pos, 4);
                if ($dataSignature=="\x50\x4b\x03\x04" && $pos+30<$dataBufferSize) {
                    $this->setShortInBuffer($dataBuffer, $pos+4, 0x0014);
                    $this->setShortInBuffer($dataBuffer, $pos+6, 0);
                    $this->setLongInBuffer($dataBuffer, $pos+10, $publishedFat);
                    $length = (ord($dataBuffer[$pos+21])<<21) + (ord($dataBuffer[$pos+20])<<16) +
                        (ord($dataBuffer[$pos+19])<<8) + ord($dataBuffer[$pos+18]) +
                        (ord($dataBuffer[$pos+27])<<8) + ord($dataBuffer[$pos+26]) +
                        (ord($dataBuffer[$pos+29])<<8) + ord($dataBuffer[$pos+28]) + 30;
                } elseif ($dataSignature=="\x50\x4b\x01\x02" && $pos+46<$dataBufferSize) {
                    $this->setLongInBuffer($dataBuffer, $pos+4, 0x00140314);
                    $this->setShortInBuffer($dataBuffer, $pos+8, 0);
                    $this->setLongInBuffer($dataBuffer, $pos+12, $publishedFat);
                    $this->setLongInBuffer($dataBuffer, $pos+38, $attributes<<16);
                    $length = (ord($dataBuffer[$pos+29])<<8) + ord($dataBuffer[$pos+28]) +
                        (ord($dataBuffer[$pos+31])<<8) + ord($dataBuffer[$pos+30]) +
                        (ord($dataBuffer[$pos+33])<<8) + ord($dataBuffer[$pos+32]) + 46;
                } else {
                    break;
                }
            }
            $ok = $this->yellow->toolbox->writeFile($fileName, $dataBuffer) &&
                $this->yellow->toolbox->modifyFile($fileName, $published);
        }
        return $ok;
    }

    // Set unsigned short value in buffer, little endian
    public function setShortInBuffer(&$dataBuffer, $pos, $value) {
        $dataBuffer[$pos] = chr($value & 0xff);
        $dataBuffer[$pos+1] = chr(($value>>8) & 0xff);
    }
    
    // Set unsigned long value in buffer, little endian
    public function setLongInBuffer(&$dataBuffer, $pos, $value) {
        $dataBuffer[$pos] = chr($value & 0xff);
        $dataBuffer[$pos+1] = chr(($value>>8) & 0xff);
        $dataBuffer[$pos+2] = chr(($value>>16) & 0xff);
        $dataBuffer[$pos+3] = chr(($value>>24) & 0xff);
    }

    // Return extension paths
    public function getExtensionPaths($path) {
        $paths = array($path);
        foreach ($this->yellow->toolbox->getDirectoryEntriesRecursive($path, "/.*/", true, true) as $entry) {
            array_push($paths, "$entry/");
        }
        return $paths;
    }

    // Return progress in percent
    public function getProgressPercent($now, $total, $increments, $max) {
        $max = intval($max/$increments) * $increments;
        $percent = intval(($max/$total) * $now);
        if ($increments>1) $percent = intval($percent/$increments) * $increments;
        return min($max, $percent);
    }
    
    // Return product information from code
    public function getProductInformationFromCode($path) {
        $product = "Datenstrom Yellow";
        $release = "";
        $fileNameCode = $path.$this->yellow->system->get("coreWorkerDirectory")."/core.php";
        $fileData = $this->yellow->toolbox->readFile($fileNameCode, 4096);
        foreach ($this->yellow->toolbox->getTextLines($fileData) as $line) {
            if (preg_match("/^\s*(\S+)\s+(\S+)/", $line, $matches)) {
                if ($matches[1]=="const" && $matches[2]=="RELEASE" && preg_match("/\"([0-9\.]+)\"/", $line, $tokens)) $release = $tokens[1];
                if ($matches[1]=="function" || $matches[2]=="function") break;
            }
        }
        return array($product, $release);
    }

    // Return extension information from code
    public function getExtensionInformationFromCode($path) {
        $extension = $version = $published = $fileNameCode = "";
        foreach ($this->yellow->toolbox->getDirectoryEntries($path, "/^.*\.php$/", false, false) as $entry) {
            $fileData = $this->yellow->toolbox->readFile($entry, 4096);
            foreach ($this->yellow->toolbox->getTextLines($fileData) as $line) {
                if (preg_match("/^\s*(\S+)\s+(\S+)/", $line, $matches)) {
                    if ($matches[1]=="class" && substru($matches[2], 0, 6)=="Yellow") $extension = lcfirst(substru($matches[2], 6));
                    if ($matches[1]=="const" && $matches[2]=="VERSION" && preg_match("/\"([0-9\.]+)\"/", $line, $tokens)) $version = $tokens[1];
                    if ($matches[1]=="function" || $matches[2]=="function") break;
                }
            }
            if (!is_string_empty($extension) && !is_string_empty($version)) {
                $published = $this->yellow->toolbox->getFileModified($entry);
                $fileNameCode = $entry;
                break;
            }
        }
        if (is_string_empty($extension) || is_string_empty($version) || is_string_empty($published)) {
            list($extension, $version, $published) = $this->getExtensionInformationFromSettings($path);
        }
        return array($extension, $version, $published, $fileNameCode);
    }

    // Return extension information from settings
    public function getExtensionInformationFromSettings($path) {
        $extension = $version = $published = $status = $tag = "";
        $fileNameExtension = $path.$this->yellow->system->get("updateExtensionFile");
        $fileData = $this->yellow->toolbox->readFile($fileNameExtension);
        foreach ($this->yellow->toolbox->getTextLines($fileData) as $line) {
            if (preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches)) {
                if (lcfirst($matches[1])=="extension") $extension = lcfirst($matches[2]);
                if (lcfirst($matches[1])=="version") $version = $matches[2];
                if (lcfirst($matches[1])=="published") $published = strtotime($matches[2]);
                if (lcfirst($matches[1])=="status") $status = $matches[2];
                if (lcfirst($matches[1])=="tag") $tag = $matches[2];
            }
        }
        return array($extension, $version, $published, $status, $tag);
    }
    
    // Return extension responsible developer/designer/translator from settings
    public function getExtensionResponsibleFromSettings($path) {
        $responsible = $developer = $designer = $translator = "";
        $fileNameExtension = $path.$this->yellow->system->get("updateExtensionFile");
        $fileData = $this->yellow->toolbox->readFile($fileNameExtension);
        foreach ($this->yellow->toolbox->getTextLines($fileData) as $line) {
            if (preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches)) {
                if (lcfirst($matches[1])=="developer") $developer = $matches[2];
                if (lcfirst($matches[1])=="designer") $designer = $matches[2];
                if (lcfirst($matches[1])=="translator") $translator = $matches[2];
            }
        }
        if (!is_string_empty($developer)) $responsible = "Developed by $developer.";
        if (!is_string_empty($designer)) $responsible = "Designed by $designer.";
        if (!is_string_empty($translator)) $responsible = "Translated by $translator.";
        if (is_string_empty($responsible)) $responsible = "No description available.";
        return $responsible;
    }
    
    
    // Return extension description including responsible developer/designer/translator
    public function getExtensionDescription($key, $value, $language) {
        $description = $responsible = "";
        if ($value->isExisting("description")) {
            $description = $value->get("description");
        }
        if ($this->yellow->language->isText($key."Description", $language)) {
            $description = $this->yellow->language->getText($key."Description", $language);
        }
        if ($value->isExisting("developer")) {
            $responsible = $this->yellow->language->getText("updateExtensionDeveloper", $language);;
            $responsible = preg_replace("/@x/i", $value->get("developer"), $responsible);
        }
        if ($value->isExisting("designer")) {
            $responsible = $this->yellow->language->getText("updateExtensionDesigner", $language);;
            $responsible = preg_replace("/@x/i", $value->get("designer"), $responsible);
        }
        if ($value->isExisting("translator")) {
            $responsible = $this->yellow->language->getText("updateExtensionTranslator", $language);;
            $responsible = preg_replace("/@x/i", $value->get("translator"), $responsible);
        }
        if (is_string_empty($description)) {
            $description = $this->yellow->language->getText("updateExtensionDefaultDescription", $language);
        }
        return "$description $responsible";
    }
    
    // Return documentation URL
    public function getExtensionDocumentationUrl($key, $value, $language) {
        $url = $value->get("documentationUrl");
        $languages = preg_split("/\s*,\s*/", $value->get("documentationLanguage"));
        if ($language!="en" && in_array($language, $languages)) {
            $url .= preg_match("#/tree/main/#", $url) ? "/" : "/tree/main/";
            $url .= "readme-$language.md";
        }
        return $url;
    }
    
    // Return extension languages available
    public function getExtensionLanguagesAvailable($path) {
        $languages = array();
        foreach ($this->yellow->toolbox->getDirectoryEntries($path, "/.*/", true, true, false) as $entry) {
            array_push($languages, $entry);
        }
        return array_unique($languages);
    }
    
    // Return extension file names required to make ZIP-file
    public function getExtensionFileNamesCompress($path, $pathBase) {
        $data = array();
        $fileNameExtension = $path.$this->yellow->system->get("updateExtensionFile");
        $fileData = $this->yellow->toolbox->readFile($fileNameExtension);
        foreach ($this->yellow->toolbox->getTextLines($fileData) as $line) {
            if (preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches)) {
                if (!is_string_empty($matches[1]) && !is_string_empty($matches[2]) && strposu($matches[1], "/")) {
                    list($entry, $flags) = $this->yellow->toolbox->getTextList($matches[2], ",", 2);
                    if (preg_match("/compress\s+@source\/(.*\/)/i", $flags, $matches)) {
                        $data["$path$entry"] = $pathBase.$matches[1];
                    }
                }
            }
        }
        return $data;
    }
    
    // Return extension file names required
    public function getExtensionFileNamesRequired($path, $extension) {
        $data = array();
        $pathBase = "yellow-".strtoloweru($extension);
        $languages = $this->getExtensionLanguagesAvailable($path);
        $fileNameExtension = $path.$this->yellow->system->get("updateExtensionFile");
        $data[$fileNameExtension] = $pathBase."/".$this->yellow->system->get("updateExtensionFile");
        $fileData = $this->yellow->toolbox->readFile($fileNameExtension);
        foreach ($this->yellow->toolbox->getTextLines($fileData) as $line) {
            if (preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches)) {
                if (!is_string_empty($matches[1]) && !is_string_empty($matches[2]) && strposu($matches[1], "/")) {
                    list($entry, $flags) = $this->yellow->toolbox->getTextList($matches[2], ",", 2);
                    if (preg_match("/delete/i", $flags)) continue;
                    if (preg_match("/multi-language/i", $flags) && $this->yellow->lookup->isContentFile($matches[1])) {
                        foreach ($languages as $language) {
                            $pathLanguage = $language."/";
                            $data["$path$pathLanguage$entry"] = $pathBase."/".$pathLanguage.$entry;
                        }
                    } else {
                        $data["$path$entry"] = $pathBase."/".$entry;
                    }
                }
            }
        }
        return $data;
    }
    
    // Return standard installation file names required
    public function getStandardFileNamesRequired($path, $pathBase) {
        $data = array();
        $extension = "";
        $fileNameCurrent = $path.$this->yellow->system->get("coreExtensionDirectory").
            $this->yellow->system->get("updateInstalledFile");
        $fileData = $this->yellow->toolbox->readFile($fileNameCurrent);
        foreach ($this->yellow->toolbox->getTextLines($fileData) as $line) {
            if (preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches)) {
                if (lcfirst($matches[1])=="extension" && !is_string_empty($matches[2])) $extension = $matches[2];
                if (!is_string_empty($matches[1]) && !is_string_empty($matches[2]) && strposu($matches[1], "/")) {
                    list($entry, $flags) = $this->yellow->toolbox->getTextList($matches[2], ",", 2);
                    if (!preg_match("/create/i", $flags)) continue;
                    if (preg_match("/additional/i", $flags)) continue;
                    if ($fileNameCurrent==$path.$matches[1]) continue;
                    $fileNameSource = $pathBase."yellow-".strtoloweru($extension)."/".$entry;
                    $fileNameDestination = $path.$matches[1];
                    $data[$fileNameSource] = $fileNameDestination;
                }
            }
        }
        return $data;
    }
    
    // Return number of extensions in standard installation
    public function getStandardExtensionsCount($path) {
        $fileNameCurrent = $path.$this->yellow->system->get("coreExtensionDirectory").
            $this->yellow->system->get("updateInstalledFile");
        $fileDataCurrent = $this->yellow->toolbox->readFile($fileNameCurrent);
        $settingsCurrent = $this->yellow->toolbox->getTextSettings($fileDataCurrent, "extension");
        return count($settingsCurrent);
    }
}
