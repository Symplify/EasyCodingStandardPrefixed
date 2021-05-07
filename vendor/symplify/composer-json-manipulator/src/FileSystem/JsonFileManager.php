<?php

namespace Symplify\ComposerJsonManipulator\FileSystem;

use ECSPrefix20210507\Nette\Utils\Json;
use Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use Symplify\ComposerJsonManipulator\Json\JsonInliner;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\PackageBuilder\Configuration\StaticEolConfiguration;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Symplify\MonorepoBuilder\Tests\FileSystem\JsonFileManager\JsonFileManagerTest
 */
final class JsonFileManager
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var JsonCleaner
     */
    private $jsonCleaner;
    /**
     * @var JsonInliner
     */
    private $jsonInliner;
    /**
     * @var mixed[]
     */
    private $cachedJSONFiles = [];
    /**
     * @param \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem
     * @param \Symplify\ComposerJsonManipulator\Json\JsonCleaner $jsonCleaner
     * @param \Symplify\ComposerJsonManipulator\Json\JsonInliner $jsonInliner
     */
    public function __construct($smartFileSystem, $jsonCleaner, $jsonInliner)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->jsonCleaner = $jsonCleaner;
        $this->jsonInliner = $jsonInliner;
    }
    /**
     * @return mixed[]
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     */
    public function loadFromFileInfo($smartFileInfo)
    {
        $realPath = $smartFileInfo->getRealPath();
        if (!isset($this->cachedJSONFiles[$realPath])) {
            $this->cachedJSONFiles[$realPath] = Json::decode($smartFileInfo->getContents(), Json::FORCE_ARRAY);
        }
        return $this->cachedJSONFiles[$realPath];
    }
    /**
     * @return mixed[]
     * @param string $filePath
     */
    public function loadFromFilePath($filePath)
    {
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return Json::decode($fileContent, Json::FORCE_ARRAY);
    }
    /**
     * @param mixed[] $json
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     * @return string
     */
    public function printJsonToFileInfo(array $json, $smartFileInfo)
    {
        $jsonString = $this->encodeJsonToFileContent($json);
        $this->smartFileSystem->dumpFile($smartFileInfo->getPathname(), $jsonString);
        return $jsonString;
    }
    /**
     * @param \Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson
     * @param string $filePath
     * @return string
     */
    public function printComposerJsonToFilePath($composerJson, $filePath)
    {
        $jsonString = $this->encodeJsonToFileContent($composerJson->getJsonArray());
        $this->smartFileSystem->dumpFile($filePath, $jsonString);
        return $jsonString;
    }
    /**
     * @param mixed[] $json
     * @return string
     */
    public function encodeJsonToFileContent(array $json)
    {
        // Empty arrays may lead to bad encoding since we can't be sure whether they need to be arrays or objects.
        $json = $this->jsonCleaner->removeEmptyKeysFromJsonArray($json);
        $jsonContent = Json::encode($json, Json::PRETTY) . StaticEolConfiguration::getEolChar();
        return $this->jsonInliner->inlineSections($jsonContent);
    }
}
